<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Kunjungan;
use App\Models\Survei;      // Model Baru: Survei Kepuasan
use Carbon\Carbon;

class KepalaController extends Controller
{
    public function __construct()
    {
        Carbon::setLocale('id');
        date_default_timezone_set('Asia/Makassar');
    }

    // ====================================================
    // 1. DASHBOARD UTAMA (MONITORING KINERJA)
    // ====================================================
    public function index(Request $request)
    {
        $today = Carbon::today();

        // Statistik
        $stats = [
            'total_hari_ini' => Kunjungan::whereDate('created_at', $today)->count(),
            'disetujui'      => Kunjungan::whereDate('updated_at', $today)->where('status', 'disetujui')->count(),
            'ditolak'        => Kunjungan::whereDate('updated_at', $today)->where('status', 'ditolak')->count(),
            'menunggu'       => Kunjungan::where('status', 'menunggu')->count(),
        ];

        // Tabel Aktivitas Terbaru
        // PERBAIKAN: Saya hapus 'petugas' dari sini agar tidak error
        $query = Kunjungan::with(['user'])->latest('updated_at');

        if ($request->has('filter') && $request->filter != '') {
            $query->where('status', $request->filter);
            $terbaru = $query->take(20)->get();
        } else {
            $terbaru = $query->take(5)->get();
        }

        return view('kepala.index', compact('stats', 'terbaru'));
    }

    // ====================================================
    // HELPER: LOGIKA FILTER (Dipakai Laporan, Preview, Excel)
    // ====================================================
    private function getFilteredData(Request $request)
    {
        // PERBAIKAN: Saya hapus 'petugas' dari sini juga
        $query = Kunjungan::with(['user']);

        // 1. Filter Status
        if ($request->has('status') && $request->status != 'semua' && $request->status != '') {
            $query->where('status', $request->status);
        }

        // 2. Filter Rentang Tanggal
        if ($request->filled('start_date') && $request->filled('end_date')) {
            $query->whereBetween('tanggal_kunjungan', [$request->start_date, $request->end_date]);
        } elseif ($request->periode == 'hari_ini') {
            $query->whereDate('tanggal_kunjungan', Carbon::today());
        } elseif ($request->periode == 'bulan_ini') {
            $query->whereMonth('tanggal_kunjungan', Carbon::now()->month)
                ->whereYear('tanggal_kunjungan', Carbon::now()->year);
        }

        // === TAMBAHAN BARU: Filter Bulan & Tahun Dropdown ===
        if ($request->filled('bulan')) {
            $query->whereMonth('tanggal_kunjungan', $request->bulan);
        }

        if ($request->filled('tahun')) {
            $query->whereYear('tanggal_kunjungan', $request->tahun);
        }
        // =====================================================

        // 3. Pencarian
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('nama_pengunjung', 'like', "%{$search}%")
                    ->orWhere('nama_tahanan', 'like', "%{$search}%");
            });
        }

        // Urutkan dari yang terbaru
        return $query->orderBy('tanggal_kunjungan', 'desc')
            ->orderBy('jam_kunjungan', 'desc')
            ->get();
    }

    // ====================================================
    // 2. HALAMAN LAPORAN EVALUASI
    // ====================================================
    public function laporan(Request $request)
    {
        $data = $this->getFilteredData($request);

        $statusLabel = match ($request->status) {
            'menunggu' => 'MENUNGGU VERIFIKASI',
            'disetujui' => 'DISETUJUI',
            'ditolak' => 'DITOLAK',
            default => 'SEMUA DATA'
        };
        $title = "FILTER: " . $statusLabel;

        return view('kepala.laporan', compact('data', 'title'));
    }

    public function previewExcel(Request $request)
    {
        $data = $this->getFilteredData($request);

        // Kita kirim variabel 'isPreview' => true
        return view('kepala.excel', [
            'data' => $data,
            'isPreview' => true
        ]);
    }

    // B. Download (Langsung jadi File Bersih)
    public function downloadExcel(Request $request)
    {
        $data = $this->getFilteredData($request);
        $fileName = 'Laporan_Kunjungan_' . date('d-m-Y_H-i') . '.xls';

        header("Content-Type: application/vnd.ms-excel");
        header("Content-Disposition: attachment; filename=\"$fileName\"");

        // Kita kirim variabel 'isPreview' => false
        return view('kepala.excel', [
            'data' => $data,
            'isPreview' => false
        ]);
    }


    public function titipan(Request $request)
    {
        // PERBAIKAN: Tambahkan ->with('user') agar nama akun pengirim terbaca!
        $query = \App\Models\Titipan::with('user');

        // Filter Status
        if ($request->has('status') && $request->status != 'semua') {
            $query->where('status', $request->status);
        }

        $data = $query->latest()->paginate(10); // Pakai paginate untuk di layar

        return view('kepala.titipan', compact('data'));
    }

    public function cetakTitipan(Request $request)
    {
        // PERBAIKAN: Tambahkan ->with('user') disini juga
        $query = \App\Models\Titipan::with('user');

        if ($request->has('status') && $request->status != 'semua') {
            $query->where('status', $request->status);
        }

        $data = $query->latest()->get(); // Ambil semua untuk dicetak

        return view('kepala.titipan_cetak', compact('data'));
    }
    
    // ====================================================
    // 11. HALAMAN HASIL SURVEI (FITUR TERPISAH)
    // ====================================================
    public function survei()
    {
        // Hitung Statistik
        $rataRataBintang = Survei::avg('bintang') ?? 0;
        $totalResponden  = Survei::count();

        // --- TAMBAHAN BARU: Hitung Sentimen Survei ---
        // Asumsi: Bintang 4-5 = Puas | Bintang 1-3 = Tidak Puas
        $sentimen = [
            'puas'       => Survei::where('bintang', '>=', 4)->count(),
            'tidak_puas' => Survei::where('bintang', '<', 4)->count(),
        ];

        // Ambil SEMUA data ulasan (terbaru dulu)
        $semuaUlasan = Survei::with('user')->latest()->get();

        // Tambahkan 'sentimen' ke dalam compact
        return view('kepala.survei', compact('rataRataBintang', 'totalResponden', 'sentimen', 'semuaUlasan'));
    }
}