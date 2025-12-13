<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\EmailVerificationRequest;

// Controller Imports
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\KasusController;
use App\Http\Controllers\KorbanController;
use App\Http\Controllers\PelakuController;
use App\Http\Controllers\BuktiController;
use App\Http\Controllers\TindakanController;
use App\Http\Controllers\LaporanController;

/*
|--------------------------------------------------------------------------
| 1. PUBLIC ROUTES (Bisa Diakses Siapa Saja)
|--------------------------------------------------------------------------
*/

// Halaman Depan (Landing Page Masyarakat)
Route::get('/', function () {
    return view('welcome');
})->name('home');

// Proses Kirim Aduan dari Masyarakat (Tanpa Login)
// Menggunakan controller yang sama, tapi lewat route khusus public
Route::post('/kirim-aduan', [LaporanController::class, 'store'])->name('laporan.store.public');


/*
|--------------------------------------------------------------------------
| 2. GUEST ROUTES (Hanya untuk yang Belum Login)
|--------------------------------------------------------------------------
*/
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register'])
        ->middleware('throttle:3,1'); // Limit: Maks 3x register per menit
});


/*
|--------------------------------------------------------------------------
| 3. AUTH ROUTES (Sudah Login)
|--------------------------------------------------------------------------
*/
Route::middleware('auth')->group(function () {

    // Logout
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    // --- LOGIKA VERIFIKASI EMAIL ---
    
    // 1. Tampilan "Silakan Cek Email"
    Route::get('/email/verify', function () {
        return view('auth.verify-email');
    })->name('verification.notice');

    // 2. Proses Link dari Email (Saat user klik link di inbox)
    Route::get('/email/verify/{id}/{hash}', function (EmailVerificationRequest $request) {
        $request->fulfill();
        return redirect()->route('dashboard')->with('success', 'Selamat! Akun Anda telah berhasil diverifikasi.');
    })->middleware(['signed'])->name('verification.verify');

    // 3. Tombol "Kirim Ulang Email"
    Route::post('/email/verification-notification', function (Request $request) {
        $request->user()->sendEmailVerificationNotification();
        return back()->with('message', 'Link verifikasi baru telah dikirim!');
    })->middleware(['throttle:6,1'])->name('verification.send');


    /*
    |--------------------------------------------------------------------------
    | 4. VERIFIED ROUTES (Login + Email Verified) -> ADMIN AREA
    |--------------------------------------------------------------------------
    */
    Route::middleware(['verified', 'is_admin'])->group(function () {
        
        // Dashboard Admin
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

        // Resource Routes (Hanya Admin yang boleh akses)
        Route::resource('kasus', KasusController::class);
        Route::resource('korban', KorbanController::class);
        Route::resource('pelaku', PelakuController::class);
        Route::resource('bukti', BuktiController::class);
        Route::resource('tindakan', TindakanController::class);
        Route::resource('laporan', LaporanController::class);
    });

});