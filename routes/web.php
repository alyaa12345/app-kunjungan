<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

// Import Controller
use App\Http\Controllers\KepalaController;
use App\Http\Controllers\PetugasController;
use App\Http\Controllers\MasyarakatController;
use App\Http\Controllers\TitipanController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return view('welcome');
});

// LOGIKA REDIRECT DASHBOARD
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

    Route::get('/', [KepalaController::class, 'index'])->name('index');

    // FITUR MONITORING
    Route::get('/monitoring-titipan', [KepalaController::class, 'titipan'])->name('titipan');

    // --- TAMBAHKAN BARIS INI (PENYEBAB ERROR) ---
    Route::get('/monitoring-titipan/cetak', [KepalaController::class, 'cetakTitipan'])->name('titipan.cetak');
    // ---------------------------------------------

    Route::get('/monitoring-survei', [KepalaController::class, 'survei'])->name('survei');

    Route::prefix('laporan')->name('laporan.')->group(function () {
        Route::get('/', [KepalaController::class, 'laporan'])->name('index');
        Route::get('/preview', [KepalaController::class, 'previewExcel'])->name('preview');
        Route::get('/download', [KepalaController::class, 'downloadExcel'])->name('download');
    });
});


// ====================================================
// GROUP ROUTE: PETUGAS
// ====================================================
Route::middleware(['auth', 'role:petugas'])->prefix('petugas')->name('petugas.')->group(function () {
    // 1. Dashboard & Verifikasi Kunjungan
    Route::get('/', [PetugasController::class, 'index'])->name('index');
    Route::put('/verifikasi/{id}', [PetugasController::class, 'updateStatus'])->name('update');

    // 2. Riwayat & Gate Check
    Route::get('/riwayat', [PetugasController::class, 'riwayat'])->name('riwayat');
    Route::get('/gate-check', [PetugasController::class, 'gateCheck'])->name('gate');

    // 3. Laporan
    Route::get('/laporan-statistik', [PetugasController::class, 'laporan'])->name('laporan.statistik');
    Route::get('/laporan-masuk', [PetugasController::class, 'laporan_masuk'])->name('laporan.index');
    Route::get('/laporan/excel', [PetugasController::class, 'exportExcel'])->name('laporan.excel');

    // 4. Master Data Tahanan
    Route::get('/data-tahanan', [PetugasController::class, 'dataTahanan'])->name('tahanan.index');
    Route::post('/data-tahanan', [PetugasController::class, 'simpanTahanan'])->name('tahanan.store');

    // 5. Verifikasi Titipan & Cetak Label
    Route::get('/titipan', [PetugasController::class, 'titipan'])->name('titipan.index');
    Route::put('/titipan/{id}', [PetugasController::class, 'verifikasiTitipan'])->name('titipan.update');
    Route::get('/titipan/{id}/cetak', [PetugasController::class, 'cetakLabel'])->name('titipan.cetak');

    // 6. Hasil Survei
    Route::get('/survei-kepuasan', [PetugasController::class, 'survei'])->name('survei.index');
});


// ====================================================
// GROUP ROUTE: MASYARAKAT (SUDAH DIPERBAIKI)
// ====================================================
Route::middleware(['auth', 'role:masyarakat'])->group(function () {

    // Route Helper (Cek Kuota & Simpan Titipan)
    Route::get('/cek-kuota', [MasyarakatController::class, 'checkQuota'])->name('cek.kuota');
    Route::post('/titipan/simpan', [TitipanController::class, 'store'])->name('titipan.store');

    // Group Utama Masyarakat
    // URL Prefix: /masyarakat/....
    // Name Prefix: masyarakat.....
    Route::prefix('masyarakat')->name('masyarakat.')->group(function () {

        // Dashboard & Form
        Route::get('/', [MasyarakatController::class, 'index'])->name('index');     // masyarakat.index
        Route::get('/ajukan', [MasyarakatController::class, 'create'])->name('create'); // masyarakat.create
        Route::post('/', [MasyarakatController::class, 'store'])->name('store');      // masyarakat.store

        // Fitur Lain
        Route::get('/riwayat', [MasyarakatController::class, 'riwayat'])->name('riwayat'); // masyarakat.riwayat
        Route::get('/tiket/{id}', [MasyarakatController::class, 'show'])->name('show');    // masyarakat.show
        Route::get('/laporan', [MasyarakatController::class, 'laporan'])->name('laporan'); // masyarakat.laporan

        // --- FITUR SURVEI (FIXED) ---
        // Perhatikan: Tidak perlu pakai '/masyarakat' lagi di depannya karena sudah ada di prefix group

        // Halaman Ulasan -> URL: /masyarakat/ulasan
        Route::get('/ulasan', [MasyarakatController::class, 'ulasan'])->name('ulasan');

        // Proses Simpan -> URL: /masyarakat/survei/simpan
        Route::post('/survei/simpan', [MasyarakatController::class, 'simpanSurvei'])->name('survei.simpan');
    });
});


// ====================================================
// PROFILE ROUTES
// ====================================================
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';
