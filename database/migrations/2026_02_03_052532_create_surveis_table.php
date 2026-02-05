<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        // CEK DULU: Hanya buat jika tabel belum ada
        if (!Schema::hasTable('surveis')) {
            Schema::create('surveis', function (Blueprint $table) {
                $table->id();
                $table->foreignId('user_id')->constrained('users')->onDelete('cascade');

                // Relasi ke tabel kunjungans (Pastikan tabel kunjungans sudah ada)
                $table->foreignId('kunjungan_id')->constrained('kunjungans')->onDelete('cascade');

                $table->integer('bintang'); // 1 sampai 5
                $table->text('komentar')->nullable();
                $table->timestamps();
            });
        }
    }

    public function down()
    {
        Schema::dropIfExists('surveis');
    }
};
