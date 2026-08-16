<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Kunjungan;
use App\Models\Titipan;
use App\Models\Survei;
use App\Models\Tahanan;

class MasyarakatController extends Controller
{
    // ====================================================
    // 1. DASHBOARD
    // ====================================================
    public function index()
    {
        // Mengambil 5 tiket kunjungan terbaru milik user yang login
        $kunjungans = Kunjungan::where('user_id', Auth::id())->latest()->take(5)->get();

        // Mengambil 5 tiket titipan terbaru milik user yang login
        $titipans = Titipan::where('user_id', Auth::id())->latest()->take(5)->get();

        // Ambil data tahanan agar Javascript di Modal Titipan Barang bisa mencari nomor tahanan
        $tahanans = Tahanan::where('status', 'Aktif')
            ->orderBy('nama_tahanan', 'asc')
            ->get();

        return view('masyarakat.index', compact('kunjungans', 'titipans', 'tahanans'));
    }

    // ====================================================
    // 2. FORMULIR PENGAJUAN (KUNJUNGAN)
    // ====================================================
    public function create()
    {
        // AMBIL SEMUA DATA BIAR KOLOM 'PASAL' ATAU APAPUN NAMANYA PASTI KETEMU
        $tahanans = Tahanan::where('status', 'Aktif')
            ->orderBy('nama_tahanan', 'asc')
            ->get();

        return view('masyarakat.create', compact('tahanans'));
    }

    // ====================================================
    // 3. PENCARIAN TAHANAN (API BACKUP)
    // ====================================================
    public function cariTahanan(Request $request)
    {
        $keyword = $request->input('q');
        $data = Tahanan::where('status', 'Aktif')
            ->where('nama_tahanan', 'LIKE', "%{$keyword}%")
            ->limit(10)
            ->get();

        return response()->json($data);
    }

    // ====================================================
    // 4. CEK KUOTA
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
    // 5. SIMPAN DATA KUNJUNGAN
    // ====================================================
    public function store(Request $request)
    {
        // Tambahkan no_tahanan pada validasi
        $request->validate([
            'nama_pengunjung'   => 'required',
            'nik_pengunjung'    => 'required',
            'jenis_kelamin'     => 'required',
            'alamat_pengunjung' => 'required',
            'hubungan_tahanan'  => 'required',
            'no_tahanan'        => 'required',
            'nama_tahanan'      => 'required',
            'lokasi_tahanan'    => 'required',
            'kasus_tahanan'     => 'required',
            'tanggal_kunjungan' => 'required|date|after_or_equal:today',
            'jam_kunjungan'     => 'required',
            'jumlah_pengikut'   => 'required|integer|max:5',
            'foto_ktp'          => 'required|image|max:2048',
        ]);

        $path = $request->file('foto_ktp')->store('ktp_uploads', 'public');

        Kunjungan::create([
            'user_id'           => Auth::id(),
            'nama_pengunjung'   => $request->nama_pengunjung,
            'nik_pengunjung'    => $request->nik_pengunjung,
            'jenis_kelamin'     => $request->jenis_kelamin,
            'alamat_pengunjung' => $request->alamat_pengunjung,
            'hubungan_tahanan'  => $request->hubungan_tahanan,
            'no_tahanan'        => $request->no_tahanan,
            'nama_tahanan'      => $request->nama_tahanan,
            'nama_bin'          => '-',
            'lokasi_tahanan'    => $request->lokasi_tahanan,
            'detail_kamar'      => '-',
            'kasus_tahanan'     => $request->kasus_tahanan,
            'tanggal_kunjungan' => $request->tanggal_kunjungan,
            'jam_kunjungan'     => $request->jam_kunjungan,
            'jumlah_pengikut'   => $request->jumlah_pengikut,
            'keperluan'         => $request->keperluan ?? 'Kunjungan Rutin',
            'catatan'           => $request->catatan,
            'foto_ktp'          => $path,
            'status'            => 'menunggu'
        ]);

        return redirect()->route('masyarakat.index')->with('success', 'Permohonan Berhasil Dikirim!');
    }

    // ====================================================
    // 6. EDIT & UPDATE DATA KUNJUNGAN
    // ====================================================
    public function edit($id)
    {
        $kunjungan = Kunjungan::where('user_id', Auth::id())->findOrFail($id);

        // Proteksi: Hanya bisa diedit jika belum disetujui
        if (!in_array(strtolower($kunjungan->status), ['menunggu', 'ditolak'])) {
            return redirect()->route('masyarakat.index')->with('error', 'Akses ditolak! Tiket ini sudah disetujui atau diproses.');
        }

        $tahanans = Tahanan::where('status', 'Aktif')
            ->orderBy('nama_tahanan', 'asc')
            ->get();

        return view('masyarakat.edit', compact('kunjungan', 'tahanans'));
    }

