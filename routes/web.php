<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\KasusController;
use App\Http\Controllers\KorbanController;
use App\Http\Controllers\PelakuController;
use App\Http\Controllers\BuktiController;
use App\Http\Controllers\TindakanController;
use App\Http\Controllers\LaporanController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;

// Pastikan route ini ada:
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::get('/', fn() => redirect('/dashboard'));


Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

// CRUD KASUS
Route::resource('kasus', KasusController::class);

// CRUD KORBAN
Route::resource('korban', KorbanController::class);

// CRUD PELAKU
Route::resource('pelaku', PelakuController::class);

// CRUD BUKTI
Route::resource('bukti', BuktiController::class);

// CRUD TINDAKAN
Route::resource('tindakan', TindakanController::class);

// CRUD LAPORAN
Route::resource('laporan', LaporanController::class);

//CRUD USER
Route::post('/logout', function () {
    Auth::logout();
    
    // Gunakan helper request() (huruf kecil) agar tidak error
    request()->session()->invalidate();
    request()->session()->regenerateToken();

    return redirect('/login');
})->name('logout');

// Route untuk Menampilkan Halaman Login
Route::get('/login', function () {
    return view('layouts.login'); // <--- Mengarah ke folder layouts/login.blade.php
})->name('login');

// Route untuk Menampilkan Halaman Register
Route::get('/register', function () {
    return view('layouts.register'); // <--- Mengarah ke folder layouts/register.blade.php
})->name('register');