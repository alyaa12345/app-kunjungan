<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

use App\Http\Controllers\KepalaController;
use App\Http\Controllers\PetugasController;
use App\Http\Controllers\MasyarakatController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    $role = Auth::user()->role;
    if ($role == 'kepala') {
        return redirect()->route('kepala.index');
    } elseif ($role == 'petugas') {
        return redirect()->route('petugas.index');
    } elseif ($role == 'masyarakat') {
        return redirect()->route('masyarakat.index');
    } else {
        Auth::logout();
        return abort(403, 'Role akun Anda tidak valid.');
    }
})->middleware(['auth', 'verified'])->name('dashboard');

// GROUP ROUTE: KEPALA
Route::middleware(['auth', 'role:kepala'])->prefix('kepala')->name('kepala.')->group(function () {
    Route::get('/', [KepalaController::class, 'index'])->name('index');
    Route::patch('/verifikasi/{id}', [KepalaController::class, 'updateStatus'])->name('updateStatus');
    Route::get('/laporan', [KepalaController::class, 'laporan'])->name('laporan');
});

// GROUP ROUTE: PETUGAS
Route::middleware(['auth', 'role:petugas'])->prefix('petugas')->name('petugas.')->group(function () {
    Route::get('/', [PetugasController::class, 'index'])->name('index');
    Route::patch('/verifikasi/{id}', [PetugasController::class, 'updateStatus'])->name('updateStatus');
    Route::get('/riwayat', [PetugasController::class, 'riwayat'])->name('riwayat');
    Route::get('/riwayat', [PetugasController::class, 'riwayat'])->name('riwayat');
    Route::get('/gate-check', [PetugasController::class, 'gateCheck'])->name('gate');
    Route::get('/laporan', [PetugasController::class, 'laporan'])->name('laporan');
});

// GROUP ROUTE: MASYARAKAT
Route::middleware(['auth', 'role:masyarakat'])->prefix('masyarakat')->name('masyarakat.')->group(function () {
    Route::get('/', [MasyarakatController::class, 'index'])->name('index');
    Route::get('/ajukan', [MasyarakatController::class, 'create'])->name('create');
    Route::post('/', [MasyarakatController::class, 'store'])->name('store');
    Route::get('/riwayat', [MasyarakatController::class, 'riwayat'])->name('riwayat');
    Route::get('/tiket/{id}', [MasyarakatController::class, 'show'])->name('show');

    // --- PERBAIKAN DI SINI ---
    // Sesuai dengan controller: laporan($jenis)
    Route::get('/laporan/{jenis}', [MasyarakatController::class, 'laporan'])->name('laporan');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';
