<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Transaksi;

class DashboardController extends Controller
{
    public function index()
    {
        $jumlahPengguna = User::count();
        $jumlahPenggunaAktif = User::whereNotNull('email_verified_at')->count(); // dianggap aktif jika email terverifikasi
        $jumlahTransaksi = Transaksi::count();

        return view('dashboardadmin', compact(
            'jumlahPengguna',
            'jumlahPenggunaAktif',
            'jumlahTransaksi'
        ));
    }
}
