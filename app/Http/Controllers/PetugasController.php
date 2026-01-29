<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Kunjungan;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class PetugasController extends Controller
{
    // ====================================================
    // 1. DASHBOARD UTAMA (MEJA VERIFIKASI)
    // ====================================================
    public function index()
    {
        // Menampilkan antrian yang statusnya 'menunggu'
        $kunjungans = Kunjungan::with('user')
            ->where('status', 'menunggu')
            ->orderBy('created_at', 'asc')
            ->get();

        return view('petugas.index', compact('kunjungans'));
    }

    // ====================================================
    // 2. PROSES VERIFIKASI (FIX: TANPA PETUGAS_ID)
    // ====================================================
    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:disetujui,ditolak',
            'keterangan_petugas' => 'nullable|string'
        ]);

        $kunjungan = Kunjungan::findOrFail($id);

        // UPDATE STATUS SAJA (Tanpa petugas_id agar tidak error database)
        $kunjungan->update([
            'status'             => $request->status,
            'keterangan_petugas' => $request->keterangan_petugas,
            // 'petugas_id'      => Auth::id(), // Baris ini saya matikan karena kolomnya tidak ada di DB
        ]);

        return back()->with('success', 'Status permohonan berhasil diperbarui.');
    }

    // ====================================================
    // 3. RIWAYAT / ARSIP
    // ====================================================
    public function riwayat()
    {
        $riwayat = Kunjungan::whereIn('status', ['disetujui', 'ditolak'])
            ->latest()
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

        if ($request->has('tiket_id')) {
            $cleanId = preg_replace('/[^0-9]/', '', $request->tiket_id);

            $visitor = Kunjungan::where('id', $cleanId)
                ->where('status', 'disetujui')
                ->first();

            if (!$visitor) {
                $cekStatus = Kunjungan::find($cleanId);
                if ($cekStatus) {
                    $message = "Tiket ditemukan tetapi statusnya: " . strtoupper($cekStatus->status);
                } else {
                    $message = "Tiket ID #" . $cleanId . " tidak ditemukan.";
                }
            }
        }

        return view('petugas.gate', compact('visitor', 'message'));
    }

    // ====================================================
    // 5. LAPORAN STATISTIK (GRAFIK)
    // ====================================================
    public function laporan(Request $request)
    {
        $query = Kunjungan::query();
        $title = "Semua Arsip Data";

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

        $laporan_detail = $query->orderBy('tanggal_kunjungan', 'desc')->get();

        $totalTotal     = $laporan_detail->count();
        $totalDisetujui = $laporan_detail->where('status', 'disetujui')->count();
        $totalDitolak   = $laporan_detail->where('status', 'ditolak')->count();

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

    // ====================================================
    // 6. LAPORAN MASUK (DATA TABEL)
    // ====================================================
    public function laporan_masuk(Request $request)
    {
        // Hapus 'petugas' dari with() agar tidak error kolom not found
        $query = Kunjungan::with(['user']);

        if ($request->has('status') && $request->status != 'semua') {
            $query->where('status', $request->status);
        }

        $data = $query->orderBy('tanggal_kunjungan', 'asc')->get();

        return view('petugas.laporan_masuk', compact('data'));
    }

    // ====================================================
    // 7. EXPORT EXCEL
    // ====================================================
    public function exportExcel(Request $request)
    {
        // Hapus 'petugas' dari with() agar tidak error kolom not found
        $query = Kunjungan::with(['user']);

        if ($request->has('status') && $request->status != 'semua') {
            $query->where('status', $request->status);
        }

        $data = $query->latest()->get();

        // MODE DOWNLOAD
        if ($request->get('action') == 'download') {
            $filename = "Laporan_Kunjungan_" . date('Y-m-d_H-i') . ".xls";

            header("Content-Type: application/vnd.ms-excel");
            header("Content-Disposition: attachment; filename=\"$filename\"");

            return view('petugas.excel', compact('data'))->with('is_download', true);
        }

        // MODE PREVIEW
        return view('petugas.excel', compact('data'))->with('is_download', false);
    }
}
