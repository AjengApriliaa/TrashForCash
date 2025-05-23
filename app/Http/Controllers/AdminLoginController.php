<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class AdminLoginController extends Controller
{
    public function showLoginForm()
    {
        // Buat akun admin jika belum ada
        if (!User::where('email', 'admin123@gmail.com')->exists()) {
            User::create([
                'name' => 'Admin',
                'email' => 'admin123@gmail.com',
                'password' => Hash::make('TrashForCash'),
                // jika ada kolom is_admin:
                // 'is_admin' => true,
            ]);
        }

        return view('admin.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            return redirect()->intended('/admin/dashboard');
        }

        return back()->withErrors([
            'email' => 'Email atau kata sandi salah.',
        ]);
    }
}
