<?php

namespace App\Http\Controllers;

use App\Models\Withdraw;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;

class WithdrawController extends Controller
{
    // Mapping koin ke nominal rupiah
    protected $coinToRupiah = [
        1000 => 20000,
        1500 => 30000,
        2000 => 40000,
        2500 => 50000,
        3000 => 60000,
        3500 => 70000,
    ];

    public function index(Request $request)
    {
        $amount = $request->amount ?? null;
        return view('withdraw', ['amount' => $amount]);
    }

    public function send(Request $request)
    {
        try {
            // Validasi input
            $request->validate([
                'beneficiary_name' => 'required|string|max:255',
                'beneficiary_account' => 'required|string',
                'beneficiary_bank' => 'required|string',
                'beneficiary_email' => 'required|email',
                'amount' => 'required|numeric|min:10000',
                'notes' => 'nullable|string|max:255',
            ]);

            // Periksa apakah user terautentikasi
            if (!Auth::check()) {
                return back()->withInput()
                    ->withErrors(['auth' => 'Anda harus login untuk melakukan withdraw.']);
            }

            // Periksa saldo koin user
            $user = Auth::user();
            $amount = (int) $request->amount;
            
            // Hitung koin yang dibutuhkan berdasarkan nominal withdraw
            $requiredCoin = $this->calculateRequiredCoin($amount);
            
            // Periksa saldo koin user (asumsi saldo koin disimpan di user->coin)
            $userCoin = $user->coin ?? 0;
            
            if ($userCoin < $requiredCoin) {
                return back()->withInput()
                    ->withErrors(['coin' => 'Saldo koin Anda tidak mencukupi untuk melakukan withdraw sebesar Rp ' . number_format($amount, 0, ',', '.')]);
            }

            // Mapping bank name ke channel_code Xendit
            $bankCodeMap = [
                'bca' => 'ID_BCA',
                'bni' => 'ID_BNI',
                'bri' => 'ID_BRI',
                'mandiri' => 'ID_MANDIRI',
                // Tambahkan lainnya sesuai kebutuhan
            ];

            $bankName = strtolower($request->beneficiary_bank);
            $channelCode = $bankCodeMap[$bankName] ?? null;

            if (!$channelCode) {
                return back()->withErrors(['beneficiary_bank' => 'Bank yang dipilih tidak valid atau belum didukung.']);
            }

            // Buat reference ID unik
            $referenceId = 'disb-' . now()->timestamp . '-' . Str::random(8);

            // Siapkan payload ke Xendit
            $payload = [
                'reference_id' => $referenceId,
                'channel_code' => $channelCode,
                'channel_properties' => [
                    'account_number' => $request->beneficiary_account,
                    'account_holder_name' => $request->beneficiary_name,
                ],
                'amount' => $amount,
                'description' => $request->notes ?? 'Withdraw TrashForCash',
                'currency' => 'IDR',
                'receipt_notification' => [
                    'email_to' => [$request->beneficiary_email],
                    'email_cc' => [],
                    'email_bcc' => [],
                ],
                'metadata' => [
                    'app' => 'TrashForCash',
                    'user_id' => $user->id,
                ]
            ];

            // Kirim request menggunakan Basic Auth
            $apiKey = env('SERVER_KEY');
            $response = Http::withBasicAuth($apiKey, '')
                ->withHeaders([
                    'Idempotency-Key' => (string) Str::uuid(), // unik untuk tiap request
                    'Content-Type' => 'application/json',
                ])
                ->post('https://api.xendit.co/v2/payouts', $payload);

            // Cek hasil response
            if (!$response->successful()) {
                $errorData = $response->json();
                Log::error('Xendit Withdraw Error:', $errorData);
                
                // Extract error message for better error handling
                $errorMessage = $this->extractErrorMessage($errorData);
                
                return back()->withInput()
                    ->withErrors(['xendit' => $errorMessage]);
            }

            // Ambil ID dari response Xendit
            $xenditResponse = $response->json();
            $xenditId = $xenditResponse['id'] ?? null;

            // Simpan data withdraw ke database
            $withdraw = new Withdraw([
                'user_id' => $user->id,
                'koin_ditukar' => $requiredCoin,
                'nominal' => $amount,
                'status' => 'pending', // Default status
            ]);
            $withdraw->save();

            // Update saldo koin user (kurangi koin yang digunakan)
            $user->coin = $userCoin - $requiredCoin;
            $user->save();

            // Log success response
            Log::info('Xendit Withdraw Success:', [
                'reference_id' => $payload['reference_id'],
                'xendit_id' => $xenditId,
                'withdraw_id' => $withdraw->id,
                'response' => $xenditResponse
            ]);

            return back()->with('success', 'Withdraw berhasil diproses. Silakan tunggu konfirmasi dari bank.');
        } catch (\Illuminate\Validation\ValidationException $e) {
            // Catch validation errors
            return back()->withErrors($e->validator)->withInput();
        } catch (\Exception $e) {
            // Catch all other errors
            Log::error('Xendit Withdraw Exception:', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return back()->withInput()
                ->withErrors(['xendit' => 'Terjadi kesalahan saat memproses permintaan withdraw. Silakan coba lagi nanti.']);
        }
    }

    /**
     * Calculate required coin based on withdraw amount
     * 
     * @param int $amount
     * @return int
     */
    private function calculateRequiredCoin($amount)
    {
        // Cari koin yang dibutuhkan dari mapping
        $coin = null;
        
        // Cari apakah nominal ada dalam mapping langsung
        foreach ($this->coinToRupiah as $coinValue => $rupiahValue) {
            if ($rupiahValue == $amount) {
                return $coinValue;
            }
        }
        
        // Jika tidak ada dalam mapping langsung, hitung berdasarkan rasio
        // Misalnya 20.000 = 1000 koin, maka 1 koin = 20 rupiah
        return ceil($amount / 20);
    }

    /**
     * Extract readable error message from Xendit response
     * 
     * @param array $errorData
     * @return string
     */
    private function extractErrorMessage($errorData)
    {
        // Default error message
        $defaultMessage = 'Gagal melakukan withdraw. Silakan coba lagi nanti.';
        
        if (!is_array($errorData)) {
            return $defaultMessage;
        }
        
        // Check if there's a specific error message from Xendit
        if (isset($errorData['message'])) {
            $errorCode = $errorData['error_code'] ?? '';
            
            // Map common error codes to user-friendly messages
            switch ($errorCode) {
                case 'INVALID_ACCOUNT_NUMBER':
                    return 'Nomor rekening tidak valid. Silakan periksa kembali.';
                case 'INSUFFICIENT_BALANCE':
                    return 'Saldo tidak mencukupi untuk melakukan penarikan.';
                case 'DUPLICATE_REFERENCE_ID':
                    return 'Transaksi duplikat terdeteksi. Silakan coba lagi.';
                case 'ACCOUNT_NOT_FOUND':
                    return 'Akun bank tidak ditemukan. Silakan periksa kembali detail rekening.';
                case 'BANK_NOT_SUPPORTED':
                    return 'Bank yang dipilih tidak didukung untuk penarikan.';
                default:
                    // Return the actual error message if available
                    return $errorData['message'];
            }
        }
        
        return $defaultMessage;
    }
}