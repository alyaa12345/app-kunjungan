<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Kunjungan;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class MasyarakatController extends Controller
{
    // ================================================================
    // 1. DASHBOARD UTAMA
    // ================================================================
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

        return view('masyarakat.index', compact('kunjungans', 'statistik'));
    }

    // ================================================================
    // 2. HALAMAN FORMULIR PENGAJUAN (CREATE)
    // ================================================================
    public function create()
    {
        return view('masyarakat.create');
    }

    // ================================================================
    // 3. PROSES SIMPAN DATA (STORE)
    // ================================================================
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

    // ================================================================
    // 4. HALAMAN DETAIL KUNJUNGAN (TIKET)
    // ================================================================
    public function show($id)
    {
        $kunjungan = Kunjungan::where('id', $id)
            ->where('user_id', Auth::id())
            ->firstOrFail();

        return view('masyarakat.show', compact('kunjungan'));
    }

    // ================================================================
    // 5. HALAMAN RIWAYAT KUNJUNGAN
    // ================================================================
    public function riwayat()
    {
        $kunjungans = Kunjungan::where('user_id', Auth::id())
            ->orderBy('created_at', 'desc')
            ->get();

        return view('masyarakat.riwayat', compact('kunjungans'));
    }

    // ================================================================
    // 6. HALAMAN LAPORAN / REKAPITULASI (FITUR PDF & EXCEL)
    // ================================================================
    public function laporan(Request $request)
    {
        // 1. Ambil data HANYA milik user yang login
        // Pastikan load relasi 'petugas' agar nama verifikator muncul
        $query = Kunjungan::with('petugas')->where('user_id', Auth::id());

        // 2. Filter Status (Jika user memilih dropdown)
        if ($request->has('status') && $request->status != 'semua') {
            $query->where('status', $request->status);
        }

        // 3. PENTING: Order by ASC (Januari -> Februari) agar grouping di PDF rapi
        $data = $query->orderBy('tanggal_kunjungan', 'asc')->get();

        // 4. Return ke view laporan baru yang kita perbaiki
        return view('masyarakat.laporan', compact('data'));
    }
}
