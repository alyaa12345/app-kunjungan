<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PetugasController;
use App\Http\Controllers\MasyarakatController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// 1. Halaman Depan
Route::get('/', function () {
    return view('welcome');
});

// 2. Group Auth (Harus Login Dulu)
Route::middleware(['auth', 'verified'])->group(function () {

    // --- DASHBOARD REDIRECT ---
    Route::get('/dashboard', function () {
        $role = auth()->user()->role;

        if ($role === 'masyarakat') {
            return redirect()->route('masyarakat.index');
        } elseif ($role === 'petugas') {
            return redirect()->route('petugas.index');
        } else {
            // Default jika role lain (misal: kepala)
            return view('dashboard');
        }
    })->name('dashboard');

    // --- RUTE MASYARAKAT ---
    Route::middleware(['auth', 'role:masyarakat'])->prefix('masyarakat')->name('masyarakat.')->group(function () {

        // Halaman Utama (Form Input)
        Route::get('/', [MasyarakatController::class, 'index'])->name('index');
        Route::post('/', [MasyarakatController::class, 'store'])->name('store');
        Route::get('/tiket/{id}', [MasyarakatController::class, 'show'])->name('show');

        // === TAMBAHKAN BARIS INI ===
        Route::get('/riwayat', [MasyarakatController::class, 'riwayat'])->name('riwayat');
    });

    // --- RUTE PETUGAS ---
    Route::middleware(['auth', 'role:petugas'])->prefix('petugas')->name('petugas.')->group(function () {
        Route::get('/', [PetugasController::class, 'index'])->name('index');
        Route::get('/gate', [PetugasController::class, 'gate'])->name('gate'); // HALAMAN GATE
        Route::get('/cek-qr', [PetugasController::class, 'checkQr'])->name('checkQr'); // API SCANNER

        Route::get('/riwayat', [PetugasController::class, 'riwayat'])->name('riwayat');
        Route::patch('/verifikasi/{id}', [PetugasController::class, 'updateStatus'])->name('updateStatus');
        Route::get('/laporan', [PetugasController::class, 'laporan'])->name('laporan');
    });

    // --- RUTE KEPALA ---
    Route::middleware(['role:kepala'])->prefix('kepala')->name('kepala.')->group(function () {
        Route::get('/', function () {
            return "Halaman Laporan Kepala";
        })->name('index');
    });

    // --- PROFILE USER ---
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';
