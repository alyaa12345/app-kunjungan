<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

use App\Http\Controllers\KepalaController;
use App\Http\Controllers\PetugasController;
use App\Http\Controllers\MasyarakatController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return view('welcome');
});

// DASHBOARD REDIRECTOR (Mengarahkan user sesuai role saat login)
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


// ====================================================
// GROUP ROUTE: KEPALA
// ====================================================
Route::middleware(['auth', 'role:kepala'])->prefix('kepala')->name('kepala.')->group(function () {
    // Dashboard Kepala
    Route::get('/', [KepalaController::class, 'index'])->name('index');

    // Laporan Evaluasi (Untuk Pimpinan)
    Route::get('/laporan', [KepalaController::class, 'laporan'])->name('laporan.index');
});


// ====================================================
// GROUP ROUTE: PETUGAS
// ====================================================
Route::middleware(['auth', 'role:petugas'])->prefix('petugas')->name('petugas.')->group(function () {
    // Dashboard & Meja Verifikasi
    Route::get('/', [PetugasController::class, 'index'])->name('index');

    // Proses Verifikasi (Setujui/Tolak) - Menggunakan PUT/PATCH
    Route::put('/verifikasi/{id}', [PetugasController::class, 'updateStatus'])->name('update');

    // Riwayat Arsip Lama
    Route::get('/riwayat', [PetugasController::class, 'riwayat'])->name('riwayat');

    // Gate Check (Scanner QR)
    Route::get('/gate-check', [PetugasController::class, 'gateCheck'])->name('gate');

    // Laporan Statistik (Grafik Eksekutif)
    Route::get('/laporan-statistik', [PetugasController::class, 'laporan'])->name('laporan.statistik');

    // [BARU] Laporan Daftar Permohonan (Tabel + Filter Status)
    // Route ini menghubungkan view petugas.laporan.index dengan controller
    Route::get('/laporan-masuk', [PetugasController::class, 'laporan_masuk'])->name('laporan.index');
});


// ====================================================
// GROUP ROUTE: MASYARAKAT
// ====================================================
Route::middleware(['auth', 'role:masyarakat'])->prefix('masyarakat')->name('masyarakat.')->group(function () {
    // Dashboard Masyarakat
    Route::get('/', [MasyarakatController::class, 'index'])->name('index');

    // Proses Pengajuan
    Route::get('/ajukan', [MasyarakatController::class, 'create'])->name('create');
    Route::post('/', [MasyarakatController::class, 'store'])->name('store');

    // Riwayat & Detail Tiket
    Route::get('/riwayat', [MasyarakatController::class, 'riwayat'])->name('riwayat');
    Route::get('/tiket/{id}', [MasyarakatController::class, 'show'])->name('show');

    // Menu Laporan (Jadwal / Statistik / Dokumen)
    // Parameter {jenis} menangkap 'jadwal', 'statistik', atau lainnya
    Route::get('/laporan/{jenis}', [MasyarakatController::class, 'laporan'])->name('laporan');
});


// ====================================================
// PROFILE ROUTES (Bawaan Laravel Breeze/Jetstream)
// ====================================================
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';
