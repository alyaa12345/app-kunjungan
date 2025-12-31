<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Kunjungan;
use Carbon\Carbon;

class KepalaController extends Controller
{
    // DASHBOARD UTAMA: STATISTIK & MONITORING
    public function index()
    {
        // 1. Ambil Tanggal Hari Ini
        $today = Carbon::today();

        // 2. Hitung Statistik Hari Ini
        $stats = [
            'total_hari_ini' => Kunjungan::whereDate('created_at', $today)->count(),
            'disetujui'      => Kunjungan::whereDate('created_at', $today)->where('status', 'disetujui')->count(),
            'ditolak'        => Kunjungan::whereDate('created_at', $today)->where('status', 'ditolak')->count(),
            'menunggu'       => Kunjungan::whereDate('created_at', $today)->where('status', 'menunggu')->count(),
        ];

        // 3. Ambil 5 Aktivitas Terbaru (Log Kinerja Petugas)
        // Menampilkan data yang baru saja diproses oleh petugas
        $terbaru = Kunjungan::whereIn('status', ['disetujui', 'ditolak'])
            ->latest('updated_at')
            ->take(5)
            ->get();

        return view('kepala.index', compact('stats', 'terbaru'));
    }

    // HALAMAN LAPORAN: FILTER PER HARI/MINGGU/BULAN
    public function laporan(Request $request)
    {
        // Default: Tampilkan data bulan ini jika tidak ada filter
        $query = Kunjungan::query();

        // Filter Berdasarkan Tanggal (Dari User)
        if ($request->filled('start_date') && $request->filled('end_date')) {
            $query->whereBetween('tanggal_kunjungan', [$request->start_date, $request->end_date]);
            $title = "Laporan Periode " . Carbon::parse($request->start_date)->format('d M Y') . " - " . Carbon::parse($request->end_date)->format('d M Y');
        }
        // Filter Cepat (Opsional: jika Anda ingin tombol cepat)
        elseif ($request->periode == 'hari_ini') {
            $query->whereDate('tanggal_kunjungan', Carbon::today());
            $title = "Laporan Hari Ini (" . Carbon::today()->format('d M Y') . ")";
        } elseif ($request->periode == 'minggu_ini') {
            $query->whereBetween('tanggal_kunjungan', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()]);
            $title = "Laporan Minggu Ini";
        } elseif ($request->periode == 'bulan_ini') {
            $query->whereMonth('tanggal_kunjungan', Carbon::now()->month);
            $title = "Laporan Bulan " . Carbon::now()->format('F Y');
        } else {
            // Default semua data (diurutkan terbaru)
            $title = "Semua Arsip Data";
        }

        // Pencarian Nama
        if ($request->filled('search')) {
            $query->where('nama_pengunjung', 'like', '%' . $request->search . '%');
        }

        $laporan = $query->latest()->get();

        return view('kepala.laporan', compact('laporan', 'title'));
    }
}
