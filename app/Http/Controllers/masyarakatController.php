<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Kunjungan;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class MasyarakatController extends Controller
{
    public function index()
    {
        $userId = Auth::id();

        // 1. Ambil Data Kunjungan
        $kunjungans = Kunjungan::where('user_id', $userId)
            ->orderBy('created_at', 'desc')
            ->get();

        // 2. Hitung Statistik untuk Card Dashboard
        $statistik = [
            'total'     => $kunjungans->count(),
            'menunggu'  => $kunjungans->where('status', 'menunggu')->count(),
            'disetujui' => $kunjungans->where('status', 'disetujui')->count(),
            'ditolak'   => $kunjungans->where('status', 'ditolak')->count(),
        ];

        return view('warga.index', compact('kunjungans', 'statistik'));
    }

    // 2. Halaman Formulir Pengajuan (Create)
    public function create()
    {
        return view('warga.create');
    }

    // 3. Proses Simpan Data ke Database (Store)
    public function store(Request $request)
    {
        // Validasi Input (Memastikan semua 7+ kolom terisi)
        $request->validate([
            // Identitas Pengunjung
            'nama_pengunjung' => 'required|string|max:255',
            'nik_pengunjung' => 'required|numeric|digits:16',
            'jenis_kelamin' => 'required',
            'alamat_pengunjung' => 'required|string',
            'hubungan_tahanan' => 'required|string',

            // Data Tahanan
            'nama_tahanan' => 'required|string',
            'nomor_kamar' => 'required|string',
            'kasus_tahanan' => 'required|string',

            // Detail Kunjungan
            'tanggal_kunjungan' => 'required|date|after_or_equal:today',
            'jam_kunjungan' => 'required',
            'keperluan' => 'required|string',
            'jumlah_pengikut' => 'required|integer|min:0|max:5',
            'foto_ktp' => 'required|image|mimes:jpeg,png,jpg|max:2048', // Max 2MB
        ]);

        // Proses Upload File KTP
        $pathKtp = null;
        if ($request->hasFile('foto_ktp')) {
            $pathKtp = $request->file('foto_ktp')->store('ktp_uploads', 'public');
        }

        // Simpan Data
        Kunjungan::create([
            'user_id' => Auth::id(), // ID User yang login otomatis tersimpan
            'nama_pengunjung' => $request->nama_pengunjung,
            'nik_pengunjung' => $request->nik_pengunjung,
            'jenis_kelamin' => $request->jenis_kelamin,
            'alamat_pengunjung' => $request->alamat_pengunjung,
            'hubungan_tahanan' => $request->hubungan_tahanan,
            'nama_tahanan' => $request->nama_tahanan,
            'nomor_kamar' => $request->nomor_kamar,
            'kasus_tahanan' => $request->kasus_tahanan,
            'tanggal_kunjungan' => $request->tanggal_kunjungan,
            'jam_kunjungan' => $request->jam_kunjungan,
            'keperluan' => $request->keperluan,
            'jumlah_pengikut' => $request->jumlah_pengikut,
            'foto_ktp' => $pathKtp,
            'status' => 'menunggu', // Default status saat baru submit
        ]);


        return redirect()->route('masyarakat.index')->with('success', 'Permohonan kunjungan berhasil dikirim! Silakan tunggu verifikasi.');
    }

    // 4. Halaman Detail & Status Balasan
    public function show($id)
    {
        // Cari data berdasarkan ID dan pastikan milik user yang sedang login (agar aman)
        $kunjungan = Kunjungan::where('id', $id)
            ->where('user_id', Auth::id())
            ->firstOrFail();

        return view('warga.show', compact('kunjungan'));
    }
    // 5. Halaman Pusat Laporan (Dinamis)
    public function laporan($jenis)
    {
        $userId = Auth::id();
        $query = Kunjungan::where('user_id', $userId)->orderBy('created_at', 'desc');

        // Siapkan data dasar
        $data = $query->get();
        $judul = '';

        // Logika Judul & Filter Data
        switch ($jenis) {
            case 'statistik':
                $judul = 'Laporan Statistik Ringkasan';
                break;
            case 'jadwal':
                $judul = 'Laporan Jadwal Kunjungan';
                break;
            case 'audit':
                $judul = 'Laporan Detail & Audit Trail';
                break;
            case 'dokumen':
                $judul = 'Laporan Status Dokumen';
                break;
            case 'notifikasi':
                $judul = 'Laporan Notifikasi & Riwayat';
                break;
            default:
                abort(404);
        }

        return view('warga.laporan', compact('data', 'jenis', 'judul'));
    }
    // ... fungsi index, store, show sebelumnya ...

    // FUNGSI RIWAYAT SAYA (BARU)
    public function riwayat()
    {
        // Ambil data kunjungan milik user yang sedang login saja
        // Urutkan dari yang terbaru
        $kunjungans = Kunjungan::where('user_id', Auth::id())
            ->orderBy('created_at', 'desc')
            ->get();

        return view('masyarakat.riwayat', compact('kunjungans'));
    }
}
}
