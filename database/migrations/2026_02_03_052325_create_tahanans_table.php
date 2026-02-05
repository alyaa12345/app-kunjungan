<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('tahanans', function (Blueprint $table) {
            $table->id();
            $table->string('nama_lengkap');
            $table->string('nama_bin'); // Nama Ayah (Kunci Pencarian)
            $table->string('nomor_registrasi')->unique(); // No. Reg Tahanan
            $table->string('blok_kamar');
            $table->string('kasus');
            $table->integer('jatah_kunjungan_mingguan')->default(1); // Misal: 1x seminggu
            $table->enum('status_tahanan', ['normal', 'isolasi', 'sakit'])->default('normal');
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
