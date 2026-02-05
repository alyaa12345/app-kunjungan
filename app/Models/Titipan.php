<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Titipan extends Model
{
    use HasFactory;

    protected $guarded = []; // KUNCI: Izinkan semua data masuk (termasuk alasan_penolakan)

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
