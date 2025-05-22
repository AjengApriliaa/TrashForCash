<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Transaksi;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class TransaksiController extends Controller
{
    use \Illuminate\Foundation\Validation\ValidatesRequests;
    
    /**
     * Display the form for "Antar Sampah"
     */
    public function formAntar()
    {

     $transaksis = Transaksi::where('user_id', auth()->id())->get();
     return view('Buangsampah', compact('transaksis'));   

     }

    /**
     * Display the form for "Jemput Sampah"
     */
    public function formJemput()
    {

     $transaksis = Transaksi::where('user_id', auth()->id())->get();
     return view('Jemput', compact('transaksis'));   

    }

    /**
     * Save a new transaction from either "Antar" or "Jemput" form
     */
    public function simpan(Request $request)
    {
        // Validate common fields
        $request->validate([
            'layanan' => 'required|in:antar,jemput',
            'lokasi' => 'required|string',
            'latitude' => 'required',
            'longitude' => 'required',
            'berat' => 'required|numeric|min:0',
        ]);

        // Handle file upload based on layanan type
        if ($request->layanan == 'antar') {
            $request->validate([
                'bukti_foto' => 'required|image|max:2048', // Max 2MB
            ]);
            
            $path = $request->file('bukti_foto')->store('bukti_antar', 'public');
        } else { // jemput
            $request->validate([
                'foto' => 'required|image|max:2048', // Max 2MB
            ]);
            
            $path = $request->file('foto')->store('bukti_jemput', 'public');
        }

        // Calculate coins earned (2 coins per gram)
        $koin = $request->berat * 2;

        // Create new transaction
        $transaksi = Transaksi::create([
            'user_id' => Auth::id(),
            'layanan' => $request->layanan,
            'lokasi' => $request->lokasi,
            'latitude' => $request->latitude,
            'longitude' => $request->longitude,
            'berat' => $request->berat,
            'koin' => $koin,
            'foto_path' => $path,
            'status' => 'pending', // Initial status
        ]);

        // Set success message based on service type
        $message = ($request->layanan == 'antar') ? 
            'Permintaan pengantaran sampah berhasil dikirim.' : 
            'Permintaan penjemputan sampah berhasil dikirim.';
            
        return redirect()->route('transaksi.index')->with('success', $message);
    }
    
    /**
     * Display active/pending transactions
     */
    public function index()
    {
        $transaksis = Transaksi::where('user_id', Auth::id())
                              ->whereIn('status', ['pending', 'processing'])
                              ->orderBy('created_at', 'desc')
                              ->get();
                              
        return view('Transaksi', compact('transaksis'));
    }
    
    /**
     * Display transaction history (completed or cancelled)
     */
    public function riwayat()
    {
        $transaksis = Transaksi::where('user_id', Auth::id())
                              ->whereIn('status', ['completed', 'cancelled'])
                              ->orderBy('created_at', 'desc')
                              ->get();
                              
        return view('Riwayattransaksi', compact('transaksis'));
    }
    
    /**
     * Cancel a transaction
     */
    public function cancel($id)
    {
        $transaksi = Transaksi::where('id', $id)
                            ->where('user_id', Auth::id())
                            ->where('status', 'pending')
                            ->firstOrFail();
                            
        $transaksi->status = 'cancelled';
        $transaksi->save();
        
        return redirect()->route('transaksi.index')
                       ->with('success', 'Transaksi berhasil dibatalkan.');
    }
}