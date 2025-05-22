<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Transaksi;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class TransaksiController extends Controller
{
    use \Illuminate\Foundation\Validation\ValidatesRequests;

    /**
     * Tampilkan form layanan antar
     */
    public function formAntar()
    {
        $transaksis = Transaksi::where('user_id', auth()->id())->get();
        return view('Buangsampah', compact('transaksis'));   
    }

    /**
     * Tampilkan form layanan jemput
     */
    public function formJemput()
    {
        $transaksis = Transaksi::where('user_id', auth()->id())->get();
        return view('Jemput', compact('transaksis'));   
    }

    /**
     * Simpan transaksi dari form antar/jemput
     */
    public function simpan(Request $request)
    {
        $request->validate([
            'layanan' => 'required|in:antar,jemput',
            'lokasi' => 'required|string',
            'latitude' => 'required',
            'longitude' => 'required',
            'berat' => 'required|numeric|min:0',
        ]);

        if ($request->layanan == 'antar') {
            $request->validate([
                'bukti_foto' => 'required|image|max:2048',
            ]);
            $path = $request->file('bukti_foto')->store('bukti_antar', 'public');
        } else {
            $request->validate([
                'foto' => 'required|image|max:2048',
            ]);
            $path = $request->file('foto')->store('bukti_jemput', 'public');
        }

        $koin = $request->berat * 2;

        $transaksi = Transaksi::create([
            'user_id' => Auth::id(),
            'layanan' => $request->layanan,
            'lokasi' => $request->lokasi,
            'latitude' => $request->latitude,
            'longitude' => $request->longitude,
            'berat' => $request->berat,
            'koin' => $koin,
            'foto_path' => $path,
            'status' => 'pending',
        ]);

        $message = ($request->layanan == 'antar') 
            ? 'Permintaan pengantaran sampah berhasil dikirim.' 
            : 'Permintaan penjemputan sampah berhasil dikirim.';

        return redirect()->route('transaksi.index')->with('success', $message);
    }

    /**
     * Tampilkan transaksi aktif/pending
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
     * Tampilkan riwayat transaksi
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
     * Batalkan transaksi
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

