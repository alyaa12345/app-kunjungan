<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-xl text-gray-800 leading-tight flex items-center gap-2">
            <svg class="w-6 h-6 text-[#F5C542]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
            </svg>
            {{ __('Beri Penilaian Layanan') }}
        </h2>
    </x-slot>

    <div class="py-12 max-w-6xl mx-auto sm:px-6 lg:px-8">

        @if(session('success'))
        <div class="mb-8 rounded-xl bg-emerald-50 border-l-4 border-emerald-500 p-5 text-emerald-800 shadow-sm flex justify-between items-start animate-fade-in-down">
            <div class="flex items-start gap-4">
                <div class="bg-emerald-100 p-2 rounded-full mt-1">
                    <svg class="w-6 h-6 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 10h4.764a2 2 0 011.789 2.894l-3.5 7A2 2 0 0115.263 21h-4.017c-.163 0-.326-.02-.485-.06L7 20m7-10V5a2 2 0 00-2-2h-.095c-.5 0-.905.405-.905.905 0 .714-.211 1.412-.608 2.006L7 11v9m7-10h-2M7 20H5a2 2 0 01-2-2v-6a2 2 0 012-2h2.5"></path>
                    </svg>
                </div>
                <div>
                    <h3 class="font-bold text-lg mb-1 text-emerald-900">Terima Kasih Banyak!</h3>
                    <p class="text-sm text-emerald-700">{{ session('success') }}</p>
                </div>
            </div>
            <button onclick="this.parentElement.remove()" class="text-emerald-500 hover:text-emerald-800 transition">&times;</button>
        </div>
        @endif

        <div class="bg-white overflow-hidden shadow-xl sm:rounded-2xl border border-slate-100">

            <div class="bg-gradient-to-r from-[#0f172a] to-slate-800 p-8 text-white relative overflow-hidden">
                <div class="relative z-10">
                    <h3 class="font-black text-2xl tracking-tight mb-2">Formulir Indeks Kepuasan Masyarakat (IKM)</h3>
                    <p class="text-slate-300 text-sm max-w-3xl">Penilaian Anda sangat berarti untuk membantu kami meningkatkan kualitas pelayanan di lingkungan Kejaksaan Negeri Banjarmasin. Silakan berikan penilaian secara objektif pada kunjungan Anda di bawah ini.</p>
                </div>
                <div class="absolute right-0 top-0 text-[10rem] opacity-5 -translate-y-10 translate-x-10 pointer-events-none">⭐</div>
            </div>

            <div class="p-6 md:p-8 bg-slate-50">
                <div class="flex items-center gap-3 mb-6">
                    <span class="bg-[#F5C542] text-[#0f172a] text-xs font-black px-3 py-1 rounded-full tracking-widest uppercase shadow-sm">Tugas Anda</span>
                    <h4 class="font-bold text-slate-700 text-lg">Daftar Kunjungan Belum Dinilai</h4>
                </div>

                @forelse($belumDinilai as $item)
                <div class="bg-white border border-slate-200 rounded-2xl p-6 md:p-8 mb-8 shadow-sm hover:shadow-md transition-shadow relative overflow-hidden group">

                    <div class="absolute top-0 left-0 w-1.5 h-full bg-blue-500 group-hover:bg-[#F5C542] transition-colors"></div>

                    <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4 mb-8 pb-6 border-b border-slate-100">
                        <div class="flex items-center gap-4">
                            <div class="bg-blue-50 p-3 rounded-xl border border-blue-100 text-blue-600">
                                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                </svg>
                            </div>
                            <div>
                                <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-1">Tanggal Kunjungan Selesai</p>
                                <p class="font-black text-xl text-slate-800">{{ \Carbon\Carbon::parse($item->tanggal_kunjungan)->format('d F Y') }}</p>
                            </div>
                        </div>

                        <div class="bg-slate-50 px-4 py-3 rounded-lg border border-slate-200 text-right min-w-[200px]">
                            <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-1">Tahanan Yang Dikunjungi</p>
                            <p class="font-black text-lg text-slate-800 uppercase">{{ $item->nama_tahanan }}</p>
                        </div>
                    </div>

                    <form action="{{ route('masyarakat.survei.simpan') }}" method="POST">
                        @csrf
                        <input type="hidden" name="kunjungan_id" value="{{ $item->id }}">

                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-8">

                            <div class="bg-slate-50 p-5 rounded-xl border border-slate-200 hover:border-indigo-300 transition group/item">
                                <div class="flex flex-col items-center text-center mb-5">
                                    <div class="w-12 h-12 bg-white rounded-full flex items-center justify-center shadow-sm text-2xl mb-3 border border-slate-100 group-hover/item:scale-110 transition-transform">📱</div>
                                    <label class="block font-black text-slate-700">Kemudahan Aplikasi</label>
                                    <p class="text-[11px] text-slate-500 mt-1 uppercase font-bold tracking-wider">Akses & Penggunaan Sistem</p>
                                </div>
                                <div class="flex justify-between gap-1 bg-white p-2 rounded-lg border border-slate-100 shadow-inner">
                                    @for($i=1; $i<=5; $i++)
                                        <label class="cursor-pointer flex-1">
                                        <input type="radio" name="skor_sistem" value="{{ $i }}" class="peer sr-only" required>
                                        <div class="py-2 flex flex-col items-center justify-center rounded-md border-2 border-transparent peer-checked:bg-indigo-500 peer-checked:text-white peer-checked:shadow-md text-slate-400 hover:bg-indigo-50 transition">
                                            <span class="text-sm font-black">{{ $i }}</span>
                                        </div>
                                        </label>
                                        @endfor
                                </div>
                                <div class="flex justify-between text-[9px] font-bold text-slate-400 uppercase mt-2 px-1"><span>Sangat Sulit</span><span>Sangat Mudah</span></div>
                            </div>

                            <div class="bg-slate-50 p-5 rounded-xl border border-slate-200 hover:border-yellow-400 transition group/item">
                                <div class="flex flex-col items-center text-center mb-5">
                                    <div class="w-12 h-12 bg-white rounded-full flex items-center justify-center shadow-sm text-2xl mb-3 border border-slate-100 group-hover/item:scale-110 transition-transform">⚡</div>
                                    <label class="block font-black text-slate-700">Kecepatan Pelayanan</label>
                                    <p class="text-[11px] text-slate-500 mt-1 uppercase font-bold tracking-wider">Waktu Tunggu & Proses</p>
                                </div>
                                <div class="flex justify-between gap-1 bg-white p-2 rounded-lg border border-slate-100 shadow-inner">
                                    @for($i=1; $i<=5; $i++)
                                        <label class="cursor-pointer flex-1">
                                        <input type="radio" name="skor_waktu" value="{{ $i }}" class="peer sr-only" required>
                                        <div class="py-2 flex flex-col items-center justify-center rounded-md border-2 border-transparent peer-checked:bg-yellow-500 peer-checked:text-white peer-checked:shadow-md text-slate-400 hover:bg-yellow-50 transition">
                                            <span class="text-sm font-black">{{ $i }}</span>
                                        </div>
                                        </label>
                                        @endfor
                                </div>
                                <div class="flex justify-between text-[9px] font-bold text-slate-400 uppercase mt-2 px-1"><span>Sangat Lambat</span><span>Sangat Cepat</span></div>
                            </div>

                            <div class="bg-slate-50 p-5 rounded-xl border border-slate-200 hover:border-blue-400 transition group/item">
                                <div class="flex flex-col items-center text-center mb-5">
                                    <div class="w-12 h-12 bg-white rounded-full flex items-center justify-center shadow-sm text-2xl mb-3 border border-slate-100 group-hover/item:scale-110 transition-transform">👮</div>
                                    <label class="block font-black text-slate-700">Sikap Petugas</label>
                                    <p class="text-[11px] text-slate-500 mt-1 uppercase font-bold tracking-wider">Kesopanan & Keramahan</p>
                                </div>
                                <div class="flex justify-between gap-1 bg-white p-2 rounded-lg border border-slate-100 shadow-inner">
                                    @for($i=1; $i<=5; $i++)
                                        <label class="cursor-pointer flex-1">
                                        <input type="radio" name="skor_petugas" value="{{ $i }}" class="peer sr-only" required>
                                        <div class="py-2 flex flex-col items-center justify-center rounded-md border-2 border-transparent peer-checked:bg-blue-500 peer-checked:text-white peer-checked:shadow-md text-slate-400 hover:bg-blue-50 transition">
                                            <span class="text-sm font-black">{{ $i }}</span>
                                        </div>
                                        </label>
                                        @endfor
                                </div>
                                <div class="flex justify-between text-[9px] font-bold text-slate-400 uppercase mt-2 px-1"><span>Sangat Buruk</span><span>Sangat Baik</span></div>
                            </div>

                            <div class="bg-slate-50 p-5 rounded-xl border border-slate-200 hover:border-cyan-400 transition group/item">
                                <div class="flex flex-col items-center text-center mb-5">
                                    <div class="w-12 h-12 bg-white rounded-full flex items-center justify-center shadow-sm text-2xl mb-3 border border-slate-100 group-hover/item:scale-110 transition-transform">📢</div>
                                    <label class="block font-black text-slate-700">Kejelasan Informasi</label>
                                    <p class="text-[11px] text-slate-500 mt-1 uppercase font-bold tracking-wider">Prosedur & Syarat Kunjungan</p>
                                </div>
                                <div class="flex justify-between gap-1 bg-white p-2 rounded-lg border border-slate-100 shadow-inner">
                                    @for($i=1; $i<=5; $i++)
                                        <label class="cursor-pointer flex-1">
                                        <input type="radio" name="skor_informasi" value="{{ $i }}" class="peer sr-only" required>
                                        <div class="py-2 flex flex-col items-center justify-center rounded-md border-2 border-transparent peer-checked:bg-cyan-500 peer-checked:text-white peer-checked:shadow-md text-slate-400 hover:bg-cyan-50 transition">
                                            <span class="text-sm font-black">{{ $i }}</span>
                                        </div>
                                        </label>
                                        @endfor
                                </div>
                                <div class="flex justify-between text-[9px] font-bold text-slate-400 uppercase mt-2 px-1"><span>Tidak Jelas</span><span>Sangat Jelas</span></div>
                            </div>

                            <div class="bg-slate-50 p-5 rounded-xl border border-slate-200 hover:border-orange-400 transition group/item">
                                <div class="flex flex-col items-center text-center mb-5">
                                    <div class="w-12 h-12 bg-white rounded-full flex items-center justify-center shadow-sm text-2xl mb-3 border border-slate-100 group-hover/item:scale-110 transition-transform">🏢</div>
                                    <label class="block font-black text-slate-700">Fasilitas Layanan</label>
                                    <p class="text-[11px] text-slate-500 mt-1 uppercase font-bold tracking-wider">Ruang Tunggu & Toilet</p>
                                </div>
                                <div class="flex justify-between gap-1 bg-white p-2 rounded-lg border border-slate-100 shadow-inner">
                                    @for($i=1; $i<=5; $i++)
                                        <label class="cursor-pointer flex-1">
                                        <input type="radio" name="skor_fasilitas" value="{{ $i }}" class="peer sr-only" required>
                                        <div class="py-2 flex flex-col items-center justify-center rounded-md border-2 border-transparent peer-checked:bg-orange-500 peer-checked:text-white peer-checked:shadow-md text-slate-400 hover:bg-orange-50 transition">
                                            <span class="text-sm font-black">{{ $i }}</span>
                                        </div>
                                        </label>
                                        @endfor
                                </div>
                                <div class="flex justify-between text-[9px] font-bold text-slate-400 uppercase mt-2 px-1"><span>Buruk</span><span>Sangat Baik</span></div>
                            </div>

                            <div class="bg-slate-50 p-5 rounded-xl border border-slate-200 hover:border-emerald-400 transition group/item">
                                <div class="flex flex-col items-center text-center mb-5">
                                    <div class="w-12 h-12 bg-white rounded-full flex items-center justify-center shadow-sm text-2xl mb-3 border border-slate-100 group-hover/item:scale-110 transition-transform">🧹</div>
                                    <label class="block font-black text-slate-700">Kebersihan Lingkungan</label>
                                    <p class="text-[11px] text-slate-500 mt-1 uppercase font-bold tracking-wider">Area Rutan & Kejaksaan</p>
                                </div>
                                <div class="flex justify-between gap-1 bg-white p-2 rounded-lg border border-slate-100 shadow-inner">
                                    @for($i=1; $i<=5; $i++)
                                        <label class="cursor-pointer flex-1">
                                        <input type="radio" name="skor_kebersihan" value="{{ $i }}" class="peer sr-only" required>
                                        <div class="py-2 flex flex-col items-center justify-center rounded-md border-2 border-transparent peer-checked:bg-emerald-500 peer-checked:text-white peer-checked:shadow-md text-slate-400 hover:bg-emerald-50 transition">
                                            <span class="text-sm font-black">{{ $i }}</span>
                                        </div>
                                        </label>
                                        @endfor
                                </div>
                                <div class="flex justify-between text-[9px] font-bold text-slate-400 uppercase mt-2 px-1"><span>Kotor</span><span>Sangat Bersih</span></div>
                            </div>

                        </div>

                        <div class="mb-6 bg-slate-50 p-5 rounded-xl border border-slate-200">
                            <label class="font-black text-slate-700 flex items-center gap-2 mb-3">
                                <svg class="w-5 h-5 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z"></path>
                                </svg>
                                Ulasan, Kritik & Saran (Opsional)
                            </label>
                            <textarea name="komentar" rows="3" class="w-full rounded-xl border-slate-300 shadow-inner focus:border-blue-500 focus:ring-blue-500 text-sm p-4 resize-y" placeholder="Ceritakan pengalaman Anda saat berkunjung atau berikan saran untuk perbaikan kami ke depannya..."></textarea>
                        </div>

                        <button type="submit" class="w-full bg-[#0f172a] text-white font-black py-4 rounded-xl hover:bg-[#F5C542] hover:text-[#0f172a] hover:shadow-lg transition-all flex items-center justify-center gap-2 tracking-widest text-sm active:scale-[0.98]">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"></path>
                            </svg>
                            KIRIM PENILAIAN SEKARANG
                        </button>
                    </form>
                </div>
                @empty
                <div class="flex flex-col items-center justify-center py-16 bg-white rounded-2xl border-2 border-dashed border-slate-200 text-center px-4">
                    <div class="bg-slate-50 p-6 rounded-full mb-4">
                        <svg class="w-16 h-16 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <h4 class="text-xl font-black text-slate-700 mb-2">Hore! Semua Sudah Dinilai 🎉</h4>
                    <p class="text-slate-500 max-w-md mb-6">Terima kasih atas partisipasi Anda! Saat ini tidak ada tiket kunjungan yang perlu Anda berikan penilaian.</p>
                    <a href="{{ route('masyarakat.index') }}" class="inline-flex items-center gap-2 bg-blue-50 text-blue-600 font-bold px-6 py-3 rounded-xl hover:bg-blue-100 transition shadow-sm">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                        </svg>
                        Kembali ke Dashboard
                    </a>
                </div>
                @endforelse

            </div>
        </div>

        <div class="text-center text-xs font-bold text-slate-400 mt-8 mb-4">
            &copy; {{ date('Y') }} Kejaksaan Negeri Banjarmasin
        </div>
    </div>
</x-app-layout>