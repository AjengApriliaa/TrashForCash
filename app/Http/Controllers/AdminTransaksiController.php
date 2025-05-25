<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Transaksi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminTransaksiController extends Controller
{
    // Halaman Faktur Transaksi
    public function index()
    {
        $transaksis = Transaksi::with('user')->get(); // mengambil user juga
        return view('Fakturtransaksi', compact('transaksis'));
    }

    // Verifikasi Transaksi
    public function verifikasi($id)
    {
        $transaksi = Transaksi::with('user')->findOrFail($id);

        if ($transaksi->status === 'pending') {
            DB::transaction(function () use ($transaksi) {
                // Ubah status transaksi
                $transaksi->status = 'completed';
                $transaksi->save();

                // Tambahkan koin ke user
                $user = $transaksi->user;
                $user->coin += $transaksi->estimasi_koin;
                $user->save();
            });

            return redirect()->back()->with('success', 'Transaksi berhasil diverifikasi & koin ditambahkan.');
        }

        return redirect()->back()->with('error', 'Transaksi sudah diverifikasi sebelumnya.');
    }

    // Riwayat Transaksi
    public function riwayat()
    {
        $transaksis = Transaksi::with('user')->latest()->get();
        return view('Riwayattransaksiadmin', compact('transaksis'));
    }

    // Kelola User
    public function kelolaUser()
    {
        $users = User::all(); // ambil semua user
        return view('Datauser', compact('users'));
    }
}
