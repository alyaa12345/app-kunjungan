<x-app-layout>
    <x-slot name="style">
        <style>
            @media print {
                /* 1. Memaksa margin halaman menjadi 0 untuk mengusir header bawaan browser */
                @page { 
                    size: A4 portrait; 
                    margin: 0px !important; 
                }
                
                /* 2. Memaksa navigasi dan header bawaan x-app-layout Laravel untuk sembunyi */
                nav, header, footer, .min-h-screen > header, #navigation {
                    display: none !important;
                }

                /* 3. Memberikan jarak aman (padding) pada dokumen kita agar teks tidak terpotong di ujung kertas */
                body { 
                    padding: 1.5cm 2cm !important; 
                    margin: 0 !important;
                    -webkit-print-color-adjust: exact !important; 
                    print-color-adjust: exact !important; 
                    background-color: white !important;
                }
                
                /* 4. Menghilangkan sisa-sisa bayangan dan border container */
                .print-container {
                    border: none !important;
                    box-shadow: none !important;
                    border-radius: 0 !important;
                    margin: 0 !important;
                    padding: 0 !important;
                }
            }
        </style>
    </x-slot>

    <x-slot name="header">
        <div class="flex flex-col xl:flex-row justify-between items-start xl:items-center gap-5 bg-white pt-2 pb-4 print:hidden">
            <div class="relative">
                <div class="absolute -left-4 -top-4 w-12 h-12 bg-amber-50 rounded-full opacity-60 pointer-events-none"></div>
                <span class="relative bg-slate-900 text-white text-[10px] font-bold px-3 py-1.5 rounded-md tracking-widest uppercase shadow-sm">
                    Area Pos Penjagaan Lapas
                </span>
                <h2 class="relative font-black text-2xl text-slate-800 leading-tight mt-3">
                    Penerimaan Titipan Fisik
                </h2>
                <p class="relative text-sm text-slate-500 font-medium mt-1">
                    Cocokkan wujud fisik barang dengan data Kejaksaan sebelum diserahkan ke tahanan.
                </p>
            </div>

            <div class="w-full xl:w-auto flex flex-col sm:flex-row items-center gap-3">
                <form action="{{ route('lapas.titipan') }}" method="GET" class="w-full flex flex-col sm:flex-row gap-3">
                    <div class="relative">
                        <select name="filter" onchange="this.form.submit()" class="pl-4 pr-10 py-2.5 w-full sm:w-auto appearance-none border border-slate-200 rounded-xl focus:ring-2 focus:ring-amber-100 focus:border-amber-500 text-sm font-bold text-slate-700 bg-slate-50 hover:bg-slate-100 transition-colors shadow-sm outline-none cursor-pointer">
                            <option value="">Semua Waktu</option>
                            <option value="hari_ini" {{ request('filter') == 'hari_ini' ? 'selected' : '' }}>Harian (Hari Ini)</option>
                            <option value="minggu_ini" {{ request('filter') == 'minggu_ini' ? 'selected' : '' }}>Mingguan (Minggu Ini)</option>
                            <option value="bulan_ini" {{ request('filter') == 'bulan_ini' ? 'selected' : '' }}>Bulanan (Bulan Ini)</option>
                        </select>
                        <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none text-slate-400">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                        </div>
                    </div>

                    <div class="relative w-full sm:w-64 group">
                        <div class="absolute inset-y-0 left-0 flex items-center pl-4 pointer-events-none">
                            <svg class="w-4 h-4 text-slate-400 group-focus-within:text-amber-500 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                        </div>
                        <input type="text" name="cari" value="{{ request('cari') }}" class="pl-11 pr-4 py-2.5 w-full border border-slate-200 rounded-xl focus:ring-2 focus:ring-amber-100 focus:border-amber-500 text-sm bg-white transition-all shadow-sm outline-none" placeholder="Cari Nama Tahanan...">
                    </div>

                    @if(request('filter') || request('cari'))
                        <a href="{{ route('lapas.titipan') }}" class="px-4 py-2.5 bg-red-50 hover:bg-red-500 text-red-600 hover:text-white border border-red-100 hover:border-red-500 rounded-xl font-bold text-sm transition-all shadow-sm flex items-center justify-center whitespace-nowrap group">
                            <svg class="w-4 h-4 mr-1.5 group-hover:rotate-90 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                            Reset
                        </a>
                    @endif
                </form>

                <button onclick="window.print()" class="w-full sm:w-auto bg-slate-900 hover:bg-slate-800 hover:shadow-lg hover:-translate-y-0.5 text-white font-bold px-5 py-2.5 rounded-xl text-sm transition-all shadow-sm flex items-center justify-center gap-2 whitespace-nowrap">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-[#F5C542]" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z" />
                    </svg>
                    Cetak Laporan
                </button>
            </div>
        </div>
    </x-slot>

    <div class="py-8 bg-slate-50/50 min-h-screen print:bg-white print:py-0 print:min-h-0">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 print:max-w-full print:px-0">

            @if(session('success'))
            <div class="bg-emerald-50 border border-emerald-100 p-5 rounded-2xl shadow-sm mb-6 flex items-center gap-4 print:hidden">
                <div class="w-10 h-10 bg-emerald-500 rounded-full flex items-center justify-center text-white shrink-0 shadow-md">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"></path></svg>
                </div>
                <h3 class="font-black text-emerald-800 text-sm tracking-wide">{{ session('success') }}</h3>
            </div>
            @endif

            <div class="print-container bg-white rounded-2xl shadow-[0_2px_15px_-3px_rgba(0,0,0,0.07),0_10px_20px_-2px_rgba(0,0,0,0.04)] border border-slate-100 overflow-hidden">
                
                <div class="p-6 border-b border-slate-100 bg-white print:hidden flex items-center justify-between">
                    <div>
                        <h3 class="text-base font-extrabold text-slate-800 flex items-center gap-2">
                            <div class="w-2 h-5 bg-[#F5C542] rounded-full"></div>
                            Antrean Barang Masuk 
                            @if(request('filter') == 'hari_ini') <span class="text-amber-700 bg-amber-50 border border-amber-200/60 px-2 py-0.5 rounded-md text-xs ml-1">Hari Ini</span>
                            @elseif(request('filter') == 'minggu_ini') <span class="text-amber-700 bg-amber-50 border border-amber-200/60 px-2 py-0.5 rounded-md text-xs ml-1">Minggu Ini</span>
                            @elseif(request('filter') == 'bulan_ini') <span class="text-amber-700 bg-amber-50 border border-amber-200/60 px-2 py-0.5 rounded-md text-xs ml-1">Bulan Ini</span>
                            @endif
                        </h3>
                    </div>
                </div>

                <!-- KOP SURAT RESMI (HANYA PRINT) -->
                <div class="hidden print:block mb-8 relative">
                    <div class="flex items-center justify-between pb-3">
                        <div class="w-28 flex-shrink-0 flex justify-center">
                            <!-- PASTIKAN FILE GAMBAR LOGO ADA DI FOLDER -->
                            <img src="{{ asset('assets/logo-kejari.png') }}" class="w-20 object-contain print-watermark" alt="Logo">
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
                        <h4 class="text-base font-extrabold underline uppercase">LAPORAN PENERIMAAN TITIPAN BARANG FISIK</h4>
                        <p class="text-xs mt-1">Periode: 
                            <span class="font-bold">
                                @if(request('filter') == 'hari_ini') {{ \Carbon\Carbon::now()->translatedFormat('d F Y') }}
                                @elseif(request('filter') == 'minggu_ini') Minggu ke-{{ \Carbon\Carbon::now()->weekOfMonth }} (Bulan {{ \Carbon\Carbon::now()->translatedFormat('F Y') }})
                                @elseif(request('filter') == 'bulan_ini') Bulan {{ \Carbon\Carbon::now()->translatedFormat('F Y') }}
                                @else Keseluruhan Waktu
                                @endif
                            </span>
                        </p>
                    </div>
                </div>

                <!-- TAMPILAN DATA KOSONG -->
                @if($titipans->isEmpty())
                <div class="p-20 flex flex-col items-center justify-center text-center bg-slate-50/30 print:bg-white print:text-black print:p-10">
                    <div class="w-24 h-24 bg-white shadow-sm border border-slate-100 rounded-full flex items-center justify-center mb-6 text-slate-300 print:hidden">
                        <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path></svg>
                    </div>
                    <h4 class="font-bold text-slate-600 text-lg print:text-black">Nihil</h4>
                    <p class="text-sm text-slate-400 mt-1 print:text-black">Tidak ada data titipan fisik pada periode ini.</p>
                </div>
                
                <!-- TAMPILAN TABEL -->
                @else
                <div class="overflow-x-auto">
                    <table class="w-full text-left print:border-collapse print:border print:border-black print:mb-4">
                        <thead class="bg-slate-50/80 text-slate-500 text-[10px] uppercase tracking-widest font-bold print:bg-gray-100 print:text-black print:border-b-2 print:border-black print:text-xs">
                            <tr>
                                <th class="py-4 pl-6 pr-4 border-b border-slate-100 print:border-black print:border w-12 text-center hidden print:table-cell">No</th>
                                <th class="p-4 border-b border-slate-100 print:border-black print:border pl-6">Pengirim & Waktu</th>
                                <th class="p-4 border-b border-slate-100 print:border-black print:border">Tujuan (Warga Binaan)</th>
                                <th class="p-4 border-b border-slate-100 print:border-black print:border">Barang & Foto Fisik</th>
                                <th class="p-4 border-b border-slate-100 print:border-black print:border text-center w-32">Status</th>
                                <th class="p-4 text-center border-b border-slate-100 print:hidden w-44">Aksi Serah Terima</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-50 text-sm print:divide-black">
                            @foreach($titipans as $t)
                            <tr class="hover:bg-amber-50/30 transition-colors group {{ $t->status == 'selesai' ? 'opacity-50 bg-slate-50/50 print:opacity-100 print:bg-white' : '' }}">
                                <td class="py-4 pl-6 pr-4 border print:border-black text-center font-bold text-slate-400 print:text-black hidden print:table-cell align-top">{{ $loop->iteration }}</td>
                                
                                <td class="p-4 pl-6 border print:border-black print:py-3 align-top">
                                    <div class="text-[11px] font-black tracking-wider text-amber-500 mb-0.5 print:text-black">#TTP-{{ str_pad($t->id, 4, '0', STR_PAD_LEFT) }}</div>
                                    <div class="font-black text-slate-800 print:text-black">{{ strtoupper($t->user->name ?? 'ANONIM') }}</div>
                                    <div class="text-xs font-medium text-slate-400 print:text-black mt-0.5">{{ \Carbon\Carbon::parse($t->created_at)->format('d M Y • H:i') }}</div>
                                </td>

                                <td class="p-4 border print:border-black print:py-3 align-top">
                                    <div class="inline-flex items-center gap-2 py-1.5 px-3 rounded-lg bg-white border border-slate-200 shadow-sm print:border-none print:shadow-none print:bg-transparent print:p-0">
                                        <div class="w-1.5 h-1.5 rounded-full bg-[#F5C542] print:hidden"></div>
                                        <span class="font-bold text-xs text-slate-700 print:text-black">{{ strtoupper($t->nama_tahanan) }}</span>
                                    </div>
                                </td>

                                <td class="p-4 border print:border-black print:py-3 align-top">
                                    <div class="flex items-start gap-3 print:flex-col print:gap-2">
                                        @if(!empty($t->foto_barang))
                                        @php $safePath = str_replace('public/', '', $t->foto_barang); @endphp
                                        <!-- HAPUS print:hidden DI SINI. Tambahkan pointer-events-none saat diprint agar rapi -->
                                        <a href="{{ asset('storage/' . $safePath) }}" target="_blank" class="shrink-0 relative block group/img print:pointer-events-none">
                                            <img src="{{ asset('storage/' . $safePath) }}" 
                                                 alt="Foto" 
                                                 onerror="this.onerror=null; this.src='https://ui-avatars.com/api/?name=Img&color=7F9CF5&background=EBF4FF';"
                                                 class="w-12 h-12 object-cover rounded-xl border border-slate-200 shadow-sm group-hover/img:scale-105 transition-transform print:w-20 print:h-20 print:rounded-none print:border-slate-800 print:shadow-none">
                                        </a>
                                        @endif
                                        <div class="font-bold text-slate-700 text-xs print:text-black mt-1">{{ $t->barang_bawaan }}</div>
                                    </div>
                                </td>

                                <td class="p-4 border print:border-black text-center print:py-3 align-top">
                                    <div class="print:hidden flex justify-center">
                                        @if($t->status == 'disetujui') 
                                            <span class="bg-amber-100 text-amber-800 border border-amber-300 px-3 py-1 rounded-full text-[10px] font-black uppercase tracking-wider animate-pulse">Siap Diserahkan</span>
                                        @elseif($t->status == 'selesai') 
                                            <span class="bg-slate-100 text-slate-500 border border-slate-200 px-3 py-1 rounded-full text-[10px] font-black uppercase tracking-wider">Telah Diserahkan</span>
                                        @endif
                                    </div>
                                    <div class="hidden print:block font-bold text-[11px] tracking-wider mt-1">
                                        @if($t->status == 'disetujui') <span class="text-black uppercase">MENUNGGU</span>
                                        @elseif($t->status == 'selesai') <span class="text-black uppercase font-black">DISERAHKAN</span>
                                        @endif
                                    </div>
                                </td>

                                <td class="p-4 text-center print:hidden align-top">
                                    <div class="flex items-center justify-center">
                                        @if($t->status == 'disetujui')
                                        <form action="{{ route('lapas.titipan.proses', $t->id) }}" method="POST" onsubmit="return confirm('Pastikan fisik barang sesuai foto dan aman. Lanjutkan penyerahan ke tahanan?');">
                                            @csrf
                                            @method('PUT')
                                            <button type="submit" class="w-full bg-slate-900 hover:bg-blue-600 text-[#F5C542] hover:text-white font-bold py-2.5 px-4 rounded-xl transition-all shadow-sm hover:shadow-md text-xs flex items-center justify-center gap-1.5">
                                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"></path></svg>
                                                Serahkan
                                            </button>
                                        </form>
                                        @else
                                        <div class="inline-flex items-center justify-center gap-1 w-full bg-slate-50 text-slate-400 text-xs font-bold px-4 py-2 rounded-xl border border-slate-100">
                                            ✓ Tuntas
                                        </div>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                @endif

                <!-- TANDA TANGAN (HANYA PRINT) -->
                <div class="hidden print:block mt-12 mr-8 pb-8 page-break-inside-avoid">
                    <div class="flex justify-end">
                        <div class="text-center w-64">
                            <p class="text-xs">Banjarmasin, {{ \Carbon\Carbon::now()->translatedFormat('d F Y') }}</p>
                            <p class="text-xs font-bold mt-0.5">Petugas Penerima Barang / P2U,</p>
                            <div class="h-20"></div>
                            <p class="text-xs font-bold underline">( .................................................... )</p>
                            <p class="text-[11px] mt-0.5">NIP. </p>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</x-app-layout>