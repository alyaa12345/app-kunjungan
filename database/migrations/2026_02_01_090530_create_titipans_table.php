<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('titipans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->string('nama_tahanan');
            $table->string('jenis_titipan');
            $table->text('deskripsi_barang');
            $table->string('foto_barang');
            $table->string('status')->default('diajukan');

            // TAMBAHAN: Agar petugas bisa kasih alasan kenapa ditolak
            $table->text('alasan_penolakan')->nullable();

            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('titipans');
    }
};
