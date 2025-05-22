<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    public function edit()
    {
        $user = Auth::user();
        return view('Edit', compact('user'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'name'           => 'required|string|max:255',
            'email'          => 'required|email|max:255',
            'alamat'         => 'nullable|string|max:255',
            'telepon'        => 'nullable|string|max:20',
            'jenis_kelamin'  => 'nullable|in:Laki-Laki,Perempuan,Lainnya',
            'tanggal_lahir'  => 'nullable|date',
        ]);

        $user = Auth::user();
        $user->update($request->only(['name', 'email', 'alamat', 'telepon', 'jenis_kelamin', 'tanggal_lahir']));

        return redirect()->route('user.profile')->with('success', 'Profil berhasil diperbarui.');
    }
}

