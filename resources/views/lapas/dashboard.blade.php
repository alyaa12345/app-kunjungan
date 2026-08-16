<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4 bg-white pt-2 pb-4">
            <div>
                <span class="bg-slate-900 text-white text-[10px] font-bold px-2.5 py-1 rounded-md tracking-widest uppercase">
                    Mode Lapas
                </span>
                <h2 class="font-bold text-2xl text-slate-900 leading-tight mt-2">
                    Pos Penjagaan Utama
                </h2>
                <p class="text-sm text-slate-500 font-medium mt-1">
                    Validasi pengunjung dan kontrol barang titipan yang masuk ke area lapas.
                </p>
            </div>

            <div class="w-full md:w-auto relative">
                <div class="absolute inset-y-0 left-0 flex items-center pl-4 pointer-events-none">
                    <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                    </svg>
                </div>
                <input type="text" class="pl-11 pr-4 py-2.5 w-full md:w-72 border border-slate-200 rounded-xl focus:ring-1 focus:ring-slate-300 focus:border-slate-300 text-sm bg-white transition-all shadow-sm" placeholder="Cari Kode Booking / Nama...">
            </div>
        </div>
    </x-slot>

    <div class="py-8 bg-slate-50 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                <a href="{{ url('/lapas/gate-check') }}" class="block bg-white rounded-2xl shadow-sm border border-slate-200 p-6 flex items-center justify-between group hover:border-blue-400 hover:shadow-md transition-all cursor-pointer">
                    <div class="flex items-center gap-5">
                        <div class="w-14 h-14 bg-blue-50 text-blue-600 rounded-full flex items-center justify-center group-hover:bg-blue-600 group-hover:text-white transition-colors">
                            <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm12 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z"></path>
                            </svg>
                        </div>
                        <div>
                            <h3 class="font-bold text-slate-800 text-lg">Gate Check (Scan QR)</h3>
                            <p class="text-sm text-slate-500 mt-0.5">Scan surat izin pengunjung dari Kejaksaan.</p>
                        </div>
                    </div>
                    <div class="text-slate-300 group-hover:text-blue-500 transition-colors">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                        </svg>
                    </div>
                </a>

                <a href="{{ url('/lapas/titipan') }}" class="block bg-white rounded-2xl shadow-sm border border-slate-200 p-6 flex items-center justify-between group hover:border-emerald-400 hover:shadow-md transition-all cursor-pointer">
                    <div class="flex items-center gap-5">
                        <div class="w-14 h-14 bg-emerald-50 text-emerald-600 rounded-full flex items-center justify-center group-hover:bg-emerald-500 group-hover:text-white transition-colors">
                            <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                            </svg>
                        </div>
                        <div>
                            <h3 class="font-bold text-slate-800 text-lg">Serah Terima Titipan</h3>
                            <p class="text-sm text-slate-500 mt-0.5">Update status barang titipan ke tahanan.</p>
                        </div>
                    </div>
                    <div class="text-slate-300 group-hover:text-emerald-500 transition-colors">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                        </svg>
                    </div>
                </a>

            </div>

            <div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden mt-8">
                <div class="p-6 border-b border-slate-100 flex justify-between items-center bg-white">
                    <h3 class="text-[15px] font-bold text-slate-800">Antrian Menunggu Check-In</h3>
                    <!-- ANGKA TOTAL SEKARANG DINAMIS -->
                    <span class="bg-slate-900 text-white text-[11px] font-bold px-3 py-1.5 rounded-full tracking-wide">Total: {{ isset($antrianKunjungan) ? $antrianKunjungan->count() : 0 }}</span>
                </div>

                @if(isset($antrianKunjungan) && $antrianKunjungan->isEmpty())
                <!-- TAMPILAN KOSONG -->
                <div class="p-20 flex flex-col items-center justify-center text-center">
                    <div class="w-16 h-16 bg-slate-50 rounded-full flex items-center justify-center mb-4">
                        <svg class="w-8 h-8 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path>
                        </svg>
                    </div>
                    <h4 class="font-bold text-slate-800 text-lg">Semua Bersih!</h4>
                    <p class="text-sm text-slate-500 mt-1">Tidak ada pengunjung yang perlu diverifikasi di gerbang saat ini.</p>
                </div>
                @else
                <!-- TABEL DATA ANTRIAN DINAMIS -->
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead class="bg-slate-50 text-slate-500 text-[11px] uppercase tracking-wider">
                            <tr>
                                <th class="p-4 font-bold">Kode Booking</th>
                                <th class="p-4 font-bold">Pemohon / Jadwal</th>
                                <th class="p-4 font-bold">Warga Binaan</th>
                                <th class="p-4 font-bold text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100">
                            @foreach($antrianKunjungan as $item)
                            <tr class="hover:bg-slate-50/50 transition">
                                <td class="p-4">
                                    <span class="font-mono text-sm font-bold text-slate-700 bg-slate-100 px-2 py-1 rounded">#REQ-{{ $item->id }}</span>
                                </td>
                                <td class="p-4">
                                    <div class="font-bold text-slate-800">{{ $item->nama_pengunjung }}</div>
                                    <div class="text-xs text-slate-500 mt-1 flex items-center gap-1">
                                        <svg class="w-3 h-3 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                        </svg>
                                        {{ \Carbon\Carbon::parse($item->tanggal_kunjungan)->format('d M Y') }}
                                        <span class="font-bold ml-1 text-emerald-600 bg-emerald-50 px-1.5 py-0.5 rounded uppercase">Sesi {{ $item->jam_kunjungan }}</span>
                                    </div>
                                </td>
                                <td class="p-4">
                                    <div class="font-bold text-slate-800">{{ $item->nama_tahanan }}</div>
                                    <div class="text-xs text-slate-500 mt-1">{{ $item->lokasi_tahanan }}</div>
                                </td>
                                <td class="p-4 text-center">
                                    <!-- Tombol Panggil langsung mengarah ke scanner dengan ID terisi -->
                                    <a href="{{ url('/lapas/gate-check') }}?tiket_id={{ $item->id }}" class="bg-[#0f172a] hover:bg-slate-800 text-[#F5C542] text-xs font-bold px-4 py-2 rounded-lg transition shadow-sm inline-flex items-center gap-1.5">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm12 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z"></path>
                                        </svg>
                                        Proses Check-In
                                    </a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                @endif
            </div>

        </div>
    </div>
</x-app-layout>