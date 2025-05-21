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
    
    public function formAntar()
    {
        return view('Buangsampah');
    }

    public function formJemput()
    {
        return view('Jemput');
    }

    public function simpan(Request $request)
    {
        // Validasi input berdasarkan form yang disubmit
        $request->validate([
            'layanan' => 'required|in:antar,jemput',
            'lokasi' => 'required|string',
            'latitude' => 'required',
            'longitude' => 'required',
            'berat' => 'required|numeric|min:0',
        ]);

        // Handle file upload based on layanan
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

        // Hitung koin yang didapat (2 koin per gram)
        $koin = $request->berat * 2;

        // Buat transaksi baru
        $transaksi = Transaksi::create([
            'user_id' => Auth::id(),
            'layanan' => $request->layanan,
            'lokasi' => $request->lokasi,
            'latitude' => $request->latitude,
            'longitude' => $request->longitude,
            'berat' => $request->berat,
            'koin' => $koin,
            'foto_path' => $path,
            'status' => 'pending', // Status awal
        ]);

        // Redirect berdasarkan jenis layanan
        $message = ($request->layanan == 'antar') ? 
            'Permintaan pengantaran sampah berhasil dikirim.' : 
            'Permintaan penjemputan sampah berhasil dikirim.';
            
        // Perbaikan di sini - menggunakan nama route yang benar
        return redirect()->route('transaksi.index')->with('success', $message);
    }
    
    public function index()
    {
        $transaksis = Transaksi::where('user_id', Auth::id())
                              ->where('status', 'pending')
                              ->orderBy('created_at', 'desc')
                              ->get();
                              
        return view('Transaksi', compact('transaksis'));
    }
    
    public function riwayat()
    {
        $transaksis = Transaksi::where('user_id', Auth::id())
                              ->whereIn('status', ['completed', 'cancelled'])
                              ->orderBy('created_at', 'desc')
                              ->get();
                              
        return view('Transaksi', compact('transaksis'));
    }
}