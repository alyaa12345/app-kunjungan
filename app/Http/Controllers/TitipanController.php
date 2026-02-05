<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Titipan;
use Illuminate\Support\Facades\Auth;

class TitipanController extends Controller
{
    // Fungsi untuk memproses data dari Formulir Modal
    public function store(Request $request)
    {
        // 1. Validasi
        $request->validate([
            'nama_tahanan'     => 'required|string',
            'jenis_titipan'    => 'required',
            'deskripsi_barang' => 'required|string',
            'foto_barang'      => 'required|image|max:2048', // Wajib upload foto
        ]);

        // 2. Simpan Foto
        $path = $request->file('foto_barang')->store('titipan_uploads', 'public');

        // 3. Simpan ke Database
        Titipan::create([
            'user_id'          => Auth::id(),
            'nama_tahanan'     => $request->nama_tahanan,
            'jenis_titipan'    => $request->jenis_titipan,
            'deskripsi_barang' => $request->deskripsi_barang,
            'foto_barang'      => $path,
            'status'           => 'diajukan'
        ]);

        // 4. Balik ke halaman Dashboard dengan notifikasi
        return redirect()->back()->with('success', 'Berhasil! Barang titipan sudah didaftarkan.');
    }
}
