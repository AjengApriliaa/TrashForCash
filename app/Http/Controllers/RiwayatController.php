<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Withdraw;
use Illuminate\Support\Facades\Auth;

class RiwayatController extends Controller
{

public function riwayatPenukaran()
{
    $user = Auth::user();

    // Ambil data withdraw milik user saat ini
    $penukaranKoin = Withdraw::where('user_id', $user->id)->orderBy('created_at', 'desc')->get();

    return view('riwayatpenukaran', compact('penukaranKoin'));
}

}


