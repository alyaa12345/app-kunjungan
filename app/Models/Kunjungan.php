<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kunjungan extends Model
{
    use HasFactory;

    // Field yang boleh diisi (Mass Assignment)
    protected $fillable = [
        'user_id',
        'nama_pengunjung',
        'nik_pengunjung',
        'jenis_kelamin',
        'alamat_pengunjung',
        'hubungan_tahanan',
        'nama_tahanan',
        'nomor_kamar',
        'kasus_tahanan',
        'tanggal_kunjungan',
        'jam_kunjungan',
        'keperluan',
        'jumlah_pengikut',
        'foto_ktp',
        'status',
        'keterangan_petugas'
    ];

    // Relasi balik ke User (Setiap kunjungan dimiliki 1 user)
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
