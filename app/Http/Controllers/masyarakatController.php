<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Kunjungan;
use App\Models\Titipan;
use App\Models\Survei;

class MasyarakatController extends Controller
{
    // ====================================================
    // 1. DASHBOARD
    // ====================================================
    public function index()
    {
        $kunjungans = Kunjungan::where('user_id', Auth::id())->latest()->take(5)->get();
        return view('masyarakat.index', compact('kunjungans'));
    }

    // ====================================================
    // 2. FORMULIR PENGAJUAN KUNJUNGAN
    // ====================================================
    public function create()
    {
        return view('masyarakat.create');
    }

    // ====================================================
    // 3. CEK KUOTA (SISTEM REAL-TIME)
    // ====================================================
    public function checkQuota(Request $request)
    {
        $tanggal = $request->date;
        $limit = 20;

        $pagi = Kunjungan::where('tanggal_kunjungan', $tanggal)
            ->where('jam_kunjungan', 'pagi')
            ->where('status', '!=', 'ditolak')
            ->count();

        $siang = Kunjungan::where('tanggal_kunjungan', $tanggal)
            ->where('jam_kunjungan', 'siang')
            ->where('status', '!=', 'ditolak')
            ->count();

        return response()->json([
            'pagi_sisa' => $limit - $pagi,
            'pagi_status' => ($pagi >= $limit) ? 'FULL' : 'OPEN',
            'siang_sisa' => $limit - $siang,
            'siang_status' => ($siang >= $limit) ? 'FULL' : 'OPEN',
        ]);
    }

    // ====================================================
    // 4. SIMPAN DATA KUNJUNGAN
    // ====================================================
    public function store(Request $request)
    {
        // A. Validasi Input
        $request->validate([
            'nama_pengunjung'   => 'required',
            'nik_pengunjung'    => 'required',
            'jenis_kelamin'     => 'required',
            'alamat_pengunjung' => 'required',
            'hubungan_tahanan'  => 'required',
            'nama_tahanan'      => 'required',
            'nama_bin'          => 'required',
            'lokasi_tahanan'    => 'required', // Blok Kamar
            // 'detail_kamar' bisa null/opsional tergantung form, jadi tidak di-required keras
            'kasus_tahanan'     => 'required',
            'tanggal_kunjungan' => 'required|date|after_or_equal:today',
            'jam_kunjungan'     => 'required',
            'jumlah_pengikut'   => 'required|integer|max:5',
            'foto_ktp'          => 'required|image|max:2048',
        ]);

        // B. Upload Foto KTP
        $path = $request->file('foto_ktp')->store('ktp_uploads', 'public');

        // C. Simpan ke Database
        // Pastikan nama kolom di kiri sesuai dengan migration database Anda!
        Kunjungan::create([
            'user_id'           => Auth::id(),

            // Data Pengunjung
            'nama_pengunjung'   => $request->nama_pengunjung,
            'nik_pengunjung'    => $request->nik_pengunjung,
            'jenis_kelamin'     => $request->jenis_kelamin,
            'alamat_pengunjung' => $request->alamat_pengunjung,
            'hubungan_tahanan'  => $request->hubungan_tahanan,

            // Data Tahanan
            'nama_tahanan'      => $request->nama_tahanan,
            'nama_bin'          => $request->nama_bin,
            'lokasi_tahanan'    => $request->lokasi_tahanan,

            // PENANGANAN KHUSUS ERROR 1364 (NOMOR KAMAR)
            // Kita kirim data ke 'nomor_kamar' ATAU 'detail_kamar' sesuai inputan form.
            // Jika di DB kolomnya 'nomor_kamar', dia ambil value. Jika 'detail_kamar', dia ambil value.
            'nomor_kamar'       => $request->detail_kamar ?? $request->nomor_kamar ?? '-',
            'detail_kamar'      => $request->detail_kamar ?? $request->nomor_kamar ?? '-',

            'kasus_tahanan'     => $request->kasus_tahanan,

            // Data Kunjungan
            'tanggal_kunjungan' => $request->tanggal_kunjungan,
            'jam_kunjungan'     => $request->jam_kunjungan,
            'jumlah_pengikut'   => $request->jumlah_pengikut,
            'keperluan'         => $request->keperluan ?? 'Kunjungan Rutin', // Default value jika kosong
            'catatan'           => $request->catatan,
            'foto_ktp'          => $path,
            'status'            => 'menunggu'
        ]);

        return redirect()->route('masyarakat.index')->with('success', 'Permohonan Berhasil Dikirim!');
    }

