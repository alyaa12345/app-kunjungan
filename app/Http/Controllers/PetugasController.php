<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Kunjungan;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB; // Wajib ada untuk Laporan Statistik

class PetugasController extends Controller
{
    // ====================================================
    // 1. DASHBOARD UTAMA (MEJA VERIFIKASI)
    // ====================================================
    public function index()
    {
        // Ambil hanya yang statusnya 'menunggu' untuk diverifikasi
        $kunjungans = Kunjungan::where('status', 'menunggu')
            ->orderBy('created_at', 'asc') // Urutkan dari yang paling lama menunggu
            ->get();

        return view('petugas.index', compact('kunjungans'));
    }

    // ====================================================
    // 2. PROSES VERIFIKASI (UPDATE STATUS)
    // ====================================================
    public function updateStatus(Request $request, $id)
    {
        // Validasi input sederhana
        $request->validate([
            'status' => 'required|in:disetujui,ditolak',
            'keterangan_petugas' => 'nullable|string'
        ]);

        $kunjungan = Kunjungan::findOrFail($id);

        $kunjungan->update([
            'status'             => $request->status,
            'keterangan_petugas' => $request->keterangan_petugas
        ]);

        return back()->with('success', 'Status kunjungan berhasil diperbarui!');
    }

    // ====================================================
    // 3. HALAMAN RIWAYAT (ARSIP DATA)
    // ====================================================
    public function riwayat()
    {
        // Ambil data yang statusnya SUDAH DIPROSES (Disetujui/Ditolak)
        $riwayat = Kunjungan::whereIn('status', ['disetujui', 'ditolak'])
            ->latest() // Urutkan dari yang terbaru
            ->get();

        return view('petugas.riwayat', compact('riwayat'));
    }

    // ====================================================
    // 4. GATE CHECK (SCANNER PINTU UTAMA)
    // ====================================================
    public function gateCheck(Request $request)
    {
        $visitor = null;
        $message = null;

        // Jika ada input 'tiket_id' (dari Scanner atau Ketik Manual)
        if ($request->has('tiket_id')) {

            // Bersihkan input agar hanya angka (jika scanner mengirim REQ-123, ambil 123-nya saja)
            // Opsional: Jika input anda murni angka ID, baris preg_replace bisa dihapus.
            $cleanId = preg_replace('/[^0-9]/', '', $request->tiket_id);

            // Cari data berdasarkan ID dan Status HARUS Disetujui
            $visitor = Kunjungan::where('id', $cleanId)
                ->where('status', 'disetujui')
                ->first();

            // Jika tidak ditemukan
            if (!$visitor) {
                // Cek apakah ada datanya tapi statusnya belum disetujui/ditolak
                $cekStatus = Kunjungan::find($cleanId);
                if ($cekStatus) {
                    $message = "Tiket ditemukan tetapi statusnya: " . strtoupper($cekStatus->status) . " (Belum Disetujui).";
                } else {
                    $message = "Tiket ID #" . $cleanId . " tidak ditemukan dalam sistem.";
                }
            }
        }

        // Return ke view 'petugas.gate' dengan membawa data visitor (jika ada) dan pesan (jika error)
        return view('petugas.gate', compact('visitor', 'message'));
    }

    // ====================================================
    // 5. LAPORAN STATISTIK (EKSEKUTIF)
    // ====================================================
    public function laporan()
    {
        // A. Statistik Kartu Atas
        $totalTotal     = Kunjungan::count();
        $totalDisetujui = Kunjungan::where('status', 'disetujui')->count();
        $totalDitolak   = Kunjungan::where('status', 'ditolak')->count();

        // B. Grafik/Tabel Harian (7 Hari Terakhir)
        // Query ini mengelompokkan data berdasarkan tanggal untuk grafik
        $harian = Kunjungan::select(DB::raw('DATE(created_at) as tanggal'), DB::raw('count(*) as total'))
            ->groupBy('tanggal')
            ->orderBy('tanggal', 'desc')
            ->limit(7)
            ->get();

        // C. Tabel Bulanan (Tahun Ini)
        // Query ini mengelompokkan data berdasarkan bulan
        $bulanan = Kunjungan::select(DB::raw('MONTH(created_at) as bulan'), DB::raw('count(*) as total'))
            ->whereYear('created_at', date('Y'))
            ->groupBy('bulan')
            ->orderBy('bulan', 'asc')
            ->get();

        return view('petugas.laporan', compact(
            'totalTotal',
            'totalDisetujui',
            'totalDitolak',
            'harian',
            'bulanan'
        ));
    }
}
