<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/', function () {
    return view('Home'); 
});

Route::get('Login', function () {
    return view('Login'); 
});
Route::get('Signup', function () {
    return view('Signup'); 
});
Route::get('Dashboard', function () {
    return view('Dashboard'); 
});
Route::get('Buangsampah', function () {
    return view('Buangsampah'); 
});
Route::get('Jemput', function () {
    return view('Jemput'); 
}); 
Route::get('Bantuan', function () {
    return view('Bantuan'); 
}); 
Route::get('Kontakkami', function () {
    return view('Kontakkami'); 
}); 
Route::get('Koin', function () {
    return view('Koin'); 
}); 
Route::get('Riwayattransaksi', function () {
    return view('Riwayattransaksi'); 
}); 
Route::get('Riwayatpenukaran', function () {
    return view('Riwayatpenukaran'); 
}); 
Route::get('Withdraw', function () {
    return view('Withdraw'); 
}); 
Route::get('Transaksi', function () {
    return view('Transaksi'); 
}); 

use App\Http\Controllers\AuthController;

Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register']);

Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);

Route::post('/logout', [AuthController::class, 'logout'])->name('logout');


use App\Http\Controllers\Auth\LoginController;

Route::post('/login', [LoginController::class, 'customLogin'])->name('login.custom');
Route::get('/dashboard', function () {
    return view('Dashboard');
})->middleware('auth')->name('dashboard');

use App\Http\Controllers\ProfileController;

Route::middleware(['auth'])->group(function () {
    Route::get('/Edit', [ProfileController::class, 'edit'])->name('user.profile');
    Route::post('/Edit', [ProfileController::class, 'update'])->name('user.profile.update');
});

use App\Http\Controllers\UserController;

Route::middleware(['auth'])->group(function () {
    Route::get('/profile', [UserController::class, 'profile'])->name('user.profile');
    Route::post('/profile/update', action: [UserController::class, 'update'])->name('user.profile.update');
});

use App\Http\Controllers\WithdrawController;

Route::get('/withdraw', [WithdrawController::class, 'index'])->name('withdraw.index');
Route::post('/withdraw', [WithdrawController::class, 'send'])->name('withdraw.send');

use App\Http\Controllers\RiwayatController;

Route::get('/Riwayatpenukaran', [RiwayatController::class, 'riwayatPenukaran'])->name('riwayat.penukaran');



use App\Http\Controllers\TransaksiController;

Route::middleware(['auth'])->group(function () {
    // Rute yang sudah ada
    Route::get('/Transaksi', [TransaksiController::class, 'index'])->name('transaksi.index');
    Route::post('/Transaksi', [TransaksiController::class, 'simpan'])->name('transaksi.simpan');
    Route::put('/Transaksi/{id}/cancel', [TransaksiController::class, 'cancel'])->name('transaksi.cancel');

    // Rute yang mungkin perlu ditambahkan
    Route::get('/buang-sampah', [TransaksiController::class, 'formAntar'])->name('buang.sampah');
    Route::get('/jemput-sampah', [TransaksiController::class, 'formJemput'])->name('jemput.sampah');
    Route::get('/transaksi/riwayat', [TransaksiController::class, 'riwayat'])->name('transaksi.riwayat');
});