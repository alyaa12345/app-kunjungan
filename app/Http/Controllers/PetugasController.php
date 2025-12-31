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
    public function laporan(Request $request)
    {
        // 1. QUERY DASAR (Query Builder agar bisa difilter)
        $query = Kunjungan::query();

        // 2. LOGIKA FILTER (Harian, Bulanan, Tahunan)
        $title = "Semua Arsip Data"; // Judul Default

        if ($request->filled('filter_type')) {
            switch ($request->filter_type) {
                case 'harian':
                    $request->validate(['tanggal' => 'required|date']);
                    $query->whereDate('tanggal_kunjungan', $request->tanggal);
                    $title = "Laporan Harian: " . Carbon::parse($request->tanggal)->translatedFormat('d F Y');
                    break;

                case 'mingguan':
                    $request->validate(['start_date' => 'required|date', 'end_date' => 'required|date']);
                    $query->whereBetween('tanggal_kunjungan', [$request->start_date, $request->end_date]);
                    $title = "Laporan Periode: " . Carbon::parse($request->start_date)->format('d/m/y') . " - " . Carbon::parse($request->end_date)->format('d/m/y');
                    break;

                case 'bulanan':
                    $request->validate(['bulan' => 'required', 'tahun' => 'required']);
                    $query->whereMonth('tanggal_kunjungan', $request->bulan)
                        ->whereYear('tanggal_kunjungan', $request->tahun);
                    $title = "Laporan Bulanan: " . Carbon::create()->month($request->bulan)->translatedFormat('F') . " " . $request->tahun;
                    break;

                case 'tahunan':
                    $request->validate(['tahun' => 'required']);
                    $query->whereYear('tanggal_kunjungan', $request->tahun);
                    $title = "Laporan Tahunan: " . $request->tahun;
                    break;
            }
        }

        // 3. EKSEKUSI DATA (Untuk Tabel Register)
        $laporan_detail = $query->orderBy('tanggal_kunjungan', 'desc')->get();

        // 4. STATISTIK (Tetap hitung statistik global atau bisa difilter juga, disini kita filter global biar dashboard tetap jalan)
        // Opsional: Jika ingin statistik kartu di atas ikut berubah sesuai filter, ganti Kunjungan::count() dengan $laporan_detail->count() dst.
        // Di sini saya buat statistik mengikuti filter agar konsisten.
        $totalTotal     = $laporan_detail->count();
        $totalDisetujui = $laporan_detail->where('status', 'disetujui')->count();
        $totalDitolak   = $laporan_detail->where('status', 'ditolak')->count();

        // Data Grafik (Tetap default 7 hari terakhir & tahun ini agar grafik tidak rusak)
        $harian = Kunjungan::select(DB::raw('DATE(created_at) as tanggal'), DB::raw('count(*) as total'))
            ->groupBy('tanggal')->orderBy('tanggal', 'desc')->limit(7)->get();
        $bulanan = Kunjungan::select(DB::raw('MONTH(created_at) as bulan'), DB::raw('count(*) as total'))
            ->whereYear('created_at', date('Y'))->groupBy('bulan')->orderBy('bulan', 'asc')->get();

        return view('petugas.laporan', compact(
            'totalTotal',
            'totalDisetujui',
            'totalDitolak',
            'harian',
            'bulanan',
            'laporan_detail',
            'title'
        ));
    }
}
