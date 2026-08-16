<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('tahanans', function (Blueprint $table) {
            $table->id();

            // IDENTITAS UTAMA
            $table->string('nama_tahanan');

            // ---> INI YANG BARU KITA TAMBAHKAN <---
            $table->string('no_tahanan')->nullable();

            // PENTING: unique() mencegah input nomor register ganda
            $table->string('no_register')->unique();
            $table->enum('jenis_kelamin', ['L', 'P']);

            // IDENTITAS PELENGKAP (Boleh Kosong/Nullable)
            $table->string('tempat_lahir')->nullable();
            $table->date('tanggal_lahir')->nullable();
            $table->string('agama')->nullable();
            $table->string('pekerjaan')->nullable();
            $table->text('alamat')->nullable();

            // DATA HUKUM (Wajib Isi)
            // Contoh: Pasal 363 KUHP
            $table->string('pasal');

            // LOKASI (Pilihan Tetap/Enum biar Admin gak typo)
            $table->enum('lokasi_tahanan', [
                'Lapas Teluk Dalam',
                'LPP Martapura',   // Lapas Perempuan
                'LPKA Martapura',  // Lapas Anak
                'Rutan Polresta',
                'Lainnya'
            ]);

            $table->string('foto')->nullable();

            // STATUS (Logika Tampil/Hilang di Aplikasi Pengunjung)
            // Kalau 'Aktif' -> Muncul di Pencarian
            // Kalau 'Bebas' -> Hilang
            $table->enum('status', ['Aktif', 'Non-Aktif', 'Bebas', 'Pindah'])->default('Aktif');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tahanans');
    }
};
