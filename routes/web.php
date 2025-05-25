<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\WithdrawController;
use App\Http\Controllers\RiwayatController;
use App\Http\Controllers\TransaksiController;
use App\Http\Controllers\AdminLoginController;
use App\Http\Controllers\AdminTransaksiController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\AdminUserController;
use App\Http\Controllers\StrukTransaksiController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// =====================
// Public Pages (Tanpa Login)
// =====================
Route::get('/', fn() => view('Home'));
Route::get('/Login', fn() => view('Login'));
Route::get('/Signup', fn() => view('Signup'));
Route::get('/Logout', fn() => view('Login'));

// =====================
// Halaman Utama User (Setelah Login)
// =====================
Route::get('/dashboard', fn() => view('Dashboard'))->middleware('auth')->name('dashboard');

Route::get('/Buangsampah', [TransaksiController::class, 'formAntar'])->name('buang.sampah');
Route::get('/Jemput', [TransaksiController::class, 'formJemput'])->name('jemput.sampah');
Route::get('/Bantuan', fn() => view('Bantuan'))->name('bantuan');
Route::get('/Kontakkami', fn() => view('Kontakkami'))->name('kontak');
Route::get('/Koin', fn() => view('Koin'))->name('koin');

// =====================
// Transaksi User
// =====================
Route::prefix('transaksi')->group(function () {
    Route::get('/', [TransaksiController::class, 'index'])->name('transaksi.index');
    Route::post('/store', [TransaksiController::class, 'store'])->name('transaksi.store');
    Route::patch('/{id}/cancel', [TransaksiController::class, 'cancel'])->name('transaksi.cancel');
    Route::patch('/{id}/status', [TransaksiController::class, 'updateStatus'])->name('transaksi.updateStatus');
});

Route::get('/Transaksi', [TransaksiController::class, 'index'])->name('transaksi.list');
Route::get('/Riwayattransaksi', [TransaksiController::class, 'riwayat'])->name('riwayat.transaksi');

// =====================
// Riwayat Penukaran & Withdraw
// =====================
Route::get('/Riwayatpenukaran', [RiwayatController::class, 'riwayatPenukaran'])->name('riwayat.penukaran');
Route::get('/Withdraw', [WithdrawController::class, 'index'])->name('withdraw.index');
Route::post('/Withdraw', [WithdrawController::class, 'send'])->name('withdraw.send');

// =====================
// Auth User
// =====================
Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register']);

Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [LoginController::class, 'customLogin'])->name('login.custom');

Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// =====================
// Profile User
// =====================
Route::middleware('auth')->group(function () {
    Route::get('/Edit', [ProfileController::class, 'edit'])->name('user.profile');
    Route::post('/Edit', [ProfileController::class, 'update'])->name('user.profile.update');

    Route::get('/profile', [UserController::class, 'profile'])->name('user.profile.view');
    Route::post('/profile/update', [UserController::class, 'update'])->name('user.profile.update2');
});

// =====================
// Admin Login
// =====================
Route::get('/admin/login', [AdminLoginController::class, 'loginForm'])->name('admin.login.form');
Route::post('/admin/login', [AdminLoginController::class, 'login'])->name('admin.login');
Route::post('/admin/logout', [AdminLoginController::class, 'logout'])->name('admin.logout');

// =====================
// Admin Area (Protected by auth:admin)
// =====================
Route::prefix('admin')->middleware('auth:admin')->group(function () {

    // Transaksi
    Route::get('/faktur-transaksi', [AdminTransaksiController::class, 'index'])->name('admin.transaksi.index');
    Route::post('/transaksi/{id}/verifikasi', [AdminTransaksiController::class, 'verifikasi'])->name('admin.transaksi.verifikasi');
    Route::get('/riwayat-transaksi', [AdminTransaksiController::class, 'riwayat'])->name('admin.transaksi.riwayat');

    // Kelola User
    Route::get('/kelola-user', [AdminTransaksiController::class, 'kelolaUser'])->name('admin.kelolauser');
});


Route::middleware(['auth:admin'])->group(function () {
    Route::get('/admin/dashboardadmin', [DashboardController::class, 'index'])->name('admin.dashboard');
});

Route::prefix('admin')->middleware('auth')->group(function () {
    Route::get('/user/{id}', [AdminUserController::class, 'show'])->name('admin.user.show');
    Route::put('/user/{id}', [AdminUserController::class, 'update'])->name('admin.user.update');
    Route::delete('/user/{id}', [AdminUserController::class, 'destroy'])->name('admin.user.destroy');
});

Route::get('/admin/transaksi/struk/{id}', [StrukTransaksiController::class, 'show'])->name('admin.transaksi.struk');