    public function update(Request $request, $id)
    {
        $kunjungan = Kunjungan::where('user_id', Auth::id())->findOrFail($id);

        if (!in_array(strtolower($kunjungan->status), ['menunggu', 'ditolak'])) {
            return redirect()->route('masyarakat.index')->with('error', 'Akses ditolak! Tiket ini tidak bisa diperbarui.');
        }

        $request->validate([
            'nama_pengunjung'   => 'required',
            'nik_pengunjung'    => 'required',
            'jenis_kelamin'     => 'required',
            'alamat_pengunjung' => 'required',
            'hubungan_tahanan'  => 'required',
            'no_tahanan'        => 'required',
            'nama_tahanan'      => 'required',
            'lokasi_tahanan'    => 'required',
            'kasus_tahanan'     => 'required',
            'tanggal_kunjungan' => 'required|date|after_or_equal:today',
            'jam_kunjungan'     => 'required',
            'jumlah_pengikut'   => 'required|integer|max:5',
            'foto_ktp'          => 'nullable|image|max:2048', // Boleh kosong jika tidak mau ganti KTP
        ]);

        $data_update = [
            'nama_pengunjung'   => $request->nama_pengunjung,
            'nik_pengunjung'    => $request->nik_pengunjung,
            'jenis_kelamin'     => $request->jenis_kelamin,
            'alamat_pengunjung' => $request->alamat_pengunjung,
            'hubungan_tahanan'  => $request->hubungan_tahanan,
            'no_tahanan'        => $request->no_tahanan,
            'nama_tahanan'      => $request->nama_tahanan,
            'lokasi_tahanan'    => $request->lokasi_tahanan,
            'kasus_tahanan'     => $request->kasus_tahanan,
            'tanggal_kunjungan' => $request->tanggal_kunjungan,
            'jam_kunjungan'     => $request->jam_kunjungan,
            'jumlah_pengikut'   => $request->jumlah_pengikut,
            'keperluan'         => $request->keperluan ?? 'Kunjungan Rutin',
            'catatan'           => $request->catatan,
            'status'            => 'menunggu' // Status dikembalikan jadi menunggu untuk verifikasi ulang
        ];

        // Jika user upload KTP baru
        if ($request->hasFile('foto_ktp')) {
            $path = $request->file('foto_ktp')->store('ktp_uploads', 'public');
            $data_update['foto_ktp'] = $path;
        }

        $kunjungan->update($data_update);

        return redirect()->route('masyarakat.index')->with('success', 'Permohonan Berhasil Diperbarui!');
    }

    // ====================================================
    // FITUR LAINNYA
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


    public function show($id)
    {
        $kunjungan = Kunjungan::where('user_id', Auth::id())->findOrFail($id);
        return view('masyarakat.show', compact('kunjungan'));
    }

    // ====================================================
    // ULASAN & SURVEI CSI
    // ====================================================

    public function ulasan()
    {
        $belumDinilai = Kunjungan::where('user_id', Auth::id())
            ->where('status', 'disetujui')
            ->doesntHave('survei')
            ->get();
        return view('masyarakat.ulasan', compact('belumDinilai'));
    }

    public function simpanSurvei(Request $request)
    {
        // 1. Validasi 6 Indikator CSI yang dikirim dari form
        $request->validate([
            'kunjungan_id'    => 'required|exists:kunjungans,id',
            'skor_sistem'     => 'required|integer|min:1|max:5',
            'skor_waktu'      => 'required|integer|min:1|max:5',
            'skor_petugas'    => 'required|integer|min:1|max:5',
            'skor_informasi'  => 'required|integer|min:1|max:5',
            'skor_fasilitas'  => 'required|integer|min:1|max:5',
            'skor_kebersihan' => 'required|integer|min:1|max:5',
            'komentar'        => 'nullable|string'
        ]);

        // 2. Hitung nilai rata-rata dari ke-6 aspek tersebut
        $rataRata = round((
            $request->skor_sistem +
            $request->skor_waktu +
            $request->skor_petugas +
            $request->skor_informasi +
            $request->skor_fasilitas +
            $request->skor_kebersihan
        ) / 6);

        // 3. Simpan hanya nilai rata-ratanya ke kolom 'bintang' 
        Survei::create([
            'user_id'         => Auth::id(),
            'kunjungan_id'    => $request->kunjungan_id,
            'bintang'         => $rataRata,
            'komentar'        => $request->komentar
        ]);

        // 4. Munculkan notifikasi sukses
        return redirect()->back()->with('success', 'Terima kasih! Penilaian Anda telah kami terima.');
    }
    
    // ====================================================
    // CETAK SURAT TITIPAN OLEH MASYARAKAT
    // ====================================================
    public function cetakTitipan($id)
    {
        $titipan = \App\Models\Titipan::with('user')
            ->where('id', $id)
            ->where('user_id', \Illuminate\Support\Facades\Auth::id())
            ->firstOrFail();

        return view('petugas.cetak_titipan', compact('titipan'));
    }

    public function laporan(\Illuminate\Http\Request $request)
    {
        $kategori = $request->input('kategori', 'kunjungan');

        $data_kunjungan = \App\Models\Kunjungan::where('user_id', \Illuminate\Support\Facades\Auth::id())
            ->whereIn('status', ['disetujui', 'selesai'])
            ->latest()
            ->get();

        $data_titipan = \App\Models\Titipan::where('user_id', \Illuminate\Support\Facades\Auth::id())
            ->whereIn('status', ['disetujui', 'selesai'])
            ->latest()
            ->get();

        return view('masyarakat.laporan', compact('data_kunjungan', 'data_titipan', 'kategori'));
    }
}