<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Kunjungan;
use Carbon\Carbon;

class KepalaController extends Controller
{
    // ====================================================
    // 1. DASHBOARD UTAMA (MONITORING KINERJA)
    // ====================================================
    public function index()
    {
        $today = Carbon::today();

        // 1. Statistik Hari Ini
        $stats = [
            'total_hari_ini' => Kunjungan::whereDate('created_at', $today)->count(),
            'disetujui'      => Kunjungan::whereDate('created_at', $today)->where('status', 'disetujui')->count(),
            'ditolak'        => Kunjungan::whereDate('created_at', $today)->where('status', 'ditolak')->count(),
            'menunggu'       => Kunjungan::whereDate('created_at', $today)->where('status', 'menunggu')->count(),
        ];

        // 2. Log Aktivitas Terbaru (5 Terakhir)
        $terbaru = Kunjungan::with(['user', 'petugas'])
            ->whereIn('status', ['disetujui', 'ditolak'])
            ->latest('updated_at')
            ->take(5)
            ->get();

        return view('kepala.index', compact('stats', 'terbaru'));
    }

    // ====================================================
    // 2. HALAMAN LAPORAN EVALUASI (FILTER LENGKAP)
    // ====================================================
    public function laporan(Request $request)
    {
        // Load relasi 'petugas' agar nama verifikator bisa ditampilkan
        $query = Kunjungan::with(['user', 'petugas']);

        $title = "Semua Arsip Data";

        // Filter Rentang Tanggal
        if ($request->filled('start_date') && $request->filled('end_date')) {
            $query->whereBetween('tanggal_kunjungan', [$request->start_date, $request->end_date]);
            $title = "Laporan Periode: " . Carbon::parse($request->start_date)->format('d/m/Y') . " - " . Carbon::parse($request->end_date)->format('d/m/Y');
        }
        // Filter Cepat
        elseif ($request->periode == 'hari_ini') {
            $query->whereDate('tanggal_kunjungan', Carbon::today());
            $title = "Laporan Hari Ini (" . Carbon::today()->format('d M Y') . ")";
        } elseif ($request->periode == 'minggu_ini') {
            $start = Carbon::now()->startOfWeek();
            $end   = Carbon::now()->endOfWeek();
            $query->whereBetween('tanggal_kunjungan', [$start, $end]);
            $title = "Laporan Minggu Ini (" . $start->format('d M') . " - " . $end->format('d M Y') . ")";
        } elseif ($request->periode == 'bulan_ini') {
            $query->whereMonth('tanggal_kunjungan', Carbon::now()->month)
                ->whereYear('tanggal_kunjungan', Carbon::now()->year);
            $title = "Laporan Bulan " . Carbon::now()->translatedFormat('F Y');
        }

        // Pencarian
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('nama_pengunjung', 'like', "%{$search}%")
                    ->orWhere('nama_tahanan', 'like', "%{$search}%");
            });
        }

        // Filter Status
        if ($request->has('status') && $request->status != 'semua') {
            $query->where('status', $request->status);
        }

        $data = $query->latest()->get();

        // PERBAIKAN DISINI: Ubah ke 'kepala.laporan' (sesuai nama file Anda)
        return view('kepala.laporan', compact('data', 'title'));
    }
}
