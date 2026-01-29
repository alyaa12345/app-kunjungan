<x-app-layout>
    <div class="min-h-screen bg-slate-100 py-8 px-4 font-sans">

        <div class="max-w-4xl mx-auto text-center mb-8">
            <h1 class="text-3xl font-black text-slate-800 tracking-tight uppercase">Gate Check System</h1>
            <p class="text-slate-500">Sistem Verifikasi Masuk Pengunjung Rutan</p>
        </div>

        <div class="max-w-xl mx-auto mb-10">
            <div class="bg-white p-2 rounded-2xl shadow-lg border border-slate-200 flex items-center">
                <div class="pl-4 text-slate-400">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm12 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z"></path>
                    </svg>
                </div>
                <form action="{{ route('petugas.gate') }}" method="GET" class="w-full flex">
                    <input type="text" name="tiket_id" placeholder="Scan QR atau Ketik ID Tiket..." class="w-full border-none focus:ring-0 text-lg font-bold text-slate-800 placeholder-slate-400 h-12" autofocus autocomplete="off" value="{{ request('tiket_id') }}">
                    <button type="submit" class="bg-blue-900 hover:bg-blue-800 text-white px-6 rounded-xl font-bold transition-colors">
                        CEK
                    </button>
                </form>
            </div>
        </div>

        @if(request()->has('tiket_id'))
        <div class="max-w-4xl mx-auto">

            @if($visitor)
            <div class="bg-white rounded-3xl shadow-2xl overflow-hidden border border-slate-200 relative">

                <div class="bg-emerald-600 p-6 text-center text-white relative overflow-hidden">
                    <div class="relative z-10">
                        <div class="inline-flex items-center justify-center w-16 h-16 bg-white rounded-full text-emerald-600 mb-3 shadow-lg">
                            <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path>
                            </svg>
                        </div>
                        <h2 class="text-3xl font-black uppercase tracking-widest">AKSES DIIZINKAN</h2>
                        <p class="text-emerald-100 font-medium mt-1">Data Valid & Terverifikasi</p>
                    </div>
                    <div class="absolute inset-0 opacity-10 bg-[url('https://www.transparenttextures.com/patterns/cubes.png')]"></div>
                </div>

                <div class="p-8">
                    <div class="flex items-center justify-center gap-4 mb-8 border-b border-slate-100 pb-6">
                        <img src="{{ asset('assets/logo-kejari.png') }}" class="h-16 w-auto object-contain" alt="Logo">
                        <div class="text-left">
                            <h3 class="text-sm font-bold text-slate-500 uppercase tracking-wide">Kejaksaan Negeri</h3>
                            <h2 class="text-2xl font-black text-slate-800 uppercase leading-none">Banjarmasin</h2>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                        <div class="col-span-1">
                            <div class="bg-slate-50 p-4 rounded-xl border border-slate-200 text-center h-full">
                                <p class="text-xs font-bold text-slate-400 uppercase mb-3">Foto Identitas (KTP)</p>
                                @if($visitor->foto_ktp)
                                <div class="aspect-[16/10] bg-gray-200 rounded-lg overflow-hidden shadow-sm mb-2">
                                    <img src="{{ asset('storage/' . $visitor->foto_ktp) }}" class="w-full h-full object-cover" alt="KTP">
                                </div>
                                <p class="text-[10px] text-slate-400 italic">Cocokkan foto dengan wajah pengunjung</p>
                                @else
                                <div class="h-32 flex items-center justify-center text-slate-300">
                                    <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                    </svg>
                                </div>
                                <p class="text-xs text-red-500">Foto KTP Tidak Tersedia</p>
                                @endif
                            </div>
                        </div>

                        <div class="col-span-1 md:col-span-2 space-y-6">

                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-xs font-bold text-slate-400 uppercase mb-1">Nama Pengunjung</label>
                                    <div class="text-xl font-bold text-slate-800">{{ $visitor->user->name ?? $visitor->nama_pengunjung }}</div>
                                    <div class="text-sm text-slate-500 font-mono">{{ $visitor->nik_pengunjung }}</div>
                                </div>
                                <div>
                                    <label class="block text-xs font-bold text-slate-400 uppercase mb-1">Jumlah Rombongan</label>
                                    <div class="flex items-center gap-2">
                                        <span class="text-2xl font-black text-blue-600">{{ $visitor->jumlah_pengikut }}</span>
                                        <span class="text-sm font-bold text-slate-600">Orang</span>
                                    </div>
                                </div>
                            </div>

                            <div class="border-t border-slate-100 my-2"></div>

                            <div class="bg-blue-50 p-5 rounded-xl border border-blue-100">
                                <div class="grid grid-cols-2 gap-6">
                                    <div>
                                        <label class="block text-xs font-bold text-blue-400 uppercase mb-1">Mengunjungi Tahanan</label>
                                        <div class="text-lg font-bold text-blue-900 uppercase">{{ $visitor->nama_tahanan }}</div>
                                    </div>
                                    <div>
                                        <label class="block text-xs font-bold text-blue-400 uppercase mb-1">Lokasi Kamar</label>
                                        <div class="text-lg font-bold text-blue-900 uppercase bg-white inline-block px-3 py-1 rounded shadow-sm">
                                            {{ $visitor->nomor_kamar }}
                                        </div>
                                    </div>
                                </div>
                                <div class="mt-4">
                                    <label class="block text-xs font-bold text-blue-400 uppercase mb-1">Keperluan</label>
                                    <div class="text-sm font-medium text-blue-800">{{ $visitor->keperluan }}</div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>

                <div class="bg-slate-50 px-8 py-4 border-t border-slate-200 flex justify-between items-center">
                    <div class="text-xs text-slate-400">
                        <span class="block">Diverifikasi Oleh:</span>
                        <span class="font-bold text-slate-600 uppercase">{{ $visitor->petugas->name ?? 'Sistem' }}</span>
                    </div>
                    <div class="text-right">
                        <span class="block text-xs text-slate-400 uppercase">Waktu Check-in</span>
                        <span class="text-lg font-bold text-slate-800 font-mono">{{ now()->format('H:i') }} WIB</span>
                    </div>
                </div>
            </div>

            <div class="mt-6 text-center">
                <a href="{{ route('petugas.gate') }}" class="inline-flex items-center gap-2 text-slate-500 hover:text-slate-800 font-bold transition-colors">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                    </svg>
                    Scan Pengunjung Berikutnya
                </a>
            </div>

            @else
            <div class="bg-white rounded-3xl shadow-2xl overflow-hidden border border-red-200 text-center">
                <div class="bg-red-600 p-8 text-white">
                    <div class="inline-flex items-center justify-center w-20 h-20 bg-white rounded-full text-red-600 mb-4 shadow-lg animate-pulse">
                        <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </div>
                    <h2 class="text-3xl font-black uppercase tracking-widest">AKSES DITOLAK</h2>
                    <p class="text-red-100 font-medium mt-2 text-lg">{{ $message ?? 'Data Tiket Tidak Ditemukan' }}</p>
                </div>
                <div class="p-8">
                    <p class="text-slate-600 mb-6">Silakan arahkan pengunjung ke meja pelayanan untuk verifikasi ulang.</p>
                    <a href="{{ route('petugas.gate') }}" class="bg-slate-800 hover:bg-slate-900 text-white px-8 py-3 rounded-xl font-bold transition-colors">
                        Kembali ke Scanner
                    </a>
                </div>
            </div>
            @endif
        </div>
        @else
        <div class="text-center mt-20 opacity-50">
            <img src="{{ asset('assets/logo-kejari.png') }}" class="h-32 w-auto mx-auto grayscale mb-4 opacity-50">
            <p class="text-slate-400 font-bold">Menunggu Input Data...</p>
        </div>
        @endif

    </div>
</x-app-layout>