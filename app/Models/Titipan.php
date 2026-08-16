<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Titipan extends Model
{
    use HasFactory;

    // KUNCI: Izinkan semua data masuk (termasuk no_tahanan dan alasan_penolakan)
    protected $guarded = [];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
