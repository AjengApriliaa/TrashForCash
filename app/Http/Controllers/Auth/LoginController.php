<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class LoginController extends Controller
{
    public function customLogin(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            // Verifikasi juga nama-nya cocok
            $user = Auth::user();
            if ($user->name === $request->name) {
                return redirect()->intended('/dashboard');
            } else {
                Auth::logout();
                return redirect()->back()->with('error', 'Nama tidak sesuai.');
            }
        }

        return redirect()->back()->with('error', 'Email atau password salah.');
    }
}
