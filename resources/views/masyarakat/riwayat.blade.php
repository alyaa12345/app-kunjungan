<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-xl text-slate-800 leading-tight">
            {{ __('Riwayat Permohonan') }}
        </h2>
    </x-slot>

    <div class="py-12 bg-[#F8FAFC] min-h-screen font-sans">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <div class="flex flex-col md:flex-row justify-between items-end mb-8 gap-4">
                <div>
                    <h3 class="text-3xl font-bold text-[#0f172a] tracking-tight">Arsip Data Saya</h3>
                    <p class="text-slate-500 mt-1">Pantau status dan riwayat pengajuan Anda secara realtime.</p>
                </div>

                <div class="bg-white p-1.5 rounded-xl shadow-sm border border-slate-200 flex gap-1 w-full md:w-auto">
                    <a href="{{ route('masyarakat.riwayat', ['kategori' => 'kunjungan']) }}"
                        class="flex-1 md:flex-none px-6 py-2.5 rounded-lg text-sm font-bold text-center transition-all duration-300 flex items-center justify-center gap-2 {{ $kategori == 'kunjungan' ? 'bg-[#0f172a] text-white shadow-md transform scale-105' : 'text-slate-500 hover:bg-slate-50 hover:text-[#0f172a]' }}">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 5v2m0 4v2m0 4v2M5 5a2 2 0 00-2 2v3a2 2 0 110 4v3a2 2 0 002 2h14a2 2 0 002-2v-3a2 2 0 110-4V7a2 2 0 00-2-2H5z"></path>
                        </svg>
                        Kunjungan
                    </a>
                    <a href="{{ route('masyarakat.riwayat', ['kategori' => 'titipan']) }}"
                        class="flex-1 md:flex-none px-6 py-2.5 rounded-lg text-sm font-bold text-center transition-all duration-300 flex items-center justify-center gap-2 {{ $kategori == 'titipan' ? 'bg-[#0f172a] text-white shadow-md transform scale-105' : 'text-slate-500 hover:bg-slate-50 hover:text-[#0f172a]' }}">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                        </svg>
                        Titipan Barang
                    </a>
                </div>
            </div>

            @if($kategori == 'kunjungan')
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-2xl border border-slate-200">
                <div class="px-6 py-5 border-b border-slate-100 bg-white flex items-center justify-between">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-full bg-blue-50 flex items-center justify-center text-blue-600">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                            </svg>
                        </div>
                        <div>
                            <h4 class="font-bold text-slate-800 text-lg">Kunjungan Tatap Muka</h4>
                            <p class="text-xs text-slate-500">Daftar permohonan yang pernah Anda ajukan</p>
                        </div>
                    </div>
                    <span class="bg-slate-100 text-slate-600 text-xs font-bold px-3 py-1.5 rounded-lg border border-slate-200">{{ $kunjungans->count() }} Data</span>
                </div>

                @if($kunjungans->isEmpty())
                <div class="p-16 text-center flex flex-col items-center justify-center">
                    <div class="w-20 h-20 bg-slate-50 rounded-full flex items-center justify-center mb-4 text-slate-300">
                        <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                    </div>
                    <h5 class="text-slate-800 font-bold text-lg">Belum Ada Riwayat</h5>
                    <p class="text-slate-500 text-sm mb-6 max-w-sm">Anda belum pernah mengajukan jadwal kunjungan. Silakan buat permohonan baru.</p>
                    <a href="{{ route('masyarakat.create') }}" class="px-6 py-2.5 bg-[#F5C542] hover:bg-yellow-400 text-[#0f172a] font-bold rounded-xl shadow-lg transition transform hover:-translate-y-0.5">
                        + Buat Kunjungan Baru
                    </a>
                </div>
                @else
                <div class="overflow-x-auto">
                    <table class="w-full text-sm text-left text-slate-600">
                        <thead class="text-xs text-white uppercase bg-[#0f172a]">
                            <tr>
                                <th class="px-6 py-4 rounded-tl-lg">Tanggal</th>
                                <th class="px-6 py-4">Nama Tahanan</th>
                                <th class="px-6 py-4">Sesi</th>
                                <th class="px-6 py-4">Pengikut</th>
                                <th class="px-6 py-4">Status</th>
                                <th class="px-6 py-4 text-center rounded-tr-lg">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100">
                            @foreach($kunjungans as $item)
                            <tr class="hover:bg-blue-50/50 transition duration-200">
                                <td class="px-6 py-4 font-bold text-slate-800">
                                    <div class="flex flex-col">
                                        <span>{{ \Carbon\Carbon::parse($item->tanggal_kunjungan)->translatedFormat('d F Y') }}</span>
                                        <span class="text-[10px] text-slate-400 font-normal">#REQ-{{ $item->id }}</span>
                                    </div>
                                </td>
                                <td class="px-6 py-4 font-medium">{{ $item->nama_tahanan }}</td>
                                <td class="px-6 py-4">
                                    <span class="bg-slate-100 text-slate-600 px-2.5 py-1 rounded-md text-xs font-bold border border-slate-200">
                                        {{ strtoupper($item->jam_kunjungan) }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-slate-500">{{ $item->jumlah_pengikut }} Orang</td>
                                <td class="px-6 py-4">
                                    @if($item->status == 'menunggu')
                                    <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-bold bg-yellow-100 text-yellow-800 border border-yellow-200 shadow-sm">
                                        <span class="w-2 h-2 rounded-full bg-yellow-500 animate-pulse"></span> PROSES
                                    </span>
                                    @elseif($item->status == 'disetujui')
                                    <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-bold bg-emerald-100 text-emerald-800 border border-emerald-200 shadow-sm">
                                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path>
                                        </svg>
                                        DISETUJUI
                                    </span>
                                    @else
                                    <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-bold bg-red-100 text-red-800 border border-red-200 shadow-sm">
                                        DITOLAK
                                    </span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 text-center">
                                    <a href="{{ route('masyarakat.show', $item->id) }}" class="text-[#0f172a] hover:text-blue-600 hover:bg-blue-100 p-2 rounded-lg transition inline-block" title="Lihat Detail">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                        </svg>
                                    </a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                @endif
            </div>

            @elseif($kategori == 'titipan')
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-2xl border border-slate-200">
                <div class="px-6 py-5 border-b border-slate-100 bg-white flex items-center justify-between">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-full bg-pink-50 flex items-center justify-center text-pink-600">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                            </svg>
                        </div>
                        <div>
                            <h4 class="font-bold text-slate-800 text-lg">Titipan Barang</h4>
                            <p class="text-xs text-slate-500">Log pengiriman barang ke tahanan</p>
                        </div>
                    </div>
                    <span class="bg-slate-100 text-slate-600 text-xs font-bold px-3 py-1.5 rounded-lg border border-slate-200">{{ $titipans->count() }} Data</span>
                </div>

                @if($titipans->isEmpty())
                <div class="p-16 text-center flex flex-col items-center justify-center">
                    <div class="w-20 h-20 bg-slate-50 rounded-full flex items-center justify-center mb-4 text-slate-300">
                        <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                        </svg>
                    </div>
                    <h5 class="text-slate-800 font-bold text-lg">Belum Ada Titipan</h5>
                    <p class="text-slate-500 text-sm mb-6 max-w-sm">Ingin menitipkan makanan atau pakaian? Ajukan formulir titipan sekarang.</p>
                    <a href="{{ route('masyarakat.index') }}" class="px-6 py-2.5 bg-[#F5C542] hover:bg-yellow-400 text-[#0f172a] font-bold rounded-xl shadow-lg transition transform hover:-translate-y-0.5">
                        + Buat Titipan Baru
                    </a>
                </div>
                @else
                <div class="overflow-x-auto">
                    <table class="w-full text-sm text-left text-slate-600">
                        <thead class="text-xs text-white uppercase bg-[#0f172a]">
                            <tr>
                                <th class="px-6 py-4 rounded-tl-lg">Tanggal Input</th>
                                <th class="px-6 py-4">Penerima (Tahanan)</th>
                                <th class="px-6 py-4">Rincian Barang</th>
                                <th class="px-6 py-4">Foto</th>
                                <th class="px-6 py-4 rounded-tr-lg">Status</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100">
                            @foreach($titipans as $item)
                            <tr class="hover:bg-pink-50/30 transition duration-200">
                                <td class="px-6 py-4 font-bold text-slate-800">
                                    {{ $item->created_at->format('d M Y') }}
                                    <div class="text-[10px] text-slate-400 font-normal">{{ $item->created_at->format('H:i') }} WITA</div>
                                </td>
                                <td class="px-6 py-4 font-medium">{{ $item->nama_tahanan }}</td>
                                <td class="px-6 py-4">
                                    <div class="font-bold text-slate-800 mb-1 flex items-center gap-2">
                                        <span class="w-2 h-2 rounded-full bg-slate-400"></span> {{ $item->jenis_titipan }}
                                    </div>
                                    <div class="text-xs text-slate-500 italic max-w-[250px] leading-relaxed">"{{ Str::limit($item->deskripsi_barang, 50) }}"</div>
                                </td>
                                <td class="px-6 py-4">
                                    <a href="{{ asset('storage/'.$item->foto_barang) }}" target="_blank" class="relative group block w-12 h-12 rounded-lg overflow-hidden border border-slate-200 shadow-sm">
                                        <img src="{{ asset('storage/'.$item->foto_barang) }}" class="w-full h-full object-cover transition transform group-hover:scale-110">
                                        <div class="absolute inset-0 bg-black/20 group-hover:bg-transparent transition"></div>
                                    </a>
                                </td>
                                <td class="px-6 py-4">
                                    @if($item->status == 'diajukan')
                                    <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-bold bg-yellow-100 text-yellow-800 border border-yellow-200 shadow-sm">
                                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                        </svg>
                                        MENUNGGU
                                    </span>
                                    @elseif($item->status == 'diterima')
                                    <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-bold bg-emerald-100 text-emerald-800 border border-emerald-200 shadow-sm">
                                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path>
                                        </svg>
                                        DITERIMA PETUGAS
                                    </span>
                                    @else
                                    <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-bold bg-red-100 text-red-800 border border-red-200 shadow-sm">
                                        DITOLAK
                                    </span>
                                    @endif
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                @endif
            </div>
            @endif

        </div>
    </div>
</x-app-layout>