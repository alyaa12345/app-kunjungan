<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Kunjungan;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class MasyarakatController extends Controller
{
    // 1. Dashboard Utama Masyarakat
    public function index()
    {
        $userId = Auth::id();

        // Ambil Data Kunjungan milik user yang login
        $kunjungans = Kunjungan::where('user_id', $userId)
            ->orderBy('created_at', 'desc')
            ->get();

        // Hitung Statistik untuk Card Dashboard
        $statistik = [
            'total'     => $kunjungans->count(),
            'menunggu'  => $kunjungans->where('status', 'menunggu')->count(),
            'disetujui' => $kunjungans->where('status', 'disetujui')->count(),
            'ditolak'   => $kunjungans->where('status', 'ditolak')->count(),
        ];

        // Pastikan folder view Anda bernama 'masyarakat' atau 'masyarakat', sesuaikan di sini
        return view('masyarakat.index', compact('kunjungans', 'statistik'));
    }

    // 2. Halaman Formulir Pengajuan (Create)
    public function create()
    {
        return view('masyarakat.create');
    }

    // 3. Proses Simpan Data (Store)
    public function store(Request $request)
    {
        // Validasi Input
        $request->validate([
            'nama_pengunjung'   => 'required|string|max:255',
            'nik_pengunjung'    => 'required|numeric|digits:16',
            'jenis_kelamin'     => 'required',
            'alamat_pengunjung' => 'required|string',
            'hubungan_tahanan'  => 'required|string',
            'nama_tahanan'      => 'required|string',
            'nomor_kamar'       => 'required|string',
            'kasus_tahanan'     => 'required|string',
            'tanggal_kunjungan' => 'required|date|after_or_equal:today',
            'jam_kunjungan'     => 'required',
            'keperluan'         => 'required|string',
            'jumlah_pengikut'   => 'required|integer|min:0|max:5',
            'foto_ktp'          => 'required|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        // Proses Upload File KTP
        $pathKtp = null;
        if ($request->hasFile('foto_ktp')) {
            $pathKtp = $request->file('foto_ktp')->store('ktp_uploads', 'public');
        }

        // Simpan Data ke Database
        Kunjungan::create([
            'user_id'           => Auth::id(),
            'nama_pengunjung'   => $request->nama_pengunjung,
            'nik_pengunjung'    => $request->nik_pengunjung,
            'jenis_kelamin'     => $request->jenis_kelamin,
            'alamat_pengunjung' => $request->alamat_pengunjung,
            'hubungan_tahanan'  => $request->hubungan_tahanan,
            'nama_tahanan'      => $request->nama_tahanan,
            'nomor_kamar'       => $request->nomor_kamar,
            'kasus_tahanan'     => $request->kasus_tahanan,
            'tanggal_kunjungan' => $request->tanggal_kunjungan,
            'jam_kunjungan'     => $request->jam_kunjungan,
            'keperluan'         => $request->keperluan,
            'jumlah_pengikut'   => $request->jumlah_pengikut,
            'foto_ktp'          => $pathKtp,
            'status'            => 'menunggu',
        ]);

        return redirect()->route('masyarakat.index')->with('success', 'Permohonan kunjungan berhasil dikirim!');
    }

    // 4. Halaman Detail Kunjungan (Tiket)
    public function show($id)
    {
        $kunjungan = Kunjungan::where('id', $id)
            ->where('user_id', Auth::id())
            ->firstOrFail();

        return view('masyarakat.show', compact('kunjungan'));
    }

    // 5. Halaman Riwayat Kunjungan
    public function riwayat()
    {
        $kunjungans = Kunjungan::where('user_id', Auth::id())
            ->orderBy('created_at', 'desc')
            ->get();

        // Pastikan view ini ada di folder resources/views/masyarakat/riwayat.blade.php
        return view('masyarakat.riwayat', compact('kunjungans'));
    }

    // 6. Halaman Laporan Dinamis
    public function laporan($jenis)
    {
        $userId = Auth::id();
        $query = Kunjungan::where('user_id', $userId)->orderBy('created_at', 'desc');

        $data = $query->get();
        $judul = '';

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

        return view('masyarakat.laporan', compact('data', 'jenis', 'judul'));
    }
}
