<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('kunjungans', function (Blueprint $table) {
            // Tambahkan kolom hanya jika belum ada
            if (!Schema::hasColumn('kunjungans', 'nama_pengunjung')) {
                $table->string('nama_pengunjung')->nullable();
            }
            if (!Schema::hasColumn('kunjungans', 'nik_pengunjung')) {
                $table->string('nik_pengunjung')->nullable();
            }
            if (!Schema::hasColumn('kunjungans', 'jenis_kelamin')) {
                $table->string('jenis_kelamin')->nullable();
            }
            if (!Schema::hasColumn('kunjungans', 'alamat_pengunjung')) {
                $table->text('alamat_pengunjung')->nullable();
            }
            if (!Schema::hasColumn('kunjungans', 'hubungan_tahanan')) {
                $table->string('hubungan_tahanan')->nullable();
            }
            if (!Schema::hasColumn('kunjungans', 'nama_bin')) {
                $table->string('nama_bin')->nullable(); // INI YANG BIKIN ERROR TADI
            }
            if (!Schema::hasColumn('kunjungans', 'lokasi_tahanan')) {
                $table->string('lokasi_tahanan')->nullable();
            }
            if (!Schema::hasColumn('kunjungans', 'detail_kamar')) {
                $table->string('detail_kamar')->nullable();
            }
            if (!Schema::hasColumn('kunjungans', 'kasus_tahanan')) {
                $table->string('kasus_tahanan')->nullable();
            }
            if (!Schema::hasColumn('kunjungans', 'catatan')) {
                $table->text('catatan')->nullable();
            }
        });
    }

    public function down()
    {
        Schema::table('kunjungans', function (Blueprint $table) {
            // Hapus kolom jika rollback (opsional, biar aman biarkan saja)
        });
    }
};
