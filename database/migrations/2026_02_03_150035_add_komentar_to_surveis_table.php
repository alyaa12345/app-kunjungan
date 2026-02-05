<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('surveis', function (Blueprint $table) {
            // Kita cek dulu, kalau belum ada kolom 'komentar', kita buatkan
            if (!Schema::hasColumn('surveis', 'komentar')) {
                // Tipe TEXT karena komentar bisa panjang, dan NULLABLE (boleh kosong)
                $table->text('komentar')->nullable();
            }
        });
    }

    public function down()
    {
        Schema::table('surveis', function (Blueprint $table) {
            if (Schema::hasColumn('surveis', 'komentar')) {
                $table->dropColumn('komentar');
            }
        });
    }
};
