<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Akun Petugas (Admin)
        User::create([
            'name' => 'Bapak Petugas',
            'email' => 'petugas@rutan.com',
            'role' => 'petugas',
            'password' => Hash::make('password123'),
            'no_hp' => '081234567890',
        ]);

        // 2. Akun Kepala Rutan (Hanya lihat laporan)
        User::create([
            'name' => 'Bapak Kepala',
            'email' => 'kepala@rutan.com',
            'role' => 'kepala',
            'password' => Hash::make('password123'),
        ]);

        // 3. Akun Masyarakat (Contoh User yang akan berkunjung)
        User::create([
            'name' => 'Warga Binaan',
            'email' => 'warga@gmail.com',
            'role' => 'masyarakat',
            'nik' => '3201000000000001',
            'alamat' => 'Jl. Mawar No. 12',
            'password' => Hash::make('password123'),
        ]);
    }
}
