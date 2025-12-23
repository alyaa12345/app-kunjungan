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
        Schema::create('kunjungans', function (Blueprint $table) {
            $table->id();

            // Relasi ke User (Masyarakat yg request)
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');

            // --- BAGIAN 1: DATA PENGUNJUNG (4 Field) ---
            $table->string('nama_pengunjung');
            $table->string('nik_pengunjung', 16);
            $table->string('jenis_kelamin');
            $table->text('alamat_pengunjung');
            $table->string('hubungan_tahanan'); // Istri, Anak, Kuasa Hukum

            // --- BAGIAN 2: DATA TAHANAN (3 Field) ---
            $table->string('nama_tahanan');
            $table->string('nomor_kamar');
            $table->string('kasus_tahanan'); // Narkoba, Pencurian, dll

            // --- BAGIAN 3: DETAIL KUNJUNGAN (4 Field) ---
            $table->date('tanggal_kunjungan');
            $table->time('jam_kunjungan'); // Sesi pagi/siang
            $table->text('keperluan');
            $table->integer('jumlah_pengikut')->default(1);

            // --- BAGIAN 4: FILE & STATUS ---
            $table->string('foto_ktp')->nullable();

            // Enum Status (Alur Kerja)
            $table->enum('status', ['menunggu', 'diproses', 'disetujui', 'ditolak'])->default('menunggu');

            // Catatan dari petugas jika ditolak/diterima
            $table->text('keterangan_petugas')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kunjungans');
    }
};
