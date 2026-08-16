<x-app-layout>
    <x-slot name="header">
        <div class="relative bg-white pt-4 pb-6 overflow-hidden">
            <div class="absolute top-0 right-0 -mr-8 -mt-8 w-32 h-32 rounded-full bg-emerald-50 opacity-50 blur-2xl"></div>
            <div class="absolute bottom-0 left-0 -ml-8 -mb-8 w-24 h-24 rounded-full bg-amber-50 opacity-50 blur-xl"></div>
            
            <div class="relative flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
                <div>
                    <div class="flex items-center gap-2 mb-2">
                        <span class="bg-slate-900 text-white text-[10px] font-extrabold px-2.5 py-1 rounded-md tracking-widest uppercase shadow-sm">
                            Statistik Publik
                        </span>
                    </div>
                    <h2 class="font-black text-3xl text-slate-800 tracking-tight leading-tight">
                        Customer Satisfaction Index (CSI)
                    </h2>
                    <p class="text-sm text-slate-500 font-medium mt-1">
                        Hasil survei evaluasi kepuasan masyarakat terhadap sistem pelayanan.
                    </p>
                </div>

                <!-- Tambahan Tombol Cetak Laporan -->
                <div class="shrink-0 mt-4 md:mt-0">
                 <a href="{{ route('petugas.laporan.cetak') }}" target="_blank" class="group inline-flex ...
                        <svg class="w-5 h-5 transition-transform group-hover:scale-110" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path>
                        </svg>
                        Cetak Laporan Resmi
                    </a>
                </div>
                <!-- Akhir Tambahan Tombol -->

            </div>
        </div>
    </x-slot>

    <div class="py-8 bg-slate-50/50 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-8">

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="bg-white rounded-3xl p-6 shadow-[0_2px_20px_-4px_rgba(0,0,0,0.05)] border border-slate-100 relative overflow-hidden group hover:shadow-lg transition-all duration-300">
                    <div class="absolute -right-6 -top-6 w-24 h-24 bg-amber-50 rounded-full group-hover:scale-150 transition-transform duration-500 ease-out"></div>
                    <div class="relative flex items-center justify-between">
                        <div>
                            <h4 class="text-xs font-bold text-slate-400 uppercase tracking-widest mb-1">Rata-Rata Indeks Kepuasan</h4>
                            <div class="flex items-end gap-2">
                                <span class="text-5xl font-black text-slate-800 tracking-tighter">{{ number_format($rataRataBintang, 1) }}</span>
                                <span class="text-base font-bold text-slate-400 mb-1">/ 5.0</span>
                            </div>
                            <div class="flex items-center gap-1 mt-2 text-[#F5C542]">
                                @for($i = 1; $i <= 5; $i++)
                                    <svg class="w-4 h-4 {{ $i <= round($rataRataBintang) ? 'fill-current' : 'text-slate-200' }}" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path></svg>
                                @endfor
                            </div>
                        </div>
                        <div class="w-16 h-16 bg-gradient-to-br from-amber-400 to-orange-500 text-white rounded-2xl flex items-center justify-center shadow-lg shadow-amber-200/50 transform group-hover:rotate-12 transition-transform duration-300">
                            <svg class="w-8 h-8" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path></svg>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-3xl p-6 shadow-[0_2px_20px_-4px_rgba(0,0,0,0.05)] border border-slate-100 relative overflow-hidden group hover:shadow-lg transition-all duration-300">
                    <div class="absolute -right-6 -top-6 w-24 h-24 bg-blue-50 rounded-full group-hover:scale-150 transition-transform duration-500 ease-out"></div>
                    <div class="relative flex items-center justify-between">
                        <div>
                            <h4 class="text-xs font-bold text-slate-400 uppercase tracking-widest mb-1">Total Partisipasi Responden</h4>
                            <div class="flex items-end gap-2">
                                <span class="text-5xl font-black text-slate-800 tracking-tighter">{{ $totalResponden }}</span>
                                <span class="text-base font-bold text-slate-400 mb-1">Orang</span>
                            </div>
                            <div class="mt-2 text-sm font-medium text-slate-500">
                                Berhasil memberikan ulasan
                            </div>
                        </div>
                        <div class="w-16 h-16 bg-gradient-to-br from-blue-500 to-indigo-600 text-white rounded-2xl flex items-center justify-center shadow-lg shadow-blue-200/50 transform group-hover:-translate-y-1 transition-transform duration-300">
                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                        </div>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-3xl shadow-[0_2px_20px_-4px_rgba(0,0,0,0.05)] border border-slate-100 overflow-hidden">
                <div class="p-6 border-b border-slate-100 flex items-center justify-between">
                    <div class="flex items-center gap-3">
                        <div class="w-2 h-6 bg-[#F5C542] rounded-full"></div>
                        <h3 class="text-lg font-extrabold text-slate-800">Catatan Kritik & Saran</h3>
                    </div>
                    <span class="bg-slate-100 text-slate-500 text-xs font-bold px-3 py-1 rounded-lg">Terbaru</span>
                </div>
                
                <div class="divide-y divide-slate-50">
                    @forelse($semuaUlasan as $u)
                    @php
                        // Logika pembuat Inisial Avatar
                        $namaLengkap = $u->user->name ?? 'Masyarakat Umum';
                        $inisial = strtoupper(substr($namaLengkap, 0, 1));
                    @endphp
                    <div class="p-6 hover:bg-slate-50/50 transition-colors flex gap-4 sm:gap-5 group">
                        
                        <div class="hidden sm:flex shrink-0 w-12 h-12 rounded-full bg-gradient-to-br from-slate-100 to-slate-200 border border-slate-200 items-center justify-center font-black text-slate-500 text-lg group-hover:from-blue-100 group-hover:to-blue-50 group-hover:text-blue-600 transition-colors">
                            {{ $inisial }}
                        </div>

                        <div class="flex-1 min-w-0">
                            <div class="flex flex-col sm:flex-row sm:justify-between sm:items-start gap-1 sm:gap-4 mb-2">
                                <div>
                                    <h5 class="font-bold text-slate-800 text-base truncate">{{ $namaLengkap }}</h5>
                                    
                                    <div class="flex items-center gap-1 mt-1 text-[#F5C542]">
                                        @for($i = 1; $i <= 5; $i++)
                                            <svg class="w-4 h-4 {{ $i <= $u->bintang ? 'fill-current' : 'text-slate-200' }}" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path></svg>
                                        @endfor
                                    </div>
                                </div>
                                <span class="text-xs font-semibold text-slate-400 bg-slate-100 px-2.5 py-1 rounded-md shrink-0">
                                    {{ $u->created_at->diffForHumans() }}
                                </span>
                            </div>
                            
                            <div class="relative mt-3">
                                <div class="absolute -top-2 left-4 sm:-left-2 sm:top-2 w-4 h-4 bg-slate-100 rotate-45 hidden sm:block"></div>
                                
                                <p class="relative text-sm text-slate-600 font-medium bg-slate-100 p-4 rounded-2xl rounded-tl-none sm:rounded-tl-2xl sm:rounded-bl-none leading-relaxed">
                                    "{{ $u->ulasan ?? $u->komentar }}"
                                </p>
                            </div>
                        </div>

                    </div>
                    @empty
                    <div class="p-16 text-center flex flex-col items-center justify-center bg-slate-50/30">
                        <div class="w-20 h-20 bg-white shadow-sm border border-slate-100 rounded-full flex items-center justify-center mb-4 text-slate-300">
                            <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path></svg>
                        </div>
                        <h5 class="text-slate-800 font-bold text-lg">Belum Ada Ulasan</h5>
                        <p class="text-slate-500 text-sm max-w-sm mt-1">Saat ini belum ada data survei atau ulasan masyarakat yang masuk ke dalam sistem.</p>
                    </div>
                    @endforelse
                </div>
            </div>

        </div>
    </div>
</x-app-layout>