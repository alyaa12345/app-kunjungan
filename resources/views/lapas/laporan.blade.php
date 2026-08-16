<x-app-layout>
    <x-slot name="style">
        <style>
            @media print {
                /* 1. Atur ukuran kertas menjadi A4 Portrait dengan margin rapi */
                @page { 
                    size: A4 portrait; 
                    margin: 1.5cm; 
                }
                
                /* 2. Sembunyikan navigasi dan header bawaan layout Laravel */
                nav, header, footer, .min-h-screen > header, #navigation {
                    display: none !important;
                }

                /* 3. Paksa browser mencetak semua warna background dan styling persis seperti web */
                body { 
                    -webkit-print-color-adjust: exact !important; 
                    print-color-adjust: exact !important; 
                    background-color: #f8fafc !important; /* Warna bg-slate-50 */
                }
                
                /* 4. Mencegah baris tabel terpotong di tengah-tengah saat ganti halaman kertas */
                table { page-break-inside: auto; }
                tr { page-break-inside: avoid; page-break-after: auto; }
            }
        </style>
    </x-slot>

    <!-- Tambahan print:py-0 agar padding atas/bawah tidak memakan ruang di kertas -->
    <div class="py-8 bg-slate-50 min-h-screen print:py-0">
        <!-- Tambahan print:max-w-full dan print:px-0 agar layout penuh di kertas A4 -->
        <div class="max-w-6xl mx-auto px-4 print:max-w-full print:px-0">

            <!-- KOTAK FILTER & TOMBOL CETAK (DISEMBUNYIKAN SAAT PRINT) -->
            <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-200 mb-6 flex flex-wrap gap-4 items-end justify-between print:hidden">
                <form action="{{ url('lapas/laporan') }}" method="GET" class="flex gap-3 items-end">
                    <div>
                        <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-1">Pilih Tanggal Jadwal</label>
                        <input type="date" name="tanggal" value="{{ $tanggal }}" class="rounded-xl border-slate-300 text-sm focus:ring-[#F5C542]">
                    </div>
                    <button type="submit" class="bg-[#0f172a] hover:bg-slate-800 text-[#F5C542] px-5 py-2.5 rounded-xl text-sm font-bold shadow-md transition">Tampilkan Data</button>
                </form>

                <!-- Tombol ini langsung memicu pop-up print di browser -->
                <button onclick="window.print()" class="bg-[#F5C542] hover:bg-yellow-400 text-[#0f172a] px-6 py-2.5 rounded-xl text-sm font-bold shadow-md transition flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path>
                    </svg>
                    Cetak Laporan Resmi
                </button>
            </div>

            <!-- ========================================== -->
            <!-- KOP SURAT RESMI (HANYA TAMPIL SAAT PRINT) -->
            <!-- ========================================== -->
            <div class="hidden print:block mb-8 relative text-black">
                <div class="flex items-center justify-between pb-3">
                    <div class="w-28 flex-shrink-0 flex justify-center">
                        <!-- PASTIKAN FILE GAMBAR LOGO ADA DI FOLDER: public/assets/logo-kejari.png -->
                        <!-- Sesuaikan nama filenya jika berbeda -->
                        <img src="{{ asset('assets/logo-kejari.png') }}" class="w-20 object-contain" alt="Logo">
                    </div>
                    <div class="text-center flex-1 px-2">
                        <h3 class="text-[14px] font-bold tracking-tight uppercase">Kementerian Hukum dan Hak Asasi Manusia RI</h3>
                        <h2 class="text-[16px] font-extrabold tracking-wide uppercase mt-0.5">Kantor Wilayah Kalimantan Selatan</h2>
                        <h1 class="text-[18px] font-black tracking-wider uppercase mt-0.5">Lembaga Pemasyarakatan Kelas IIA Banjarmasin</h1>
                        <p class="text-[11px] mt-1.5 font-medium">Jl. Mayjen Sutoyo S No.336, Pelambuan, Kec. Banjarmasin Barat, Kota Banjarmasin, Kalsel 70118</p>
                    </div>
                    <div class="w-28 flex-shrink-0"></div> <!-- Spacer agar teks tetap di tengah -->
                </div>
                
                <!-- Garis Ganda Bawah Kop Surat -->
                <div class="w-full border-b-[3px] border-black mt-1"></div>
                <div class="w-full border-b border-black mt-[2px]"></div>

                <div class="text-center my-6">
                    <h4 class="text-base font-extrabold underline uppercase">LAPORAN REKAPITULASI KUNJUNGAN & TITIPAN</h4>
                    <p class="text-xs mt-1">Tanggal: <span class="font-bold">{{ \Carbon\Carbon::parse($tanggal)->translatedFormat('d F Y') }}</span></p>
                </div>
            </div>
            <!-- ========================================== -->

            <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-8">
                <div class="bg-white p-4 rounded-xl border border-blue-100 shadow-sm text-center">
                    <div class="text-[10px] font-bold text-slate-400 uppercase">Kunjungan Sukses</div>
                    <div class="text-3xl font-black text-blue-600">{{ $checkInBerhasil }}</div>
                </div>
                <div class="bg-white p-4 rounded-xl border border-amber-100 shadow-sm text-center">
                    <div class="text-[10px] font-bold text-slate-400 uppercase">Kunjungan Belum Hadir</div>
                    <div class="text-3xl font-black text-amber-500">{{ $belumHadir }}</div>
                </div>
                <div class="bg-white p-4 rounded-xl border border-emerald-100 shadow-sm text-center">
                    <div class="text-[10px] font-bold text-slate-400 uppercase">Titipan Selesai</div>
                    <div class="text-3xl font-black text-emerald-600">{{ $titipanSelesai }}</div>
                </div>
                <div class="bg-white p-4 rounded-xl border border-rose-100 shadow-sm text-center">
                    <div class="text-[10px] font-bold text-slate-400 uppercase">Titipan Menunggu</div>
                    <div class="text-3xl font-black text-rose-500">{{ $titipanBelum }}</div>
                </div>
            </div>

            <div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden p-6">
                <h4 class="font-bold text-sm text-slate-800 mb-3 uppercase tracking-wider">Daftar Rincian Pemohon:</h4>
                <div class="overflow-x-auto">
                    <table class="w-full text-sm text-left border-collapse">
                        <thead class="bg-slate-100 text-slate-600 uppercase text-[10px]">
                            <tr>
                                <th class="p-3 border border-slate-300 w-12 text-center">No</th>
                                <th class="p-3 border border-slate-300">Jenis Layanan</th>
                                <th class="p-3 border border-slate-300">Nama Pemohon</th>
                                <th class="p-3 border border-slate-300">Warga Binaan (Tujuan)</th>
                                <th class="p-3 border border-slate-300 text-center">Status Akhir</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-200">
                            @php $noWeb = 1; @endphp
                            @foreach($dataKunjungan as $k)
                            <tr>
                                <td class="p-3 border border-slate-300 text-center font-medium">{{ $noWeb++ }}</td>
                                <td class="p-3 border border-slate-300 font-bold text-blue-600">Kunjungan Fisik</td>
                                <td class="p-3 border border-slate-300">{{ $k->nama_pengunjung }}</td>
                                <td class="p-3 border border-slate-300">{{ $k->nama_tahanan }}</td>
                                <td class="p-3 border border-slate-300 text-center uppercase text-[10px] font-bold">{{ $k->status }}</td>
                            </tr>
                            @endforeach
                            
                            @foreach($dataTitipan as $t)
                            <tr>
                                <td class="p-3 border border-slate-300 text-center font-medium">{{ $noWeb++ }}</td>
                                <td class="p-3 border border-slate-300 font-bold text-emerald-600">Titipan Barang</td>
                                <td class="p-3 border border-slate-300">{{ $t->user->name ?? 'Anonim' }}</td>
                                <td class="p-3 border border-slate-300">{{ $t->nama_tahanan }}</td>
                                <td class="p-3 border border-slate-300 text-center uppercase text-[10px] font-bold">{{ $t->status }}</td>
                            </tr>
                            @endforeach
                            
                            @if($dataKunjungan->isEmpty() && $dataTitipan->isEmpty())
                            <tr>
                                <td colspan="5" class="p-8 text-center text-slate-400 italic border border-slate-300">Tidak ada rekam jejak operasional untuk tanggal yang dipilih.</td>
                            </tr>
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>
            
        </div>
    </div>
</x-app-layout>