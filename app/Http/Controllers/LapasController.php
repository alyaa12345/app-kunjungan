<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Kunjungan;
use App\Models\Titipan;
use Carbon\Carbon;

class LapasController extends Controller
{
    // =====================================================================
    // 0. DASHBOARD LAPAS
    // =====================================================================
    public function index()
    {
        // Mengambil data antrean kunjungan (Status 'disetujui' yang belum check-in)
        // Diurutkan dari jadwal yang paling dekat atau terbaru
        $antrianKunjungan = Kunjungan::where('status', 'disetujui')
                                     ->orderBy('tanggal_kunjungan', 'desc')
                                     ->get();

        // Melempar data tersebut ke halaman dashboard
        return view('lapas.dashboard', compact('antrianKunjungan'));
    }

    // =====================================================================
    // 1. GATE CHECK (SCAN QR SURAT IZIN)
    // =====================================================================
    public function gateCheck(Request $request)
    {
        $tiket_id = $request->input('tiket_id');
        $visitor = null;
        $message = null;
        $tipe_tiket = null;

        if ($tiket_id) {
            $cleanId = preg_replace('/[^0-9]/', '', $tiket_id);
            
            if (!empty($cleanId)) {
                $kunjungan = Kunjungan::find($cleanId);
                $titipan = null;

                if (!$kunjungan) {
                    $titipan = Titipan::with('user')->find($cleanId);
                }

                // Logika Validasi Tiket Kunjungan
                if ($kunjungan) {
                    if ($kunjungan->status == 'disetujui') {
                        $visitor = $kunjungan;
                        $tipe_tiket = 'KUNJUNGAN';
                    } elseif ($kunjungan->status == 'selesai') {
                        $message = "Tiket Kunjungan ini sudah digunakan/selesai sebelumnya.";
                    } else {
                        $message = "Tiket Kunjungan belum disetujui (Status: " . strtoupper($kunjungan->status) . ")";
                    }
                } 
                // Logika Validasi Tiket Titipan
                elseif ($titipan) {
                    if (in_array(strtolower($titipan->status), ['disetujui', 'diterima'])) {
                        $visitor = $titipan;
                        $tipe_tiket = 'TITIPAN';
                    } elseif ($titipan->status == 'selesai') {
                        $message = "Barang titipan ini sudah diserahkan/selesai sebelumnya.";
                    } else {
                        $message = "Tiket Titipan belum disetujui (Status: " . strtoupper($titipan->status) . ")";
                    }
                } 
                // Jika ID tidak ditemukan di kedua tabel
                else {
                    $message = "Tiket dengan ID #{$cleanId} tidak ditemukan sama sekali.";
                }
            } else {
                $message = "Format ID Tiket tidak valid atau tidak mengandung angka.";
            }
        }

        return view('lapas.gate-check', compact('visitor', 'message', 'tipe_tiket'));
    }

    public function prosesGateCheck(Request $request)
    {
        $id = $request->id;
        $tipe = $request->tipe_tiket;

        if ($tipe == 'KUNJUNGAN') {
            $kunjungan = Kunjungan::findOrFail($id);
            $kunjungan->update(['status' => 'selesai']);
            
            return redirect()->route('lapas.gate-check')
                ->with('success', '✅ Pengunjung atas nama ' . $kunjungan->nama_pengunjung . ' BERHASIL CHECK-IN dan diizinkan masuk.');
        } 
        elseif ($tipe == 'TITIPAN') {
            $titipan = Titipan::findOrFail($id);
            $titipan->update(['status' => 'selesai']);
            
            return redirect()->route('lapas.gate-check')
                ->with('success', '✅ Titipan Barang berhasil di-Check In & Diterima Lapas!');
        }

        return redirect()->route('lapas.gate-check')
            ->with('error', '❌ Terjadi kesalahan sistem atau tipe tiket tidak valid.');
    }

    // =====================================================================
    // 2. SERAH TERIMA TITIPAN FISIK
    // =====================================================================
    public function titipan(Request $request)
    {
        // Aturan Dasar: Hanya menampilkan titipan yang di-ACC atau selesai
        $query = Titipan::with('user')->whereIn('status', ['disetujui', 'selesai']);

        // Filter Rentang Waktu
        if ($request->filled('filter')) {
            if ($request->filter == 'hari_ini') {
                $query->whereDate('created_at', Carbon::today());
            } elseif ($request->filter == 'minggu_ini') {
                $query->whereBetween('created_at', [
                    Carbon::now()->startOfWeek(), 
                    Carbon::now()->endOfWeek()
                ]);
            } elseif ($request->filter == 'bulan_ini') {
                $query->whereMonth('created_at', Carbon::now()->month)
                      ->whereYear('created_at', Carbon::now()->year);
            }
        }

        // Filter Pencarian Teks
        if ($request->filled('cari')) {
            $keyword = $request->cari;
            $query->where(function ($q) use ($keyword) {
                $q->where('nama_tahanan', 'like', '%' . $keyword . '%')
                  ->orWhereHas('user', function ($u) use ($keyword) {
                      $u->where('name', 'like', '%' . $keyword . '%');
                  });
            });
        }

        $titipans = $query->orderByRaw("FIELD(status, 'disetujui', 'selesai')")
                          ->orderBy('created_at', 'desc')
                          ->get();

        return view('lapas.titipan', compact('titipans'));
    }

