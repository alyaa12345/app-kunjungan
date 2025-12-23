<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PetugasController;

// Halaman Depan (Bisa diakses siapa saja)
Route::get('/', function () {
    return view('welcome');
});

// Group untuk User yang SUDAH LOGIN
Route::middleware(['auth', 'verified'])->group(function () {

    // --- DASHBOARD UMUM (Redirect sesuai role) ---
    Route::get('/dashboard', function () {
        $role = auth()->user()->role;
        if ($role === 'masyarakat') {
            return redirect()->route('masyarakat.index');
        } elseif ($role === 'petugas') {
            return redirect()->route('petugas.index');
        } else {
            return view('dashboard'); // Default untuk Kepala/Lainnya
        }
    })->name('dashboard');

    // --- AREA MASYARAKAT ---
    Route::middleware(['role:masyarakat'])->prefix('masyarakat')->name('masyarakat.')->group(function () {
        // Nanti kita buat Controllernya
        Route::get('/', function () {
            return "Halaman Masyarakat (Permohonan)";
        })->name('index');
    });

    // --- AREA PETUGAS ---
    // --- AREA PETUGAS ---
    Route::middleware(['role:petugas'])->prefix('petugas')->name('petugas.')->group(function () {

        // Dashboard (Daftar Menunggu)
        Route::get('/', [PetugasController::class, 'index'])->name('index');

        // Aksi Update Status (Terima/Tolak)
        Route::patch('/{id}/update', [PetugasController::class, 'updateStatus'])->name('update.status');

        // Halaman Riwayat
        Route::get('/riwayat', [PetugasController::class, 'riwayat'])->name('riwayat');
    });

    // --- AREA KEPALA ---
    Route::middleware(['role:kepala'])->prefix('kepala')->name('kepala.')->group(function () {
        Route::get('/', function () {
            return "Halaman Kepala (Laporan)";
        })->name('index');
    });

    // Profile Bawaan Breeze
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';
