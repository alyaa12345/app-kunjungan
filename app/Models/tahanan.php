<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tahanan extends Model
{
    use HasFactory;

    // Ini membiarkan semua inputan form (termasuk no_tahanan) 
    // otomatis masuk ke database.
    protected $guarded = [];
}