    // ====================================================
    // 5. RIWAYAT KUNJUNGAN & TITIPAN
    // ====================================================
    public function riwayat(Request $request)
    {
        $kategori = $request->get('kategori', 'kunjungan');

        if ($kategori == 'titipan') {
            $titipans = Titipan::where('user_id', Auth::id())->latest()->get();
            $kunjungans = collect();
        } else {
            $kunjungans = Kunjungan::where('user_id', Auth::id())->latest()->get();
            $titipans = collect();
        }

        return view('masyarakat.riwayat', compact('kunjungans', 'titipans', 'kategori'));
    }

    // ====================================================
    // 6. LAPORAN (BUKTI & TIKET)
    // ====================================================
    public function laporan(Request $request)
    {
        $kategori = $request->get('kategori', 'kunjungan');

        if ($kategori == 'titipan') {
            $titipans = Titipan::where('user_id', Auth::id())->where('status', 'diterima')->latest()->get();
            $kunjungans = collect();
        } else {
            $kunjungans = Kunjungan::where('user_id', Auth::id())->where('status', 'disetujui')->latest()->get();
            $titipans = collect();
        }

        return view('masyarakat.laporan', compact('kunjungans', 'titipans', 'kategori'));
    }

    // ====================================================
    // 7. DETAIL KUNJUNGAN
    // ====================================================
    public function show($id)
    {
        $kunjungan = Kunjungan::where('user_id', Auth::id())->findOrFail($id);
        return view('masyarakat.show', compact('kunjungan'));
    }

    // ====================================================
    // 8. HALAMAN BERI ULASAN (SURVEI)
    // ====================================================
    public function ulasan()
    {
        // Cari kunjungan yang SUDAH DISETUJUI tapi BELUM DINILAI (doesntHave survei)
        $belumDinilai = Kunjungan::where('user_id', Auth::id())
            ->where('status', 'disetujui')
            ->doesntHave('survei') // Pastikan relasi 'survei' ada di model Kunjungan
            ->get();

        return view('masyarakat.ulasan', compact('belumDinilai'));
    }

    public function simpanSurvei(Request $request)
    {
        // 1. Validasi Input (Pastikan 3 skor ini terisi angka 1-5)
        $request->validate([
            'kunjungan_id'    => 'required|exists:kunjungans,id',
            'skor_pelayanan'  => 'required|integer|min:1|max:5',
            'skor_kebersihan' => 'required|integer|min:1|max:5',
            'skor_fasilitas'  => 'required|integer|min:1|max:5',
            'komentar'        => 'nullable|string'
        ]);

        // 2. Hitung Rata-Rata Otomatis
        // Contoh: Pelayanan(5) + Kebersihan(4) + Fasilitas(5) = 14 / 3 = 4.6 (Dibulatkan jadi 5 Bintang)
        $totalSkor = $request->skor_pelayanan + $request->skor_kebersihan + $request->skor_fasilitas;
        $rataRata  = round($totalSkor / 3);

        // 3. Simpan ke Database
        Survei::create([
            'user_id'         => Auth::id(),
            'kunjungan_id'    => $request->kunjungan_id,

            // Simpan detail penilaian
            'skor_pelayanan'  => $request->skor_pelayanan,
            'skor_kebersihan' => $request->skor_kebersihan,
            'skor_fasilitas'  => $request->skor_fasilitas,

            // Simpan hasil rata-rata ke kolom 'bintang' (biar dashboard petugas tetap jalan)
            'bintang'         => $rataRata,

            'komentar'        => $request->komentar
        ]);

        return redirect()->back()->with('success', 'Terima kasih! Penilaian Anda telah kami terima.');
    }
}
