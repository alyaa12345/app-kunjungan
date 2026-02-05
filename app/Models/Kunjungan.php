<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kunjungan extends Model
{
    use HasFactory;

    // Nama Tabel di Database
    protected $table = 'kunjungans';

    // =================================================================
    // KUNCI PERBAIKAN:
    // $guarded = [] artinya "Tidak ada kolom yang dilarang".
    // Semua data dari Controller (nama_bin, lokasi, nik, dll)
    // akan DITERIMA dan DISIMPAN oleh Laravel tanpa error.
    // =================================================================
    protected $guarded = [];

    // Relasi ke tabel Users (Pengunjung)
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relasi ke tabel Survei (Untuk fitur ulasan nanti)
    public function survei()
    {
        return $this->hasOne(Survei::class);
    }
}
