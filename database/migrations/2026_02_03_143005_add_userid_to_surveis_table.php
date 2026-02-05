<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('surveis', function (Blueprint $table) {

            // 1. Cek & Tambah kunjungan_id (jika belum ada)
            if (!Schema::hasColumn('surveis', 'kunjungan_id')) {
                // Taruh setelah id (opsional, biar rapi aja)
                $table->foreignId('kunjungan_id')->nullable()->after('id');
            }

            // 2. Cek & Tambah bintang (jika belum ada)
            if (!Schema::hasColumn('surveis', 'bintang')) {
                $table->integer('bintang')->default(5)->after('id');
            }

            // 3. Cek & Tambah komentar (INI YANG BIKIN ERROR TADI)
            if (!Schema::hasColumn('surveis', 'komentar')) {
                $table->text('komentar')->nullable()->after('bintang');
            }
        });
    }

    public function down()
    {
        Schema::table('surveis', function (Blueprint $table) {
            // Hapus kolom jika rollback
            if (Schema::hasColumn('surveis', 'kunjungan_id')) $table->dropColumn('kunjungan_id');
            if (Schema::hasColumn('surveis', 'bintang')) $table->dropColumn('bintang');
            if (Schema::hasColumn('surveis', 'komentar')) $table->dropColumn('komentar');
        });
    }
};
