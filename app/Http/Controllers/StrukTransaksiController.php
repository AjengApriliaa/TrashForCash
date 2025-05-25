<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Transaksi;

class StrukTransaksiController extends Controller
{
    public function show($id)
    {
        $transaksi = Transaksi::with('user')->findOrFail($id);
        return view('Struk', compact('transaksi'));
    }
}
