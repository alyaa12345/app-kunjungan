<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

// Import Controller
use App\Http\Controllers\KepalaController;
use App\Http\Controllers\PetugasController;
use App\Http\Controllers\MasyarakatController;
use App\Http\Controllers\TitipanController;
use App\Http\Controllers\LapasController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return view('welcome');
});

// ====================================================
// [PENTING] ROUTE PENCARIAN TAHANAN (AJAX)
// ====================================================
Route::get('/cek-tahanan', [MasyarakatController::class, 'cariTahanan'])->name('cek.tahanan');


// ====================================================
// LOGIKA REDIRECT DASHBOARD SETELAH LOGIN
// ====================================================
Route::get('/dashboard', function () {
    $role = Auth::user()->role;

    if ($role == 'kepala') {
        return redirect()->route('kepala.index');
    } elseif ($role == 'petugas') {
        return redirect()->route('petugas.index');
    } elseif ($role == 'petugas_lapas') {
        return redirect()->route('lapas.dashboard');
    } elseif ($role == 'masyarakat') {
        return redirect()->route('masyarakat.index');
    } else {
        Auth::logout();
        return abort(403, 'Role akun Anda tidak valid.');
    }
})->middleware(['auth', 'verified'])->name('dashboard');


// ====================================================
// GROUP ROUTE: KEPALA KEJAKSAAN
// ====================================================
Route::middleware(['auth', 'role:kepala'])->prefix('kepala')->name('kepala.')->group(function () {
    Route::get('/', [KepalaController::class, 'index'])->name('index');

    // FITUR MONITORING
    Route::get('/monitoring-titipan', [KepalaController::class, 'titipan'])->name('titipan');
    Route::get('/monitoring-titipan/cetak', [KepalaController::class, 'cetakTitipan'])->name('titipan.cetak');

    // URL UNTUK MELIHAT HALAMAN HASIL SURVEI (Akses ke: 127.0.0.1:8000/kepala/monitoring-survei)
    Route::get('/monitoring-survei', [KepalaController::class, 'survei'])->name('survei');

    // FITUR LAPORAN
    Route::prefix('laporan')->name('laporan.')->group(function () {
        Route::get('/', [KepalaController::class, 'laporan'])->name('index');
        Route::get('/preview', [KepalaController::class, 'previewExcel'])->name('preview');
        Route::get('/download', [KepalaController::class, 'downloadExcel'])->name('download');
    });
});


// ====================================================
// GROUP ROUTE: PETUGAS KEJAKSAAN (MURNI ADMINISTRATIF)
// ====================================================
Route::middleware(['auth', 'role:petugas'])->prefix('petugas')->name('petugas.')->group(function () {
    // 1. Dashboard & Verifikasi Kunjungan
    Route::get('/', [PetugasController::class, 'index'])->name('index');
    Route::get('/dashboard', [PetugasController::class, 'index'])->name('dashboard');
    Route::put('/verifikasi/{id}', [PetugasController::class, 'updateStatus'])->name('update');

    // 2. Riwayat Kunjungan
    Route::get('/riwayat', [PetugasController::class, 'riwayat'])->name('riwayat');

    // 3. Laporan
    Route::get('/laporan-statistik', [PetugasController::class, 'laporan'])->name('laporan.statistik');
    Route::get('/laporan-masuk', [PetugasController::class, 'laporan_masuk'])->name('laporan.index');
    Route::get('/laporan/excel', [PetugasController::class, 'exportExcel'])->name('laporan.excel');

    // 4. Hasil Survei
    Route::get('/survei-kepuasan', [PetugasController::class, 'survei'])->name('survei.index');

    // 5. MANAJEMEN DATA TAHANAN
    Route::get('/data-tahanan', [PetugasController::class, 'dataTahanan'])->name('tahanan.index');
    Route::post('/data-tahanan/store', [PetugasController::class, 'storeTahanan'])->name('tahanan.store');
    Route::get('/data-tahanan/{id}/edit', [PetugasController::class, 'editTahanan'])->name('tahanan.edit');
    Route::put('/data-tahanan/{id}', [PetugasController::class, 'updateTahanan'])->name('tahanan.update');

    // 6. Verifikasi Titipan & Cetak Label (Administratif Kejaksaan)
    Route::get('/titipan', [PetugasController::class, 'titipan'])->name('titipan.index');
    Route::put('/titipan/{id}', [PetugasController::class, 'verifikasiTitipan'])->name('titipan.update');
    Route::get('/titipan/{id}/cetak', [PetugasController::class, 'cetakLabel'])->name('titipan.cetak');

    // Akses bypass URL untuk tombol kustom di view petugas
    Route::get('/tahanan', [PetugasController::class, 'dataTahanan']);
    Route::get('/laporan', [PetugasController::class, 'laporan']);
    Route::patch('/update-status/{id}', [PetugasController::class, 'updateStatus']);

    // PERBAIKAN: Menghapus teks '/petugas' di awal url karena otomatis ditambahkan oleh prefix di atas.
    // PENTING: Di file blade, panggil dengan nama: route('petugas.laporan.cetak')
    Route::get('/survei-kepuasan/cetak', [PetugasController::class, 'cetakLaporanSurvei'])->name('laporan.cetak');
});