    public function prosesTitipan(Request $request, $id)
    {
        $titipan = Titipan::findOrFail($id);
        $titipan->update(['status' => 'selesai']);
        
        return back()->with('success', 'Fisik Barang Titipan Berhasil Diserahkan ke Warga Binaan!');
    }
// =====================================================================
    // 3. DAFTAR KUNJUNGAN (LAPAS)
    // =====================================================================
    public function kunjungan(Request $request)
    {
        // Query dasar
        $query = Kunjungan::whereIn('status', ['disetujui', 'selesai']);

        // Filter Rentang Waktu
        if ($request->filled('filter')) {
            if ($request->filter == 'hari_ini') {
                $query->whereDate('tanggal_kunjungan', \Carbon\Carbon::today());
            } elseif ($request->filter == 'minggu_ini') {
                $query->whereBetween('tanggal_kunjungan', [
                    \Carbon\Carbon::now()->startOfWeek(), 
                    \Carbon\Carbon::now()->endOfWeek()
                ]);
            } elseif ($request->filter == 'bulan_ini') {
                $query->whereMonth('tanggal_kunjungan', \Carbon\Carbon::now()->month)
                      ->whereYear('tanggal_kunjungan', \Carbon\Carbon::now()->year);
            }
        }

        // Filter Pencarian Teks
        if ($request->filled('cari')) {
            $keyword = $request->cari;
            $query->where(function ($q) use ($keyword) {
                $q->where('nama_tahanan', 'like', '%' . $keyword . '%')
                  ->orWhere('nama_pengunjung', 'like', '%' . $keyword . '%');
            });
        }

        // Gunakan paginate() dipadukan dengan withQueryString() agar ringan dan filter tidak hilang
        $kunjungans = $query->orderByRaw("FIELD(status, 'disetujui', 'selesai')")
                            ->orderBy('tanggal_kunjungan', 'desc')
                            ->paginate(50)
                            ->withQueryString(); 

        return view('lapas.kunjungan', compact('kunjungans'));
    }
    
    // =====================================================================
    // 4. LAPORAN WEB (TAMPILAN DI LAYAR MONITOR)
    // =====================================================================
    public function laporan(Request $request)
    {
        $tanggal = $request->input('tanggal', Carbon::today()->format('Y-m-d'));

        // Rekap Kunjungan
        $dataKunjungan = Kunjungan::whereDate('tanggal_kunjungan', $tanggal)->get();
        $checkInBerhasil = $dataKunjungan->where('status', 'selesai')->count();
        $belumHadir = $dataKunjungan->where('status', 'disetujui')->count();

        // Rekap Titipan
        $dataTitipan = Titipan::whereDate('created_at', $tanggal)
            ->orWhereDate('updated_at', $tanggal)
            ->get();

        $titipanSelesai = $dataTitipan->where('status', 'selesai')->count();
        $titipanBelum = $dataTitipan->whereIn('status', ['disetujui', 'diterima'])->count();

        return view('lapas.laporan', compact(
            'tanggal', 'checkInBerhasil', 'belumHadir', 'titipanSelesai', 'titipanBelum', 'dataKunjungan', 'dataTitipan'
        ));
    }

    // =====================================================================
    // 5. CETAK LAPORAN LAPAS (HALAMAN TERPISAH)
    // =====================================================================
    public function cetakLaporan(Request $request)
    {
        $tanggal = $request->input('tanggal', Carbon::today()->format('Y-m-d'));

        // Rekap Kunjungan
        $dataKunjungan = Kunjungan::whereDate('tanggal_kunjungan', $tanggal)->get();
        $checkInBerhasil = $dataKunjungan->where('status', 'selesai')->count();
        $belumHadir = $dataKunjungan->where('status', 'disetujui')->count();

        // Rekap Titipan
        $dataTitipan = Titipan::whereDate('created_at', $tanggal)
            ->orWhereDate('updated_at', $tanggal)
            ->get();

        $titipanSelesai = $dataTitipan->where('status', 'selesai')->count();
        $titipanBelum = $dataTitipan->whereIn('status', ['disetujui', 'diterima'])->count();

        return view('lapas.cetak_laporan', compact(
            'tanggal', 'checkInBerhasil', 'belumHadir', 'titipanSelesai', 'titipanBelum', 'dataKunjungan', 'dataTitipan'
        ));
    }
}