<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Kunjungan;
use Illuminate\Support\Facades\Auth;

class PetugasController extends Controller
{
    // 1. Dashboard (Tabel Verifikasi)
    public function index()
    {
        // Menampilkan data yang statusnya 'menunggu' untuk diverifikasi admin
        $kunjungans = Kunjungan::where('status', 'menunggu')
            ->orderBy('created_at', 'asc')
            ->get();

        return view('petugas.index', compact('kunjungans'));
    }

    // 2. Halaman Gate (Scanner Satpam) - BARU
    public function gate()
    {
        return view('petugas.gate');
    }

    // 3. Cek QR (API untuk Scanner)
    public function checkQr(Request $request)
    {
        $code = $request->code;
        $id = preg_replace('/[^0-9]/', '', $code); // Ambil angka saja

        $data = Kunjungan::find($id);

        if (!$data) {
            return response()->json(['status' => 'not_found']);
        }

        return response()->json([
            'status' => 'found',
            'data' => [
                'nama_pengunjung' => $data->nama_pengunjung,
                'jumlah_pengikut' => $data->jumlah_pengikut,
                'nama_tahanan' => $data->nama_tahanan,
                'kamar' => $data->nomor_kamar,
                'tanggal' => \Carbon\Carbon::parse($data->tanggal_kunjungan)->translatedFormat('d F Y'),
                'jam' => $data->jam_kunjungan,
                'status_kunjungan' => $data->status,
                'foto' => $data->foto_ktp ? asset('storage/' . $data->foto_ktp) : null
            ]
        ]);
    }

    // 4. Update Status (Tombol Terima/Tolak)
    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:disetujui,ditolak',
            'keterangan_petugas' => 'nullable|string'
        ]);

        $kunjungan = Kunjungan::findOrFail($id);
        $kunjungan->status = $request->status;

        if ($request->has('keterangan_petugas')) {
            $kunjungan->keterangan_petugas = $request->keterangan_petugas;
        }

        $kunjungan->save();

        return back()->with('success', 'Status kunjungan berhasil diperbarui!');
    }

    // 5. Arsip Riwayat
    public function riwayat()
    {
        $kunjungans = Kunjungan::whereIn('status', ['disetujui', 'ditolak'])
            ->orderBy('updated_at', 'desc')
            ->get();
        return view('petugas.riwayat', compact('kunjungans'));
    }

    // 6. Laporan
    public function laporan()
    {
        $totalTotal = Kunjungan::count();
        $totalDisetujui = Kunjungan::where('status', 'disetujui')->count();
        $totalDitolak = Kunjungan::where('status', 'ditolak')->count();

        $harian = Kunjungan::selectRaw('DATE(tanggal_kunjungan) as tanggal, count(*) as total')
            ->groupBy('tanggal')->orderBy('tanggal', 'desc')->limit(7)->get();

        $bulanan = Kunjungan::selectRaw('MONTH(tanggal_kunjungan) as bulan, count(*) as total')
            ->whereYear('tanggal_kunjungan', date('Y'))->groupBy('bulan')->orderBy('bulan', 'asc')->get();

        $tahunan = Kunjungan::selectRaw('YEAR(tanggal_kunjungan) as tahun, count(*) as total')
            ->groupBy('tahun')->orderBy('tahun', 'desc')->get();

        return view('petugas.laporan', compact('totalTotal', 'totalDisetujui', 'totalDitolak', 'harian', 'bulanan', 'tahunan'));
    }
}
