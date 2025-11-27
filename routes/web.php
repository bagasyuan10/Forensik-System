<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\KasusController;
use App\Http\Controllers\BuktiController;
use App\Http\Controllers\KorbanController;
use App\Http\Controllers\PelakuController;
use App\Http\Controllers\TindakanController;
use App\Http\Controllers\LaporanController;
use App\Http\Controllers\DashboardController;

Route::resource('kasus', KasusController::class);
Route::resource('korban', KorbanController::class);
Route::resource('pelaku', PelakuController::class);
Route::resource('tindakan', TindakanController::class);
Route::resource('laporan', LaporanController::class);

//Dashboard Route
Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

//Bukti Roueter
Route::get('/bukti', [BuktiController::class, 'index'])->name('bukti.index');
Route::get('/bukti/tambah', [BuktiController::class, 'create'])->name('bukti.create');
Route::post('/bukti', [BuktiController::class, 'store'])->name('bukti.store');
Route::get('/bukti/{id}/edit', [BuktiController::class, 'edit'])->name('bukti.edit');
Route::put('/bukti/{id}', [BuktiController::class, 'update'])->name('bukti.update');
Route::delete('/bukti/{id}', [BuktiController::class, 'destroy'])->name('bukti.destroy');

//Korban Roueter
Route::resource('korban', App\Http\Controllers\KorbanController::class);
Route::resource('korban', KorbanController::class);