// ====================================================
// GROUP ROUTE: PETUGAS LAPAS (OPERASIONAL GERBANG)
// ====================================================
Route::middleware(['auth', 'role:petugas_lapas'])->prefix('lapas')->name('lapas.')->group(function () {
    Route::get('/dashboard', [LapasController::class, 'index'])->name('dashboard');

    // Gate Check (Scanner QR)
    Route::get('/gate-check', [LapasController::class, 'gateCheck'])->name('gate-check');
    Route::post('/gate-check/proses', [LapasController::class, 'prosesGateCheck'])->name('gate.proses');

    // Serah Terima Titipan Fisik
    Route::get('/titipan', [LapasController::class, 'titipan'])->name('titipan');
    Route::put('/titipan/{id}', [LapasController::class, 'prosesTitipan'])->name('titipan.proses');

    // Laporan Operasional Lapas
    Route::get('/laporan', [LapasController::class, 'laporan'])->name('laporan');

    // SUDAH DIPERBAIKI: Mengikuti prefix 'lapas' dan nama 'lapas.' secara otomatis
    Route::get('/kunjungan', [LapasController::class, 'kunjungan'])->name('kunjungan');
    Route::get('/laporan/cetak', [LapasController::class, 'cetakLaporan'])->name('laporan.cetak');
});


// ====================================================
// GROUP ROUTE: MASYARAKAT
// ====================================================
Route::middleware(['auth', 'role:masyarakat'])->group(function () {

    // Route Helper (Cek Kuota & Simpan Titipan)
    Route::get('/cek-kuota', [MasyarakatController::class, 'checkQuota'])->name('cek.kuota');
    Route::post('/titipan/simpan', [TitipanController::class, 'store'])->name('titipan.store');

    // Group Utama Masyarakat
    Route::prefix('masyarakat')->name('masyarakat.')->group(function () {
        // Dashboard & Form
        Route::get('/', [MasyarakatController::class, 'index'])->name('index');
        Route::get('/ajukan', [MasyarakatController::class, 'create'])->name('create');
        Route::post('/', [MasyarakatController::class, 'store'])->name('store');
        
        // --- TAMBAHAN ROUTE EDIT TIKET KUNJUNGAN ---
        Route::get('/tiket/{id}/edit', [MasyarakatController::class, 'edit'])->name('edit');
        Route::put('/tiket/{id}', [MasyarakatController::class, 'update'])->name('update');

        // Fitur Lain
        Route::get('/riwayat', [MasyarakatController::class, 'riwayat'])->name('riwayat');
        Route::get('/tiket/{id}', [MasyarakatController::class, 'show'])->name('show');
        Route::get('/laporan', [MasyarakatController::class, 'laporan'])->name('laporan');

        // Halaman Ulasan
        Route::get('/ulasan', [MasyarakatController::class, 'ulasan'])->name('ulasan');
        Route::post('/survei/simpan', [MasyarakatController::class, 'simpanSurvei'])->name('survei.simpan');

        // --- TAMBAHAN ROUTE EDIT TITIPAN BARANG ---
        Route::get('/titipan/{id}/edit', [TitipanController::class, 'edit'])->name('titipan.edit');
        Route::put('/titipan/{id}', [TitipanController::class, 'update'])->name('titipan.update');

        // Cetak surat titipan oleh masyarakat
        Route::get('/titipan/{id}/cetak-surat', [MasyarakatController::class, 'cetakTitipan'])->name('titipan.cetak');
    });
});


// ====================================================
// PROFILE ROUTES & AUTH
// ====================================================
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';

// Rute sementara untuk memperbaiki tipe data ENUM di database
Route::get('/fix-db', function () {
    try {
        \Illuminate\Support\Facades\DB::statement("ALTER TABLE kunjungans MODIFY COLUMN status VARCHAR(50) DEFAULT 'menunggu'");
        \Illuminate\Support\Facades\DB::statement("ALTER TABLE titipans MODIFY COLUMN status VARCHAR(50) DEFAULT 'menunggu'");
        return "✅ Database berhasil diperbaiki! Tipe data status sekarang sudah fleksibel. Silakan kembali ke aplikasi dan coba Proses Check-In lagi.";
    } catch (\Exception $e) {
        return "Terjadi kesalahan: " . $e->getMessage();
    }
});