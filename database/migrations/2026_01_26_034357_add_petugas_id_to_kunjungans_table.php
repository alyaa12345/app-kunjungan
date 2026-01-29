<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('kunjungans', function (Blueprint $table) {
            if (!Schema::hasColumn('kunjungans', 'petugas_id')) {
                $table->unsignedBigInteger('petugas_id')->nullable()->after('status');
                $table->foreign('petugas_id')->references('id')->on('users')->onDelete('set null');
            }
        });
    }

    public function down()
    {
        Schema::table('kunjungans', function (Blueprint $table) {
            $table->dropForeign(['petugas_id']);
            $table->dropColumn('petugas_id');
        });
    }
};
