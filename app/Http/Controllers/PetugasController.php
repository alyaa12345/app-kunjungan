<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Kunjungan;

class PetugasController extends Controller
{
    // 1. Halaman Dashboard Petugas (Menampilkan data yang 'Menunggu')
    public function index()
    {
        // Ambil data kunjungan yang statusnya 'menunggu', urutkan dari yang terlama
        $kunjungans = Kunjungan::where('status', 'menunggu')
            ->orderBy('created_at', 'asc')
            ->get();

        return view('petugas.index', compact('kunjungans'));
    }

    // 2. Logic untuk Verifikasi (Terima/Tolak)
    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:disetujui,ditolak',
            'keterangan_petugas' => 'nullable|string'
        ]);

        $kunjungan = Kunjungan::findOrFail($id);

        $kunjungan->update([
            'status' => $request->status,
            'keterangan_petugas' => $request->keterangan_petugas
        ]);

        return redirect()->back()->with('success', 'Status kunjungan berhasil diperbarui.');
    }

    // 3. Halaman Riwayat (Data yang sudah diproses)
    public function riwayat()
    {
        $kunjungans = Kunjungan::whereIn('status', ['disetujui', 'ditolak'])
            ->orderBy('updated_at', 'desc')
            ->get();

        return view('petugas.riwayat', compact('kunjungans'));
    }
}
