<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Transaksi;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;


class TransaksiController extends Controller
{
    // Menampilkan daftar transaksi user
    public function index()
    {
        $transaksis = Transaksi::where('user_id', Auth::id())
                               ->with('user')
                               ->orderBy('created_at', 'desc')
                               ->get();
        return view('Transaksi', compact('transaksis'));
    }

    // Menampilkan form antar (buang sampah)
    public function formAntar()
    {
        return view('Buangsampah');
    }

    // Menampilkan form jemput
    public function formJemput()
    {
        return view('Jemput');
    }

    // Menyimpan transaksi (baik antar maupun jemput)
    public function store(Request $request)
    {
        // Validasi input
        $validated = $request->validate([
            'layanan' => 'required|in:antar,jemput',
            'lokasi' => 'required|string|max:255',
            'latitude' => 'nullable|numeric',
            'longitude' => 'nullable|numeric',
            'berat' => 'required|numeric|min:1',
            'bukti_foto' => 'required_if:layanan,antar|image|mimes:jpeg,png,jpg|max:2048',
            'foto' => 'required_if:layanan,jemput|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        try {
            // Handle file upload
            $fotoPath = null;
            if ($request->hasFile('bukti_foto')) {
                $fotoPath = $request->file('bukti_foto')->store('transaksi/bukti', 'public');
            } elseif ($request->hasFile('foto')) {
                $fotoPath = $request->file('foto')->store('transaksi/foto', 'public');
            }

            // Hitung estimasi koin (1 gram = 2 koin)
            $estimasiKoin = $validated['berat'] * 2;

            // Ambil alamat user dari profile
            $user = Auth::user();
            $alamatUser = $user->alamat ?? 'Alamat tidak tersedia';

            // Tentukan lokasi_antar untuk layanan antar
            $lokasiAntar = null;
            if ($validated['layanan'] === 'antar') {
                $lokasiAntar = $validated['lokasi'];
            }

            // Simpan transaksi
            $transaksi = Transaksi::create([
                'user_id' => Auth::id(),
                'layanan' => $validated['layanan'],
                'alamat' => $alamatUser,
                'lokasi' => $validated['lokasi'],
                'latitude' => $validated['latitude'],
                'longitude' => $validated['longitude'],
                'berat' => $validated['berat'],
                'tanggal' => Carbon::now()->toDateString(),
                'estimasi_koin' => $estimasiKoin,
                'bukti_foto' => $fotoPath,
                'status' => 'pending',
                'lokasi_antar' => $lokasiAntar,
            ]);



            // Redirect dengan pesan sukses
            if ($validated['layanan'] === 'antar') {
                return redirect()->route('buang.sampah')->with('success', 'Transaksi antar sampah berhasil dibuat!');
            } else {
                return redirect()->route('jemput.sampah')->with('success', 'Permintaan jemput sampah berhasil dibuat!');
            }

        } catch (\Exception $e) {
            return back()->withErrors(['error' => 'Terjadi kesalahan: ' . $e->getMessage()])->withInput();
        }
    }

    // Menampilkan riwayat transaksi selesai
    public function riwayat()
    {
        $transaksis = Transaksi::where('user_id', Auth::id())
                               ->whereIn('status', ['completed', 'cancelled'])
                               ->with('user')
                               ->orderBy('tanggal', 'desc')
                               ->get();
        return view('Riwayattransaksi', compact('transaksis'));
    }

    // Update status (termasuk pembatalan)
    public function updateStatus(Request $request, $id)
    {
        $transaksi = Transaksi::where('id', $id)
                              ->where('user_id', Auth::id())
                              ->firstOrFail();

        $validated = $request->validate([
            'status' => 'required|in:pending,processing,completed,cancelled'
        ]);

        $transaksi->update($validated);

        return response()->json([
            'success' => true,
            'message' => 'Status transaksi berhasil diupdate!'
        ]);
    }

    // Batalkan transaksi
    public function cancel($id)
    {
        $transaksi = Transaksi::where('id', $id)
                              ->where('user_id', Auth::id())
                              ->where('status', 'pending')
                              ->firstOrFail();

        $transaksi->update(['status' => 'cancelled']);

        return back()->with('success', 'Transaksi berhasil dibatalkan!');
    }
    
    
}