<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kunjungan extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'petugas_id', // PENTING: Untuk menyimpan ID petugas verifikator
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

    /**
     * Relasi ke User sebagai Pemohon (Masyarakat)
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * Relasi ke User sebagai Petugas Verifikator
     * Fungsi ini yang akan memunculkan nama petugas di laporan
     */
    public function petugas()
    {
        return $this->belongsTo(User::class, 'petugas_id');
    }
}
