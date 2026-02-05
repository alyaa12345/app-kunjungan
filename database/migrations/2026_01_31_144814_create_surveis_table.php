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
        Schema::create('surveis', function (Blueprint $table) {
            $table->id();

            // Relasi ke tabel kunjungans
            // cascadeOnDelete artinya: kalau data kunjungan dihapus, surveinya ikut kehapus (biar bersih)
            $table->foreignId('kunjungan_id')->constrained('kunjungans')->cascadeOnDelete();

            $table->integer('bintang'); // Nilai 1 - 5
            $table->text('saran')->nullable(); // Komentar user
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('surveis');
    }
};
