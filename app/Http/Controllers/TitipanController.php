<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Titipan;
use App\Models\Tahanan;
use Illuminate\Support\Facades\Auth;

class TitipanController extends Controller
{
    // Fungsi untuk memproses data dari Formulir Modal
    public function store(Request $request)
    {
        // 1. Validasi
        $request->validate([
            'no_tahanan'       => 'required|string', 
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
            'no_tahanan'       => $request->no_tahanan, 
            'nama_tahanan'     => $request->nama_tahanan,
            'lokasi_tahanan'   => $request->lokasi_tahanan, // <-- PERBAIKAN: Ditambahkan agar lokasi tidak kosong saat buat baru
            'jenis_titipan'    => $request->jenis_titipan,
            'deskripsi_barang' => $request->deskripsi_barang,
            'foto_barang'      => $path,
            'status'           => 'diajukan'
        ]);

        // 4. Balik ke halaman Dashboard dengan notifikasi
        return redirect()->back()->with('success', 'Berhasil! Barang titipan sudah didaftarkan.');
    }

    // ====================================================
    // EDIT & UPDATE DATA TITIPAN BARANG
    // ====================================================
    public function edit($id)
    {
        $titipan = Titipan::where('user_id', Auth::id())->findOrFail($id);
        
        // Proteksi: Hanya bisa diedit jika statusnya masih diajukan/menunggu
        if (!in_array(strtolower($titipan->status), ['diajukan', 'menunggu'])) {
            return redirect()->route('masyarakat.index')->with('error', 'Akses ditolak! Titipan ini sudah diproses.');
        }

        $tahanans = Tahanan::where('status', 'Aktif')
            ->orderBy('nama_tahanan', 'asc')
            ->get();

        return view('masyarakat.edit', compact('titipan', 'tahanans'));
    }

    public function update(Request $request, $id)
    {
        $titipan = Titipan::where('user_id', Auth::id())->findOrFail($id);

        if (!in_array(strtolower($titipan->status), ['diajukan', 'menunggu'])) {
            return redirect()->route('masyarakat.index')->with('error', 'Akses ditolak! Titipan ini tidak bisa diperbarui.');
        }

        $request->validate([
            'no_tahanan'       => 'required',
            'nama_tahanan'     => 'required',
            'jenis_titipan'    => 'required',
            'deskripsi_barang' => 'required',
            'foto_barang'      => 'nullable|image|max:2048', // Boleh kosong jika tidak diganti
        ]);

        $data_update = [
            'no_tahanan'       => $request->no_tahanan,
            'nama_tahanan'     => $request->nama_tahanan,
            'lokasi_tahanan'   => $request->lokasi_tahanan,
            'jenis_titipan'    => $request->jenis_titipan,
            'deskripsi_barang' => $request->deskripsi_barang,
            'status'           => 'menunggu'
        ];

        // Update foto jika ada yang baru
        if ($request->hasFile('foto_barang')) {
            $path = $request->file('foto_barang')->store('titipan_uploads', 'public');
            $data_update['foto_barang'] = $path;
        }

        $titipan->update($data_update);

        return redirect()->route('masyarakat.index')->with('success', 'Titipan Barang Berhasil Diperbarui!');
    }
}