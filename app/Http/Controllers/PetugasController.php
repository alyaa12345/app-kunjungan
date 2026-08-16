<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Twilio\Rest\Client;
use App\Models\Kunjungan;
use App\Models\Survei;
use App\Models\Tahanan;
use App\Models\Titipan;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class PetugasController extends Controller
{
    // ====================================================
    // FUNGSI TAMBAHAN KHUSUS WHATSAPP GATEWAY (TWILIO)
    // ====================================================
    private function kirimWhatsApp($nomorHp, $pesan)
    {
        $sid    = env('TWILIO_SID');
        $token  = env('TWILIO_AUTH_TOKEN');
        $fromWa = env('TWILIO_WHATSAPP_FROM');

        // Pastikan format nomor HP ke +62
        if (substr($nomorHp, 0, 1) === '0') {
            $nomorHp = '+62' . substr($nomorHp, 1);
        } elseif (substr($nomorHp, 0, 2) === '62') {
            $nomorHp = '+' . $nomorHp;
        }

        try {
            $twilio = new Client($sid, $token);
            $twilio->messages->create(
                "whatsapp:" . $nomorHp,
                [
                    "from" => "whatsapp:" . $fromWa,
                    "body" => $pesan
                ]
            );
            return true;
        } catch (\Exception $e) {
            return false;
        }
    }

    // ====================================================
    // 1. DASHBOARD UTAMA (MURNI KEJAKSAAN)
    // ====================================================
    public function index()
    {
        $hari_ini = \Carbon\Carbon::today();

        // 1. Ambil SEMUA data kunjungan yang statusnya 'menunggu' (Tanpa dibatasi tanggal)
        $kunjungans = Kunjungan::with('user')
            ->where('status', 'menunggu')
            ->orderBy('created_at', 'asc') // Yang paling lama daftar, diverifikasi duluan
            ->get();

        // 2. Hitung statistik untuk Dashboard Petugas
        $menungguVerifikasi = Kunjungan::where('status', 'menunggu')->count();
        $totalKunjungan = Kunjungan::whereDate('updated_at', $hari_ini)
            ->where('status', 'disetujui')
            ->count();

        // Kirimkan variabel ke view petugas.index
        return view('petugas.index', compact(
            'totalKunjungan',
            'menungguVerifikasi',
            'kunjungans'
        ));
    }

    // ====================================================
    // 2. MANAJEMEN DATA TAHANAN
    // ====================================================
    public function dataTahanan()
    {
        $tahanans = Tahanan::latest()->get();
        return view('petugas.tahanan', compact('tahanans'));
    }

    public function storeTahanan(Request $request)
    {
        $request->validate([
            'nama_tahanan'   => 'required',
            'no_tahanan'     => 'required',
            'no_register'    => 'required|unique:tahanans,no_register',
            'jenis_kelamin'  => 'required',
            'pasal'          => 'required',
            'lokasi_tahanan' => 'required',
            'status'         => 'required',
        ]);

        Tahanan::create([
            'nama_tahanan'   => $request->nama_tahanan,
            'no_tahanan'     => $request->no_tahanan,
            'no_register'    => $request->no_register,
            'jenis_kelamin'  => $request->jenis_kelamin,
            'pasal'          => $request->pasal,
            'lokasi_tahanan' => $request->lokasi_tahanan,
            'status'         => $request->status,
        ]);

        return back()->with('success', 'Data Tahanan Berhasil Disimpan');
    }

    public function editTahanan($id)
    {
        $tahanan = Tahanan::findOrFail($id);
        return view('petugas.edit_tahanan', compact('tahanan'));
    }

    public function updateTahanan(Request $request, $id)
    {
        $tahanan = Tahanan::findOrFail($id);

        $request->validate([
            'nama_tahanan' => 'required',
            'no_tahanan'   => 'required',
            'no_register'  => 'required|unique:tahanans,no_register,' . $tahanan->id,
            'status'       => 'required',
        ]);

        $tahanan->update([
            'nama_tahanan'   => $request->nama_tahanan,
            'no_tahanan'     => $request->no_tahanan,
            'no_register'    => $request->no_register,
            'jenis_kelamin'  => $request->jenis_kelamin,
            'pasal'          => $request->pasal,
            'lokasi_tahanan' => $request->lokasi_tahanan,
            'status'         => $request->status,
        ]);

        return redirect()->route('petugas.tahanan.index')->with('success', 'Data Tahanan Berhasil Diperbarui!');
    }

    // ====================================================
    // 3. PROSES VERIFIKASI KUNJUNGAN
    // ====================================================
    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:disetujui,ditolak',
            'alasan' => 'nullable|string'
        ]);

        $kunjungan = Kunjungan::findOrFail($id);
        $statusBaru = $request->status;

        if ($statusBaru == 'disetujui') {
            $tahanan = Tahanan::where('nama_tahanan', 'LIKE', '%' . $kunjungan->nama_tahanan . '%')->first();

            if ($tahanan) {
                if ($tahanan->status != 'Aktif') {
                    $kunjungan->update([
                        'status' => 'ditolak',
                        'alasan_penolakan' => 'Sistem: Tahanan berstatus ' . strtoupper($tahanan->status)
                    ]);
                    return back()->with('error', 'GAGAL! Tahanan sedang ' . strtoupper($tahanan->status));
                }

                try {
                    $tglKunjungan = Carbon::parse($kunjungan->tanggal_kunjungan);
                    $startOfWeek = $tglKunjungan->copy()->startOfWeek();
                    $endOfWeek   = $tglKunjungan->copy()->endOfWeek();

                    $jumlahMingguIni = Kunjungan::where('nama_tahanan', $kunjungan->nama_tahanan)
                        ->where('status', 'disetujui')
                        ->where('id', '!=', $id)
                        ->whereBetween('tanggal_kunjungan', [$startOfWeek, $endOfWeek])
                        ->count();

                    $batas = $tahanan->jatah_kunjungan ?? 2;

                    if ($jumlahMingguIni >= $batas) {
                        $kunjungan->update([
                            'status' => 'ditolak',
                            'alasan_penolakan' => 'Sistem: Jatah kunjungan mingguan habis.'
                        ]);
                        return back()->with('error', 'OTOMATIS DITOLAK: Kuota Mingguan Habis.');
                    }
                } catch (\Exception $e) {
                }
            }
        }

        $kunjungan->update([
            'status' => $statusBaru,
            'alasan_penolakan' => $request->alasan ?? null,
        ]);

        // MENGIRIM PESAN WHATSAPP KE USER
        if ($kunjungan->user && $kunjungan->user->no_hp) {
            $namaUser = $kunjungan->user->name;
            $waUser = $kunjungan->user->no_hp;

            if ($statusBaru == 'disetujui') {
                $pesanWa = "Halo *$namaUser*,\n\nPermohonan kunjungan Anda untuk tahanan *{$kunjungan->nama_tahanan}* telah *DISETUJUI* ✅.\n\nSilakan datang sesuai jadwal membawa identitas asli.";
            } else {
                $pesanWa = "Halo *$namaUser*,\n\nMohon maaf, permohonan kunjungan Anda *DITOLAK* ❌.\nAlasan: *{$request->alasan}*";
            }

            $this->kirimWhatsApp($waUser, $pesanWa);
        }

        $pesan = ($statusBaru == 'disetujui') ? 'Permohonan BERHASIL DISETUJUI ✅' : 'Permohonan DITOLAK ❌';
        return back()->with('success', $pesan);
    }

    // ====================================================
    // 4. RIWAYAT KUNJUNGAN (DENGAN FITUR PENCARIAN & FILTER)
    // ====================================================
    public function riwayat(Request $request)
    {
        // 1. Ambil data awal riwayat kunjungan yang sudah diproses beserta data usernya
        $query = \App\Models\Kunjungan::with('user')
            ->whereIn('status', ['disetujui', 'ditolak', 'selesai']);

        // 2. Logika Pencarian Teks (Berdasarkan Nama Tahanan atau Nama User Pemohon)
        if ($request->has('cari') && $request->cari != '') {
            $keyword = $request->cari;
            $query->where(function ($q) use ($keyword) {
                $q->where('nama_tahanan', 'like', '%' . $keyword . '%')
                  ->orWhereHas('user', function ($u) use ($keyword) {
                      $u->where('name', 'like', '%' . $keyword . '%');
                  });
            });
        }

        // 3. Logika Filter Status (disetujui / ditolak / selesai)
        if ($request->has('status') && $request->status != 'semua') {
            $query->where('status', $request->status);
        }

        // 4. Eksekusi query dan urutkan berdasarkan perubahan data terbaru
        $riwayat = $query->orderBy('updated_at', 'desc')->get();

        return view('petugas.riwayat', compact('riwayat'));
    }

    // ==========================================
    // FUNGSI EXPORT DATA KE EXCEL
    // ==========================================
    public function exportExcel(Request $request)
    {
        // 1. Ambil data filter dari URL
        $filter_type = $request->input('filter_type', 'harian');
        $status = $request->input('status', 'semua');

        // 2. Query Data Kunjungan (Sesuaikan dengan data yang mau di-export)
        $query = \App\Models\Kunjungan::query();

        // Filter Tanggal
        if ($filter_type == 'harian') {
            $query->whereDate('tanggal_kunjungan', \Carbon\Carbon::today());
        } elseif ($filter_type == 'bulanan') {
            $query->whereMonth('tanggal_kunjungan', \Carbon\Carbon::now()->month)
                ->whereYear('tanggal_kunjungan', \Carbon\Carbon::now()->year);
        }

        // Filter Status
        if ($status != 'semua') {
            $query->where('status', $status);
        }

        $laporan_detail = $query->get();

        // 3. Lempar data ke tampilan khusus Excel
        return view('petugas.laporan_excel', compact('laporan_detail', 'filter_type', 'status'));
    }

    // ====================================================
    // 8. MANAJEMEN TITIPAN BARANG (ADMINISTRATIF KEJAKSAAN)
    // ====================================================
    public function titipan(Request $request)
    {
        $query = Titipan::with('user');

        // 1. Logika Pencarian Teks (Berdasarkan ID / Nama)
        if ($request->has('cari') && $request->cari != '') {
            $keyword = $request->cari;
            $cleanId = preg_replace('/[^0-9]/', '', $keyword);
            $query->where(function ($q) use ($keyword, $cleanId) {
                if (!empty($cleanId)) {
                    $q->where('id', $cleanId);
                }
                $q->orWhere('nama_tahanan', 'like', '%' . $keyword . '%')
                    ->orWhereHas('user', function ($u) use ($keyword) {
                        $u->where('name', 'like', '%' . $keyword . '%');
                    });
            });
        }

        // 2. Logika Filter Status
        if ($request->has('status') && $request->status != 'semua') {
            if ($request->status == 'disetujui') {
                $query->whereIn('status', ['disetujui', 'diterima', 'selesai']);
            } else {
                $query->where('status', $request->status);
            }
        } else {
            // [PENTING] Jika tidak ada filter, HANYA tampilkan yang menunggu/diajukan
            $query->whereIn('status', ['menunggu', 'diajukan']);
        }

        $titipans = $query->latest()->get();

        // 3. Logika Pembuatan Data Grafik (Tren 7 Hari Terakhir)
        $grafikTanggal = [];
        $grafikDisetujui = [];
        $grafikDitolak = [];

        for ($i = 6; $i >= 0; $i--) {
            $date = Carbon::now()->subDays($i)->format('Y-m-d');
            $grafikTanggal[] = Carbon::now()->subDays($i)->translatedFormat('d M');

            // Hitung yang berhasil divalidasi (Disetujui / Selesai) pada hari tersebut
            $grafikDisetujui[] = Titipan::whereDate('created_at', $date)->whereIn('status', ['disetujui', 'diterima', 'selesai'])->count();
            // Hitung yang ditolak pada hari tersebut
            $grafikDitolak[] = Titipan::whereDate('created_at', $date)->where('status', 'ditolak')->count();
        }

        return view('petugas.titipan', compact('titipans', 'grafikTanggal', 'grafikDisetujui', 'grafikDitolak'));
    }

    // ====================================================
    // 9. PROSES VERIFIKASI TITIPAN BARANG
    // ====================================================
    public function verifikasiTitipan(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:disetujui,ditolak',
            'alasan' => 'nullable|string'
        ]);

        $titipan = Titipan::findOrFail($id);
        $statusBaru = $request->status;

        $titipan->update([
            'status' => $statusBaru,
            'alasan_penolakan' => $request->alasan ?? null,
        ]);

        // MENGIRIM PESAN WHATSAPP KE USER (Sama seperti Kunjungan)
        if ($titipan->user && $titipan->user->no_hp) {
            $namaUser = $titipan->user->name;
            $waUser = $titipan->user->no_hp;

            if ($statusBaru == 'disetujui') {
                $pesanWa = "Halo *$namaUser*,\n\nPermohonan titipan barang Anda untuk tahanan *{$titipan->nama_tahanan}* telah *DISETUJUI* ✅.\n\nSilakan bawa barang tersebut ke Rutan sesuai jadwal dan serahkan ke Petugas Lapas untuk dicek fisiknya.";
            } else {
                $pesanWa = "Halo *$namaUser*,\n\nMohon maaf, permohonan titipan barang Anda *DITOLAK* ❌.\nAlasan: *{$request->alasan}*";
            }

            $this->kirimWhatsApp($waUser, $pesanWa);
        }

        $pesan = ($statusBaru == 'disetujui') ? 'Titipan BERHASIL DISETUJUI ✅' : 'Titipan DITOLAK ❌';
        return back()->with('success', $pesan);
    }

    // ====================================================
    // 10. CETAK LABEL TITIPAN BARANG
    // ====================================================
    public function cetakLabel($id)
    {
        // Mengambil data titipan beserta data user yang menitipkan
        $titipan = Titipan::with('user')->findOrFail($id);

        // Melempar data ke tampilan cetak
        return view('petugas.cetak_titipan', compact('titipan'));
    }

    public function survei()
    {
        // Hitung Statistik Dasar
        $rataRataBintang = \App\Models\Survei::avg('bintang') ?? 0;
        $totalResponden  = \App\Models\Survei::count();

        // --- TAMBAHAN BARU: Hitung Sentimen Survei untuk Chart ---
        $sentimen = [
            'puas'       => \App\Models\Survei::where('bintang', '>=', 4)->count(),
            'tidak_puas' => \App\Models\Survei::where('bintang', '<', 4)->count(),
        ];

        // Ambil SEMUA data ulasan (terbaru dulu)
        $semuaUlasan = \App\Models\Survei::with('user')->latest()->get();

        // Pastikan variabel 'sentimen' dimasukkan ke dalam compact!
        return view('petugas.survei', compact('rataRataBintang', 'totalResponden', 'sentimen', 'semuaUlasan'));
    }

    // ==========================================
    // TAMPILAN WEB LAPORAN STATISTIK PETUGAS
    // ==========================================
    public function laporan(Request $request)
    {
        // 1. Tangkap filter dari URL (Default: harian & semua)
        $filter_type = $request->input('filter_type', 'harian');
        $status = $request->input('status', 'semua');

        // 2. Mulai Query
        $query = \App\Models\Kunjungan::query();

        // 3. Logika Filter Periode
        if ($filter_type == 'harian') {
            $query->whereDate('tanggal_kunjungan', \Carbon\Carbon::today());
            $title = "Laporan Harian: " . \Carbon\Carbon::today()->translatedFormat('d F Y');
        } elseif ($filter_type == 'bulanan') {
            $query->whereMonth('tanggal_kunjungan', \Carbon\Carbon::now()->month)
                ->whereYear('tanggal_kunjungan', \Carbon\Carbon::now()->year);
            $title = "Laporan Bulanan: " . \Carbon\Carbon::now()->translatedFormat('F Y');
        }

        // 4. Logika Filter Status
        if ($status != 'semua') {
            $query->where('status', $status);
        }

        // 5. Eksekusi Query
        $laporan_detail = $query->latest()->get();

        return view('petugas.laporan', compact('laporan_detail', 'title'));
    }

    // ====================================================
    // CETAK LAPORAN SURVEI (CSI) - TAMBAHAN BARU
    // ====================================================
    public function cetakLaporanSurvei()
    {
        // Hitung Statistik Dasar Survei
        $rataRataBintang = \App\Models\Survei::avg('bintang') ?? 0;
        $totalResponden  = \App\Models\Survei::count();

        // Ambil SEMUA data ulasan masyarakat
        $semuaUlasan = \App\Models\Survei::with('user')->latest()->get();

        // Lempar data ke view khusus cetak
        return view('petugas.cetak-laporan', compact('rataRataBintang', 'totalResponden', 'semuaUlasan'));
    }
}