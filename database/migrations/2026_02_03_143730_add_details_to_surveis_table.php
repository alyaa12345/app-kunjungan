<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('surveis', function (Blueprint $table) {
            // Kita tambah 3 kriteria penilaian (Default nilai 5 biar aman)
            if (!Schema::hasColumn('surveis', 'skor_pelayanan')) {
                $table->integer('skor_pelayanan')->default(5)->after('bintang');
            }
            if (!Schema::hasColumn('surveis', 'skor_kebersihan')) {
                $table->integer('skor_kebersihan')->default(5)->after('skor_pelayanan');
            }
            if (!Schema::hasColumn('surveis', 'skor_fasilitas')) {
                $table->integer('skor_fasilitas')->default(5)->after('skor_kebersihan');
            }
        });
    }

    public function down()
    {
        Schema::table('surveis', function (Blueprint $table) {
            $table->dropColumn(['skor_pelayanan', 'skor_kebersihan', 'skor_fasilitas']);
        });
    }
};
