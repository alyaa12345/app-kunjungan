<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('kunjungans', function (Blueprint $table) {
            // Kita tambahkan 2 kolom baru
            $table->tinyInteger('rating')->nullable()->after('status'); // Untuk bintang 1-5
            $table->text('komentar')->nullable()->after('rating');      // Untuk ulasan teks
        });
    }

    public function down()
    {
        Schema::table('kunjungans', function (Blueprint $table) {
            $table->dropColumn(['rating', 'komentar']);
        });
    }
};
