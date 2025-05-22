<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function profile()
    {
        $user = Auth::user();
        return view('Edit', compact('user'));
    }

    public function update(Request $request)
{
    $user = Auth::user();

    // Validasi input
    $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|email',
        'alamat' => 'nullable|string|max:255',
        'telepon' => 'nullable|string|max:20',
        'jenis_kelamin' => 'nullable|in:Laki-Laki,Perempuan,Lainnya',
        'tanggal_lahir' => 'nullable|date',
        'foto' => 'nullable|image|mimes:jpg,jpeg,png|max:2048', // Validasi foto
    ]);

    // Upload foto jika ada
    if ($request->hasFile('foto')) {
        $fotoBaru = $request->file('foto')->store('foto-profil', 'public');
        $user->foto = $fotoBaru;
    }

    // Simpan data lain
    $user->name = $request->name;
    $user->email = $request->email;
    $user->alamat = $request->alamat;
    $user->telepon = $request->telepon;
    $user->jenis_kelamin = $request->jenis_kelamin;
    $user->tanggal_lahir = $request->tanggal_lahir;
    
    $user->save();

    return redirect()->route('user.profile')->with('success', 'Profil berhasil diperbarui!');
}
}
