<x-app-layout>
    <x-slot name="style">
        <style>
            @media print {
                /* 1. Usaha maksimal untuk membunuh header/footer browser dari kode */
                @page { 
                    size: A4 portrait; 
                    margin: 0 !important; 
                }
                
                body, html {
                    margin: 0 !important;
                    padding: 0 !important;
                    background-color: white !important;
                }

                /* 2. Sembunyikan PAKSA semua elemen layout bawaan Laravel/Breeze/Jetstream */
                nav, header, footer, aside, .min-h-screen > nav, header.bg-white, header.shadow { 
                    display: none !important; 
                }

                /* 3. Sembunyikan elemen dengan class print:hidden */
                .print\:hidden { 
                    display: none !important; 
                }

                /* 4. Format khusus area yang HANYA BOLEH DICETAK */
                #area-cetak {
                    display: block !important;
                    padding: 1.5cm 2cm !important; /* Jarak aman kertas */
                    width: 100%;
                    -webkit-print-color-adjust: exact; 
                    print-color-adjust: exact;
                }
                
                /* Mencegah tabel terpotong jelek */
                table { page-break-inside: auto; }
                tr { page-break-inside: avoid; page-break-after: auto; }
                .signature-area { page-break-inside: avoid; }
            }
        </style>
    </x-slot>

    <x-slot name="header">
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center bg-transparent pt-2 pb-4 print:hidden">
            <div>
                <span class="bg-green-800 text-yellow-400 text-xs font-extrabold px-4 py-1.5 rounded-full tracking-widest uppercase shadow-sm border border-green-700">
                    Kejaksaan Negeri Banjarmasin
                </span>
                <h2 class="font-extrabold text-3xl text-slate-900 tracking-tight leading-tight mt-4">
                    Master Data Tahanan
                </h2>
                <p class="text-sm text-slate-500 mt-1.5 font-medium">Kelola data warga binaan dan tahanan pada sistem intelijen terpadu.</p>
            </div>
        </div>
    </x-slot>

    <div class="py-6 bg-slate-50 min-h-screen print:bg-white print:py-0 print:min-h-0">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6 print:space-y-0 print:max-w-full print:px-0">

            @if(session('success'))
            <div class="bg-green-50 border-l-4 border-green-600 p-4 rounded-r-xl shadow-sm flex items-center print:hidden transition-all duration-300">
                <svg class="w-5 h-5 text-green-600 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                <p class="text-sm font-bold text-green-800">{{ session('success') }}</p>
            </div>
            @endif

            <div class="grid grid-cols-1 xl:grid-cols-3 gap-6 items-start print:block">
                
                <div class="bg-white p-7 rounded-2xl shadow-sm border border-slate-200 print:hidden sticky top-6">
                    <div class="flex items-center gap-3 mb-6 pb-4 border-b border-slate-100">
                        <div class="w-10 h-10 rounded-xl bg-green-50 flex items-center justify-center text-green-700">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"></path></svg>
                        </div>
                        <h3 class="text-lg font-bold text-slate-800">Registrasi Tahanan</h3>
                    </div>

                    <form action="{{ route('petugas.tahanan.store') }}" method="POST" class="space-y-5">
                        @csrf
                        <div>
                            <label class="block text-xs font-bold text-slate-600 uppercase tracking-wider mb-1.5">Nama Lengkap</label>
                            <input type="text" name="nama_tahanan" required class="w-full text-sm border-slate-300 rounded-lg bg-slate-50 focus:bg-white focus:ring-2 focus:ring-green-600 focus:border-green-600 transition-all duration-200" placeholder="Masukkan nama tahanan">
                        </div>
                        
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="block text-xs font-bold text-slate-600 uppercase tracking-wider mb-1.5">No Tahanan</label>
                                <input type="text" name="no_tahanan" required class="w-full text-sm border-slate-300 rounded-lg bg-slate-50 focus:bg-white focus:ring-2 focus:ring-green-600 focus:border-green-600 transition-all duration-200">
                            </div>
                            <div>
                                <label class="block text-xs font-bold text-slate-600 uppercase tracking-wider mb-1.5">No Register</label>
                                <input type="text" name="no_register" required class="w-full text-sm border-slate-300 rounded-lg bg-slate-50 focus:bg-white focus:ring-2 focus:ring-green-600 focus:border-green-600 transition-all duration-200">
                            </div>
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-slate-600 uppercase tracking-wider mb-1.5">Jenis Kelamin</label>
                            <select name="jenis_kelamin" required class="w-full text-sm border-slate-300 rounded-lg bg-slate-50 focus:bg-white focus:ring-2 focus:ring-green-600 focus:border-green-600 transition-all duration-200">
                                <option value="Laki-laki">Laki-laki</option>
                                <option value="Perempuan">Perempuan</option>
                            </select>
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-slate-600 uppercase tracking-wider mb-1.5">Pasal / Perkara</label>
                            <input type="text" name="pasal" required class="w-full text-sm border-slate-300 rounded-lg bg-slate-50 focus:bg-white focus:ring-2 focus:ring-green-600 focus:border-green-600 transition-all duration-200" placeholder="Contoh: Pasal 363 KUHP">
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-slate-600 uppercase tracking-wider mb-1.5">Lokasi Penahanan</label>
                            <input type="text" name="lokasi_tahanan" required class="w-full text-sm border-slate-300 rounded-lg bg-slate-50 focus:bg-white focus:ring-2 focus:ring-green-600 focus:border-green-600 transition-all duration-200" placeholder="Contoh: Lapas Teluk Dalam">
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-slate-600 uppercase tracking-wider mb-1.5">Status</label>
                            <select name="status" required class="w-full text-sm border-slate-300 rounded-lg bg-slate-50 focus:bg-white focus:ring-2 focus:ring-green-600 focus:border-green-600 transition-all duration-200">
                                <option value="Aktif">Aktif</option>
                                <option value="Bebas">Bebas</option>
                                <option value="Non-Aktif">Non-Aktif</option>
                            </select>
                        </div>

                        <div class="pt-3">
                            <button type="submit" class="w-full bg-green-800 hover:bg-green-900 text-yellow-400 font-bold py-3 rounded-lg shadow-md hover:shadow-lg transition-all duration-200 text-sm flex justify-center items-center gap-2">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4"></path></svg>
                                Simpan Data Tahanan
                            </button>
                        </div>
                    </form>
                </div>

                <div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden xl:col-span-2 print:border-none print:shadow-none print:rounded-none print:col-span-1 print:bg-transparent">
                    
                    <div class="p-6 border-b border-slate-100 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 print:hidden bg-white">
                        <h3 class="text-lg font-bold text-slate-800 flex items-center gap-2">
                            <svg class="w-5 h-5 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                            Daftar Warga Binaan
                        </h3>
                        <button onclick="window.print()" class="bg-slate-800 hover:bg-slate-900 text-white px-5 py-2.5 rounded-lg text-sm font-bold shadow-sm transition-all duration-200 inline-flex items-center gap-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path></svg>
                            Cetak Laporan
                        </button>
                    </div>

                    <div class="p-4 bg-slate-50 border-b border-slate-200 flex flex-col md:flex-row gap-3 print:hidden">
                        <div class="flex-1 relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                            </div>
                            <input type="text" id="searchInput" onkeyup="filterTable()" class="block w-full pl-10 pr-3 py-2 border border-slate-300 rounded-lg text-sm placeholder-slate-400 focus:outline-none focus:ring-1 focus:ring-green-600 focus:border-green-600" placeholder="Cari nama, no tahanan, register, atau perkara...">
                        </div>
                        <div class="w-full md:w-48">
                            <select id="statusFilter" onchange="filterTable()" class="block w-full py-2 px-3 border border-slate-300 bg-white rounded-lg text-sm focus:outline-none focus:ring-1 focus:ring-green-600 focus:border-green-600">
                                <option value="all">Semua Status</option>
                                <option value="aktif">Aktif</option>
                                <option value="bebas">Bebas</option>
                                <option value="non-aktif">Non-Aktif</option>
                            </select>
                        </div>
                    </div>

                    <div id="area-cetak">
                        <div class="hidden print:block mb-6 w-full">
                            <div class="flex items-center justify-between">
                                <div class="w-24 flex-shrink-0 text-center">
                                    <img src="{{ asset('assets/logo-kejari.png') }}" class="w-20 h-auto mx-auto object-contain" alt="Logo Kejaksaan">
                                </div>
                                <div class="text-center flex-1 px-4">
                                    <h3 class="text-sm font-bold tracking-tight text-black">KEJAKSAAN REPUBLIK INDONESIA</h3>
                                    <h2 class="text-base font-extrabold tracking-wide text-black mt-0.5">KEJAKSAAN TINGGI KALIMANTAN SELATAN</h2>
                                    <h1 class="text-lg font-black tracking-wider text-black mt-0.5">KEJAKSAAN NEGERI BANJARMASIN</h1>
                                    <p class="text-[11px] mt-1 text-black">Jl. Brigjen H. Hasan Basri No.3, Banjarmasin Utara, Kota Banjarmasin, Kalimantan Selatan 70124</p>
                                </div>
                                <div class="w-24 flex-shrink-0"></div> 
                            </div>
                            <hr class="border-black border-[1.5px] mt-3 mb-[2px]">
                            <hr class="border-black border-[0.5px] mb-5">
                            <div class="text-center my-6">
                                <h4 class="text-base font-extrabold underline uppercase text-black">REGISTER WARGA BINAAN / TAHANAN</h4>
                                <p class="text-xs mt-1 text-black">Keadaan per Tanggal: {{ \Carbon\Carbon::now()->translatedFormat('d F Y') }}</p>
                            </div>
                        </div>

                        <div class="overflow-x-auto print:overflow-visible">
                            <table class="w-full text-sm text-left text-slate-600 print:text-black print:border-collapse print:border print:border-black">
                                <thead class="bg-slate-100 text-slate-600 text-xs uppercase font-bold tracking-wider print:bg-transparent print:text-black print:border-b-2 print:border-black">
                                    <tr>
                                        <th class="px-5 py-4 print:px-3 print:py-2 border-b print:border-black w-10 text-center">No</th>
                                        <th class="px-6 py-4 print:px-3 print:py-2 border-b print:border-black">Identitas Tahanan</th>
                                        <th class="px-6 py-4 print:px-3 print:py-2 border-b print:border-black">Perkara & Lokasi</th>
                                        <th class="px-4 py-4 print:px-3 print:py-2 border-b print:border-black text-center">L/P</th>
                                        <th class="px-6 py-4 print:px-3 print:py-2 border-b print:border-black text-center">Status</th>
                                        <th class="px-4 py-4 border-b print:hidden text-center w-20">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody id="tabelDataTahanan" class="divide-y divide-slate-100 print:divide-black">
                                    @forelse($tahanans as $index => $t)
                                    <tr class="hover:bg-slate-50 transition-colors duration-200 print:hover:bg-transparent item-tahanan" 
                                        data-status="{{ strtolower(trim($t->status)) }}"
                                        data-search="{{ strtolower($t->nama_tahanan . ' ' . $t->no_register . ' ' . $t->no_tahanan . ' ' . $t->pasal) }}">
                                        
                                        <td class="px-5 py-4 print:px-3 print:py-2 print:border print:border-black text-center font-medium text-slate-500 print:text-black">
                                            {{ $index + 1 }}
                                        </td>
                                        
                                        <td class="px-6 py-4 print:px-3 print:py-2 print:border print:border-black">
                                            <div class="font-bold text-slate-900 print:text-black">{{ strtoupper($t->nama_tahanan) }}</div>
                                            <div class="flex items-center gap-2 mt-1.5">
                                                <span class="inline-flex items-center px-2 py-0.5 rounded text-[10px] font-medium bg-slate-100 text-slate-600 border border-slate-200 print:border-none print:p-0 print:bg-transparent print:text-black">
                                                    Reg: {{ $t->no_register }}
                                                </span>
                                                <span class="inline-flex items-center px-2 py-0.5 rounded text-[10px] font-medium bg-slate-100 text-slate-600 border border-slate-200 print:border-none print:p-0 print:bg-transparent print:text-black">
                                                    No: {{ $t->no_tahanan }}
                                                </span>
                                            </div>
                                        </td>
                                        
                                        <td class="px-6 py-4 print:px-3 print:py-2 print:border print:border-black">
                                            <div class="font-bold text-slate-700 print:text-black">{{ $t->pasal }}</div>
                                            <div class="text-xs text-slate-500 mt-1 print:text-black">
                                                <span class="font-semibold">Lokasi:</span> {{ $t->lokasi_tahanan }}
                                            </div>
                                        </td>
                                        
                                        <td class="px-4 py-4 print:px-3 print:py-2 print:border print:border-black text-center font-bold text-slate-700 print:text-black">
                                            {{ strtoupper(substr(trim($t->jenis_kelamin), 0, 1)) }}
                                        </td>
                                        
                                        <td class="px-6 py-4 print:px-3 print:py-2 print:border print:border-black text-center">
                                            <span class="print:hidden px-3 py-1 text-xs font-bold rounded-full tracking-wide
                                                @if(strtolower(trim($t->status)) == 'aktif') bg-emerald-100 text-emerald-700 border border-emerald-200 
                                                @elseif(strtolower(trim($t->status)) == 'bebas') bg-red-100 text-red-700 border border-red-200 
                                                @else bg-slate-100 text-slate-700 border border-slate-200 @endif">
                                                {{ $t->status }}
                                            </span>
                                            <span class="hidden print:inline font-bold text-black uppercase text-xs">
                                                {{ $t->status }}
                                            </span>
                                        </td>
                                        
                                        <td class="px-4 py-4 print:hidden text-center">
                                            <a href="{{ route('petugas.tahanan.edit', $t->id) }}" class="inline-flex items-center justify-center w-8 h-8 rounded-md bg-white border border-slate-300 text-slate-600 hover:bg-slate-50 hover:text-green-700 hover:border-green-600 transition-all shadow-sm" title="Edit Data">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path></svg>
                                            </a>
                                        </td>
                                    </tr>
                                    @empty
                                    <tr id="emptyState">
                                        <td colspan="6" class="px-6 py-12 text-center print:border print:border-black">
                                            <div class="print:hidden flex flex-col items-center justify-center text-slate-400">
                                                <svg class="w-12 h-12 mb-3 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"></path></svg>
                                                <span class="text-sm font-medium text-slate-500">Belum ada data tahanan</span>
                                            </div>
                                            <span class="hidden print:block text-black">Tidak ada data.</span>
                                        </td>
                                    </tr>
                                    @endforelse
                                    
                                    <tr id="noResultRow" class="hidden print:hidden">
                                        <td colspan="6" class="px-6 py-8 text-center text-slate-500 text-sm font-medium">
                                            Data tidak ditemukan berdasarkan filter/pencarian Anda.
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>

                        <div class="hidden print:block mt-12 pb-10 signature-area">
                            <div class="flex justify-end pr-10">
                                <div class="text-center w-64">
                                    <p class="text-sm text-black">Banjarmasin, {{ \Carbon\Carbon::now()->translatedFormat('d F Y') }}</p>
                                    <p class="text-sm font-bold mt-1 text-black">Mengetahui,</p>
                                    <p class="text-sm font-bold text-black">Kepala Seksi Intelijen</p>
                                    
                                    <div class="h-20"></div>

                                    <p class="text-sm font-bold underline text-black">( .................................................... )</p>
                                    <p class="text-xs mt-1 text-black text-left pl-6">NIP. </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        function filterTable() {
            const searchInput = document.getElementById('searchInput').value.toLowerCase().trim();
            const statusFilter = document.getElementById('statusFilter').value.toLowerCase();
            const rows = document.querySelectorAll('.item-tahanan');
            let hasVisibleRow = false;

            rows.forEach(row => {
                const searchData = row.getAttribute('data-search') || '';
                const statusData = row.getAttribute('data-status') || '';

                const matchesSearch = searchData.includes(searchInput);
                const matchesStatus = (statusFilter === 'all') || (statusData.includes(statusFilter));

                if (matchesSearch && matchesStatus) {
                    row.style.display = '';
                    hasVisibleRow = true;
                } else {
                    row.style.display = 'none';
                }
            });

            // Tampilkan baris "Data tidak ditemukan" jika tabel kosong dari hasil filter
            const noResultRow = document.getElementById('noResultRow');
            const emptyState = document.getElementById('emptyState');
            
            if (!hasVisibleRow && !emptyState) {
                if (noResultRow) noResultRow.classList.remove('hidden');
            } else {
                if (noResultRow) noResultRow.classList.add('hidden');
            }
        }
    </script>
</x-app-layout>