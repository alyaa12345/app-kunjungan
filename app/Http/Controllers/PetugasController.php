<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Kunjungan;
use App\Models\Titipan;     // Model Baru: Titipan Barang
use App\Models\Survei;      // Model Baru: Survei Kepuasan
use App\Models\Tahanan;     // Model Baru: Master Data Tahanan
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class PetugasController extends Controller
{
    // ====================================================
    // 1. DASHBOARD UTAMA (MEJA VERIFIKASI & STATISTIK)
    // ====================================================
    public function index()
    {
        // Statistik Ringkas
        $totalKunjungan = Kunjungan::whereDate('tanggal_kunjungan', today())->count();
        $totalTitipan   = Titipan::whereDate('created_at', today())->count();
        $menungguVerifikasi = Kunjungan::where('status', 'menunggu')->count();
        $titipanBaru    = Titipan::where('status', 'diajukan')->count();

        // Antrian Kunjungan (Menunggu)
        $kunjungans = Kunjungan::with('user')
            ->where('status', 'menunggu')
            ->orderBy('created_at', 'asc')
            ->get();

        return view('petugas.index', compact(
            'totalKunjungan',
            'totalTitipan',
            'menungguVerifikasi',
            'titipanBaru',
            'kunjungans'
        ));
    }

    // ====================================================
    // 2. MANAJEMEN DATA TAHANAN (MASTER DATA)
    // ====================================================
    public function dataTahanan()
    {
        $tahanans = Tahanan::latest()->get();
        return view('petugas.tahanan', compact('tahanans'));
    }

    public function simpanTahanan(Request $request)
    {
        // PERBAIKAN: Menambahkan 'kasus' agar tidak error database
        $request->validate([
            'nama_lengkap' => 'required',
            'nama_bin' => 'required',
            'nomor_registrasi' => 'required|unique:tahanans',
            'blok_kamar' => 'required',
            'kasus' => 'required', // <--- WAJIB ADA
        ]);

        Tahanan::create($request->all());
        return back()->with('success', 'Data Tahanan Berhasil Disimpan');
    }

    // ====================================================
    // 3. PROSES VERIFIKASI (SUDAH DIPERBAIKI TOTAL)
    // ====================================================
    public function updateStatus(Request $request, $id)
    {
        // 1. Validasi Input
        $request->validate([
            'status' => 'required|in:disetujui,ditolak',
            'alasan' => 'nullable|string'
        ]);

        // 2. Ambil Data Kunjungan
        $kunjungan = Kunjungan::findOrFail($id);
        $statusBaru = $request->status;

        // --- LOGIKA PENGECEKAN (HANYA JIKA DISETUJUI) ---
        if ($statusBaru == 'disetujui') {

            // A. Cari Data Tahanan (Pakai 'LIKE' biar huruf besar/kecil tidak masalah)
            // Contoh: Cari "Emel" akan ketemu meski di database "EMEL" atau "Emel S.H."
            $tahanan = Tahanan::where('nama_lengkap', 'LIKE', '%' . $kunjungan->nama_tahanan . '%')->first();

            if ($tahanan) {
                // B. Cek Status Tahanan (Jika Sakit/Isolasi -> TOLAK)
                if (strtolower($tahanan->status) != 'normal') {
                    // Update jadi DITOLAK
                    $kunjungan->update([
                        'status' => 'ditolak',
                        'alasan_penolakan' => 'Sistem: Tahanan sedang status ' . strtoupper($tahanan->status)
                    ]);
                    return back()->with('error', 'GAGAL! Tahanan sedang ' . strtoupper($tahanan->status));
                }

                // C. Cek Kuota Mingguan (LOGIKA TANGGAL DIPERBAIKI)
                try {
                    // Ambil tanggal kunjungan yang diajukan
                    $tglKunjungan = Carbon::parse($kunjungan->tanggal_kunjungan);

                    // Hitung rentang minggu dari tanggal tersebut
                    $startOfWeek = $tglKunjungan->copy()->startOfWeek();
                    $endOfWeek   = $tglKunjungan->copy()->endOfWeek();

                    // Hitung berapa kali sudah dikunjungi minggu itu (Hanya yang status 'disetujui')
                    $jumlahMingguIni = Kunjungan::where('nama_tahanan', $kunjungan->nama_tahanan)
                        ->where('status', 'disetujui')
                        ->where('id', '!=', $id) // Jangan hitung diri sendiri
                        ->whereBetween('tanggal_kunjungan', [$startOfWeek, $endOfWeek])
                        ->count();

                    // Jika Jatah Habis -> TOLAK
                    // (Pastikan jatah > 0 agar tidak error jika data master kosong)
                    if ($tahanan->jatah_kunjungan > 0 && $jumlahMingguIni >= $tahanan->jatah_kunjungan) {
                        $kunjungan->update([
                            'status' => 'ditolak',
                            'alasan_penolakan' => 'Sistem: Jatah kunjungan mingguan tahanan sudah habis.'
                        ]);
                        return back()->with('error', 'OTOMATIS DITOLAK: Kuota Mingguan Habis (' . $jumlahMingguIni . '/' . $tahanan->jatah_kunjungan . ')');
                    }
                } catch (\Exception $e) {
                    // Jika ada error tanggal, abaikan saja dan lanjut setujui (biar tidak macet)
                }
            }
            // Jika Data Tahanan Tidak Ketemu di Master Data -> LANJUT SETUJUI SAJA (Bypass)
        }

        // 3. EKSEKUSI UPDATE STATUS (BAGIAN PENTING)
        $kunjungan->update([
            'status' => $statusBaru,
            'alasan_penolakan' => $request->alasan ?? null,
        ]);

        // 4. Beri Pesan Sukses
        $pesan = ($statusBaru == 'disetujui')
            ? 'Permohonan BERHASIL DISETUJUI ✅'
            : 'Permohonan DITOLAK ❌';

        return back()->with('success', $pesan);
    }

    // ====================================================
    // 4. MANAJEMEN TITIPAN BARANG (PENCARIAN PINTAR)
    // ====================================================
    public function titipan(Request $request)
    {
        $query = Titipan::with('user');

        if ($request->has('cari') && $request->cari != '') {
            $keyword = $request->cari;

            // LOGIKA PINTAR: 
            // Jika user ngetik "#TRX-1" atau "TRX-1", kita ambil angka "1"-nya saja.
            $cleanId = preg_replace('/[^0-9]/', '', $keyword);

            $query->where(function ($q) use ($keyword, $cleanId) {
                // 1. Cari berdasarkan ID (pakai ID yang sudah dibersihkan angkanya)
                if (!empty($cleanId)) {
                    $q->where('id', $cleanId);
                }

                // 2. ATAU cari berdasarkan Nama Tahanan (pakai keyword asli)
                $q->orWhere('nama_tahanan', 'like', '%' . $keyword . '%')

                    // 3. ATAU cari berdasarkan Nama Pengirim (pakai keyword asli)
                    ->orWhereHas('user', function ($u) use ($keyword) {
                        $u->where('name', 'like', '%' . $keyword . '%');
                    });
            });
        }

        $titipans = $query->latest()->get();
        return view('petugas.titipan', compact('titipans'));
    }

    // ====================================================
    // 5. RIWAYAT / ARSIP
    // ====================================================
    public function riwayat()
    {
        $riwayat = Kunjungan::whereIn('status', ['disetujui', 'ditolak'])
            ->latest()
            ->get();

        return view('petugas.riwayat', compact('riwayat'));
    }

    // ====================================================
    // 6. GATE CHECK (SCANNER)
    // ====================================================
    public function gateCheck(Request $request)
    {
        $visitor = null;
        $message = null;

        if ($request->has('tiket_id')) {
            $cleanId = preg_replace('/[^0-9]/', '', $request->tiket_id);
            $visitor = Kunjungan::where('id', $cleanId)->where('status', 'disetujui')->first();

            if (!$visitor) {
                $cekStatus = Kunjungan::find($cleanId);
                $message = $cekStatus
                    ? "Tiket ditemukan tetapi status: " . strtoupper($cekStatus->status)
                    : "Tiket ID #" . $cleanId . " tidak ditemukan.";
            }
        }

        return view('petugas.gate', compact('visitor', 'message'));
    }

    // ====================================================
    // 7. LAPORAN STATISTIK & HASIL SURVEI (PEMISAHAN JELAS)
    // ====================================================
    public function laporan(Request $request)
    {
        // 1. Siapkan Query Dasar
        $query = Kunjungan::query();

        // 2. Filter Berdasarkan STATUS (Baru)
        if ($request->has('status') && $request->status != 'semua') {
            $query->where('status', $request->status);
        }

        // 3. Filter Berdasarkan PENCARIAN NAMA (Baru)
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('nama_pengunjung', 'like', "%{$search}%")
                    ->orWhere('nama_tahanan', 'like', "%{$search}%")
                    ->orWhere('nik_pengunjung', 'like', "%{$search}%");
            });
        }

        // 4. Filter Berdasarkan WAKTU (Logika Lama Tetap Dipakai)
        $filterType = $request->input('filter_type', 'harian');
        $title = 'Laporan Harian (' . date('d M Y') . ')';

        if ($filterType == 'harian') {
            $tanggal = $request->input('tanggal', date('Y-m-d'));
            $query->whereDate('tanggal_kunjungan', $tanggal);
            $title = 'Laporan Harian: ' . \Carbon\Carbon::parse($tanggal)->format('d F Y');
        } elseif ($filterType == 'mingguan') {
            $start = $request->input('start_date', date('Y-m-d'));
            $end = $request->input('end_date', date('Y-m-d'));
            $query->whereBetween('tanggal_kunjungan', [$start, $end]);
            $title = 'Laporan Periode: ' . date('d/m/y', strtotime($start)) . ' s.d ' . date('d/m/y', strtotime($end));
        } elseif ($filterType == 'bulanan') {
            $bulan = $request->input('bulan', date('m'));
            $tahun = $request->input('tahun', date('Y'));
            $query->whereMonth('tanggal_kunjungan', $bulan)->whereYear('tanggal_kunjungan', $tahun);
            $title = 'Laporan Bulanan: ' . date('F Y', mktime(0, 0, 0, $bulan, 1, $tahun));
        } elseif ($filterType == 'tahunan') {
            $tahun = $request->input('tahun', date('Y'));
            $query->whereYear('tanggal_kunjungan', $tahun);
            $title = 'Laporan Tahunan: ' . $tahun;
        }

        // 5. Tambahkan Keterangan Filter di Judul
        if ($request->filled('status') && $request->status != 'semua') {
            $title .= ' (Status: ' . strtoupper($request->status) . ')';
        }

        // 6. Ambil Data
        $laporan_detail = $query->latest()->get();

        return view('petugas.laporan', compact('laporan_detail', 'title'));
    }

    // ====================================================
    // 8. LAPORAN MASUK (DATA TABEL)
    // ====================================================
    public function laporan_masuk(Request $request)
    {
        $query = Kunjungan::with(['user']);

        if ($request->has('status') && $request->status != 'semua') {
            $query->where('status', $request->status);
        }

        $data = $query->orderBy('tanggal_kunjungan', 'asc')->get();
        return view('petugas.laporan_masuk', compact('data'));
    }

    // ====================================================
    // 9. EXPORT EXCEL
    // ====================================================
    public function exportExcel(Request $request)
    {
        $query = Kunjungan::with(['user']);

        if ($request->has('status') && $request->status != 'semua') {
            $query->where('status', $request->status);
        }

        $data = $query->latest()->get();

        if ($request->get('action') == 'download') {
            $filename = "Laporan_Kunjungan_" . date('Y-m-d_H-i') . ".xls";
            header("Content-Type: application/vnd.ms-excel");
            header("Content-Disposition: attachment; filename=\"$filename\"");
            return view('petugas.excel', compact('data'))->with('is_download', true);
        }

        return view('petugas.excel', compact('data'))->with('is_download', false);
    }

    // ====================================================
    // 10. CETAK LABEL BARANG (FITUR TAMBAHAN)
    // ====================================================
    public function cetakLabel($id)
    {
        $titipan = Titipan::with('user')->findOrFail($id);
        return view('petugas.cetak_label', compact('titipan'));
    }
    // ====================================================
    // 11. HALAMAN HASIL SURVEI (FITUR TERPISAH)
    // ====================================================
    public function survei()
    {
        // Hitung Statistik
        $rataRataBintang = Survei::avg('bintang') ?? 0;
        $totalResponden  = Survei::count();

        // Ambil SEMUA data ulasan (terbaru dulu)
        $semuaUlasan = Survei::with('user')->latest()->get();

        return view('petugas.survei', compact('rataRataBintang', 'totalResponden', 'semuaUlasan'));
    }
    // ====================================================
    // FUNGSI BARU: PROSES TERIMA / TOLAK TITIPAN
    // ====================================================
    public function verifikasiTitipan(Request $request, $id)
    {
        // 1. Validasi Input
        $request->validate([
            'status' => 'required|in:diterima,ditolak',
            'alasan' => 'nullable|string'
        ]);

        // 2. Cari Data Titipan
        $titipan = Titipan::findOrFail($id);

        // 3. Update Status
        $titipan->update([
            'status' => $request->status,
            'alasan_penolakan' => $request->alasan ?? null, // Simpan alasan jika ditolak
        ]);

        // 4. Kembali dengan pesan sukses
        $pesan = $request->status == 'diterima' ? 'Titipan berhasil DITERIMA.' : 'Titipan berhasil DITOLAK.';
        return back()->with('success', $pesan);
    }
}
