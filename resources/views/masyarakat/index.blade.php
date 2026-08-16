<x-app-layout>
    <div class="min-h-screen bg-[#F8FAFC]">

        <div class="bg-[#0f172a] py-10 border-b-4 border-[#F5C542] relative overflow-hidden">
            <div class="absolute inset-0 opacity-10 bg-[url('https://www.transparenttextures.com/patterns/cubes.png')]"></div>

            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
                <div class="flex flex-col md:flex-row justify-between items-center gap-6">
                    <div class="text-white">
                        <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-white/10 border border-white/20 mb-3 backdrop-blur-sm">
                            <span class="w-2 h-2 rounded-full bg-green-500 animate-pulse"></span>
                            <span class="text-[10px] uppercase tracking-widest font-bold text-[#F5C542]">Sistem Online Terpadu</span>
                        </div>
                        <h1 class="text-3xl md:text-4xl font-serif font-bold leading-tight">
                            Portal Pelayanan <span class="text-[#F5C542]">Kunjungan Digital</span>
                        </h1>
                        <p class="text-slate-400 mt-2 text-sm md:text-base max-w-2xl">
                            Selamat datang, <strong>{{ Auth::user()->name }}</strong>. Kelola jadwal kunjungan Anda dengan mudah, cepat, dan transparan.
                        </p>
                    </div>

                    <div class="bg-white/5 border border-white/10 rounded-xl p-5 flex items-center gap-5 min-w-[250px] backdrop-blur-sm hover:bg-white/10 transition">
                        <div class="text-right">
                            <div class="text-xs text-slate-400 uppercase tracking-wider">Total Permohonan</div>
                            <div class="text-3xl font-bold text-white">{{ $kunjungans->count() }}</div>
                        </div>
                        <div class="h-12 w-12 bg-[#F5C542] rounded-lg flex items-center justify-center text-[#0f172a] shadow-lg shadow-orange-500/20">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                            </svg>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">

            @if(session('success'))
            <div class="mb-8 bg-emerald-50 border-l-4 border-emerald-500 text-emerald-800 p-4 rounded-r shadow-sm flex items-center gap-3 animate-fade-in-down">
                <div class="bg-emerald-100 p-2 rounded-full">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                    </svg>
                </div>
                <div>
                    <h4 class="font-bold text-sm">Berhasil!</h4>
                    <p class="text-xs">{{ session('success') }}</p>
                </div>
            </div>
            @endif

            <!-- TAMBAHAN KODE: NOTIFIKASI ERROR / DITOLAK -->
            @if(session('error'))
            <div class="mb-8 bg-red-50 border-l-4 border-red-500 text-red-800 p-4 rounded-r shadow-sm flex items-center gap-3 animate-fade-in-down">
                <div class="bg-red-100 p-2 rounded-full">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </div>
                <div>
                    <h4 class="font-bold text-sm">Akses Ditolak!</h4>
                    <p class="text-xs">{{ session('error') }}</p>
                </div>
            </div>
            @endif
            <!-- AKHIR TAMBAHAN KODE -->

            <div class="flex items-center justify-between mb-6">
                <div>
                    <h3 class="font-bold text-[#0f172a] text-xl">Menu Layanan</h3>
                    <p class="text-xs text-slate-500">Akses cepat fitur aplikasi</p>
                </div>
            </div>

            <div class="grid grid-cols-2 md:grid-cols-4 gap-6 mb-12">
                <div onclick="document.getElementById('modalTitipan').classList.remove('hidden')" class="group bg-white p-6 rounded-2xl shadow-sm border border-slate-100 hover:shadow-lg hover:-translate-y-1 transition-all duration-300 flex flex-col items-center justify-center text-center relative overflow-hidden cursor-pointer">
                    <div class="absolute top-2 right-2 bg-red-500 text-white text-[9px] font-bold px-2 py-0.5 rounded-full animate-pulse shadow-sm">BARU</div>
                    <div class="w-14 h-14 bg-blue-50 text-blue-600 rounded-2xl flex items-center justify-center mb-4 group-hover:bg-blue-600 group-hover:text-white transition-colors shadow-sm">
                        <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                        </svg>
                    </div>
                    <h4 class="font-bold text-slate-700 group-hover:text-blue-600">Titipan Barang</h4>
                    <p class="text-[10px] text-slate-400 mt-1">Makanan / Uang / Baju</p>
                </div>

                <a href="{{ route('masyarakat.laporan', 'jadwal') }}" class="group bg-white p-6 rounded-2xl shadow-sm border border-slate-100 hover:shadow-lg hover:-translate-y-1 transition-all duration-300 flex flex-col items-center justify-center text-center">
                    <div class="w-14 h-14 bg-purple-50 text-purple-600 rounded-2xl flex items-center justify-center mb-4 group-hover:bg-purple-600 group-hover:text-white transition-colors shadow-sm">
                        <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                    </div>
                    <h4 class="font-bold text-slate-700 group-hover:text-purple-600">Laporan Saya</h4>
                    <p class="text-[10px] text-slate-400 mt-1">Cetak & Rekapitulasi</p>
                </a>

                <a href="{{ route('masyarakat.riwayat') }}" class="group bg-white p-6 rounded-2xl shadow-sm border border-slate-100 hover:shadow-lg hover:-translate-y-1 transition-all duration-300 flex flex-col items-center justify-center text-center">
                    <div class="w-14 h-14 bg-emerald-50 text-emerald-600 rounded-2xl flex items-center justify-center mb-4 group-hover:bg-emerald-600 group-hover:text-white transition-colors shadow-sm">
                        <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <h4 class="font-bold text-slate-700 group-hover:text-emerald-600">Riwayat</h4>
                    <p class="text-[10px] text-slate-400 mt-1">Arsip Permohonan</p>
                </a>

                <div onclick="document.getElementById('infoModal').classList.remove('hidden')" class="group bg-white p-6 rounded-2xl shadow-sm border border-slate-100 hover:shadow-lg hover:-translate-y-1 transition-all duration-300 flex flex-col items-center justify-center text-center cursor-pointer">
                    <div class="w-14 h-14 bg-orange-50 text-orange-600 rounded-2xl flex items-center justify-center mb-4 group-hover:bg-orange-600 group-hover:text-white transition-colors shadow-sm">
                        <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <h4 class="font-bold text-slate-700 group-hover:text-orange-600">Tata Tertib</h4>
                    <p class="text-[10px] text-slate-400 mt-1">Info Kunjungan</p>
                </div>
            </div>

            {{-- ========================================== --}}
            {{-- KOTAK DAFTAR TIKET KUNJUNGAN --}}
            {{-- ========================================== --}}
            <div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden mb-8">
                <div class="px-6 py-5 border-b border-slate-100 flex justify-between items-center bg-slate-50">
                    <div>
                        <h3 class="font-bold text-[#0f172a]">Tiket Kunjungan Saya</h3>
                        <p class="text-xs text-slate-500">Daftar pengajuan terbaru</p>
                    </div>
                    <a href="{{ route('masyarakat.create') }}" class="px-5 py-2.5 bg-[#F5C542] hover:bg-yellow-400 text-[#0f172a] text-xs font-bold rounded-lg shadow-md transition flex items-center gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                        </svg>
                        Buat Baru
                    </a>
                </div>

                @if($kunjungans->isEmpty())
                <div class="p-12 text-center">
                    <div class="w-20 h-20 bg-slate-50 rounded-full flex items-center justify-center mx-auto mb-4">
                        <svg class="w-10 h-10 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                    </div>
                    <h4 class="font-bold text-slate-700">Tidak Ada Data</h4>
                    <p class="text-slate-500 text-sm mt-1">Mulai buat janji kunjungan sekarang.</p>
                </div>
                @else
                <div class="divide-y divide-slate-100">
                    @foreach($kunjungans->take(3) as $item)
                    <div class="p-4 hover:bg-blue-50/50 transition flex flex-col md:flex-row items-center justify-between gap-4 group">
                        <div class="flex items-center gap-4 w-full md:w-auto">
                            <div class="w-16 h-16 bg-[#0f172a] rounded-xl flex flex-col items-center justify-center text-white shrink-0 shadow-md group-hover:scale-105 transition-transform">
                                <span class="text-[10px] uppercase font-bold opacity-70 tracking-widest">{{ \Carbon\Carbon::parse($item->tanggal_kunjungan)->translatedFormat('M') }}</span>
                                <span class="text-2xl font-bold font-serif leading-none">{{ \Carbon\Carbon::parse($item->tanggal_kunjungan)->format('d') }}</span>
                            </div>
                            <div>
                                <div class="flex items-center gap-2 mb-1">
                                    <span class="text-xs font-mono font-bold text-slate-500 bg-slate-100 px-2 py-0.5 rounded">#REQ-{{ $item->id }}</span>
                                    @if($item->status == 'menunggu')
                                    <span class="flex items-center gap-1 px-2 py-0.5 rounded text-[10px] font-bold bg-yellow-100 text-yellow-800 border border-yellow-200"><span class="w-1.5 h-1.5 rounded-full bg-yellow-500 animate-pulse"></span> VERIFIKASI</span>
                                    @elseif($item->status == 'disetujui')
                                    <span class="flex items-center gap-1 px-2 py-0.5 rounded text-[10px] font-bold bg-emerald-100 text-emerald-800 border border-emerald-200">DISETUJUI</span>
                                    @elseif($item->status == 'ditolak')
                                    <span class="flex items-center gap-1 px-2 py-0.5 rounded text-[10px] font-bold bg-red-100 text-red-800 border border-red-200">DITOLAK</span>
                                    @endif
                                </div>
                                <h4 class="font-bold text-slate-800 text-sm flex items-center gap-2">{{ $item->nama_tahanan }}</h4>
                                <div class="flex items-center gap-3 mt-1.5">
                                    <span class="text-[10px] font-bold text-slate-500 uppercase tracking-wide">SESI {{ strtoupper($item->jam_kunjungan) }}</span>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Penambahan Group Tombol Aksi Kunjungan -->
                        <div class="flex items-center gap-2">
                            <a href="{{ route('masyarakat.edit', $item->id) }}" class="text-xs font-bold text-yellow-600 hover:text-yellow-800 hover:bg-yellow-50 px-4 py-2 rounded-lg transition border border-transparent hover:border-yellow-200">Edit</a>
                            <a href="{{ route('masyarakat.show', $item->id) }}" class="text-xs font-bold text-blue-600 hover:text-blue-800 hover:bg-blue-50 px-4 py-2 rounded-lg transition border border-transparent hover:border-blue-200">Lihat Detail</a>
                        </div>
                    </div>
                    @endforeach
                </div>
                @endif
            </div>

            {{-- ========================================== --}}
            {{-- KOTAK DAFTAR TIKET TITIPAN BARANG --}}
            {{-- ========================================== --}}
            <div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden mb-10">
                <div class="px-6 py-5 border-b border-slate-100 flex justify-between items-center bg-slate-50">
                    <div>
                        <h3 class="font-bold text-[#0f172a]">Tiket Titipan Barang Saya</h3>
                        <p class="text-xs text-slate-500">Daftar pengajuan titipan barang terbaru.</p>
                    </div>
                    <button type="button" onclick="document.getElementById('modalTitipan').classList.remove('hidden')" class="px-5 py-2.5 bg-[#F5C542] hover:bg-yellow-400 text-[#0f172a] text-xs font-bold rounded-lg shadow-md transition flex items-center gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                        </svg>
                        Buat Baru
                    </button>
                </div>

                <div class="p-4 space-y-4">
                    @forelse($titipans as $item)
                    <div class="flex flex-col sm:flex-row sm:items-center justify-between p-4 rounded-xl border border-slate-100 hover:border-slate-200 transition-all hover:shadow-sm gap-4">
                        <div class="flex items-center gap-4">
                            <div class="bg-slate-900 text-white w-14 h-14 rounded-xl flex flex-col items-center justify-center flex-shrink-0 shadow-sm">
                                <span class="text-[10px] font-bold uppercase tracking-wider opacity-80">{{ $item->created_at->format('M') }}</span>
                                <span class="text-xl font-black leading-none">{{ $item->created_at->format('d') }}</span>
                            </div>

                            <div>
                                <div class="flex items-center gap-2 mb-1">
                                    <span class="text-xs font-bold text-slate-400">#TTP-{{ $item->id }}</span>

                                    @if(in_array(strtolower($item->status), ['diajukan', 'menunggu']))
                                    <span class="px-2 py-0.5 rounded text-[10px] font-bold bg-yellow-100 text-yellow-700">MENUNGGU</span>
                                    @elseif(in_array(strtolower($item->status), ['disetujui', 'diterima', 'selesai']))
                                    <span class="px-2 py-0.5 rounded text-[10px] font-bold bg-emerald-100 text-emerald-700">DISETUJUI</span>
                                    @else
                                    <span class="px-2 py-0.5 rounded text-[10px] font-bold bg-red-100 text-red-700">DITOLAK</span>
                                    @endif
                                </div>
                                <h4 class="font-bold text-slate-800">{{ $item->nama_tahanan }}</h4>
                                <p class="text-xs text-slate-500 font-medium mt-0.5">{{ $item->jenis_titipan }}</p>
                            </div>
                        </div>

                        <!-- Penambahan Group Tombol Aksi Titipan Barang -->
                        <div class="flex flex-wrap items-center sm:justify-end gap-2">
                            <a href="{{ route('masyarakat.titipan.edit', $item->id) }}" class="text-xs font-bold bg-white border border-slate-200 text-slate-700 px-4 py-2 rounded-lg hover:bg-slate-50 transition shadow-sm w-full sm:w-auto text-center flex items-center justify-center gap-1.5">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path>
                                </svg>
                                Edit
                            </a>

                            @if(in_array(strtolower($item->status), ['disetujui', 'diterima', 'selesai']))
                            <a href="{{ route('masyarakat.titipan.cetak', $item->id) }}" target="_blank" class="text-xs font-bold bg-[#0f172a] text-white px-4 py-2 rounded-lg hover:bg-slate-700 transition flex items-center gap-2 shadow-sm w-full sm:w-auto justify-center">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path>
                                </svg>
                                Cetak Surat Label
                            </a>
                            @else
                            <span class="text-xs font-bold text-slate-300 italic w-full sm:w-auto text-center sm:text-right px-2">Surat belum tersedia</span>
                            @endif
                        </div>
                    </div>
                    @empty
                    <div class="text-center py-8 text-slate-400 text-sm border-2 border-dashed border-slate-200 rounded-xl bg-slate-50 m-4">
                        Belum ada pengajuan titipan barang.
                    </div>
                    @endforelse
                </div>
            </div>

            <!-- FOOTER BAWAH -->
            <div class="text-center text-slate-400 text-xs pb-10">
                &copy; {{ date('Y') }} Kejaksaan Negeri Banjarmasin
            </div>

    {{-- ========================================== --}}
    {{-- MODAL TITIPAN BARANG --}}
    {{-- ========================================== --}}
    <div id="modalTitipan" class="fixed inset-0 z-50 hidden" aria-labelledby="modal-title" role="dialog" aria-modal="true">
        <div class="fixed inset-0 bg-slate-900/80 backdrop-blur-sm transition-opacity" onclick="document.getElementById('modalTitipan').classList.add('hidden')"></div>
        <div class="fixed inset-0 z-10 overflow-y-auto">
            <div class="flex min-h-full items-center justify-center p-4 text-center sm:p-0">
                <div class="relative transform overflow-hidden rounded-2xl bg-white text-left shadow-2xl transition-all sm:my-8 sm:w-full sm:max-w-2xl animate-scale-up">

                    <div class="bg-[#0f172a] px-6 py-4 flex justify-between items-center border-b border-slate-700">
                        <h3 class="text-lg font-bold leading-6 text-white flex items-center gap-2">
                            <span class="bg-[#F5C542] text-[#0f172a] p-1.5 rounded-lg">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                                </svg>
                            </span>
                            Formulir Titipan Barang
                        </h3>
                        <button type="button" class="text-slate-400 hover:text-white transition" onclick="document.getElementById('modalTitipan').classList.add('hidden')"><svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                            </svg></button>
                    </div>

                    <form action="{{ route('titipan.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="px-6 py-6 bg-slate-50">
                            <div class="bg-white p-4 rounded-xl border border-slate-200 mb-6 flex items-center gap-4">
                                <div class="w-10 h-10 bg-blue-100 text-blue-600 rounded-full flex items-center justify-center font-bold">{{ substr(Auth::user()->name, 0, 1) }}</div>
                                <div>
                                    <p class="text-[10px] text-slate-400 font-bold uppercase tracking-wider">PENGIRIM</p>
                                    <p class="font-bold text-slate-800">{{ Auth::user()->name }}</p>
                                </div>
                            </div>

                            <div class="mb-5 relative">
                                <label class="block text-sm font-bold text-slate-700 mb-2">Nomor Tahanan <span class="text-red-500">*</span></label>
                                <input type="text" id="inputNoTahananTitipan" name="no_tahanan" class="w-full rounded-xl border-slate-300 focus:ring-[#0f172a] focus:border-[#0f172a] text-sm transition-colors" placeholder="Ketik Nomor Lengkap (Contoh: T-6578)" autocomplete="off" onkeyup="cariTahananTitipan(this.value)" required>
                                <p id="pesanValidasiTitipan" class="text-[11px] mt-1 font-bold h-4 text-blue-500">Ketik nomor tahanan secara lengkap untuk mencari.</p>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-5 mb-5">
                                <div>
                                    <label class="block text-sm font-bold text-slate-700 mb-2">Nama Tahanan <span class="text-red-500">*</span></label>
                                    <input type="text" id="nama_tahanan_titipan" name="nama_tahanan" class="w-full rounded-xl border-slate-300 bg-slate-50 text-slate-500 focus:ring-0 shadow-sm transition-colors pointer-events-none text-sm" placeholder="Akan terisi otomatis..." required readonly tabindex="-1">
                                </div>
                                <div>
                                    <label class="block text-sm font-bold text-slate-700 mb-2">Lokasi Penahanan</label>
                                    <input type="text" id="lokasi_tahanan_titipan" name="lokasi_tahanan" class="w-full rounded-xl border-slate-300 bg-slate-50 text-slate-500 focus:ring-0 shadow-sm transition-colors pointer-events-none text-sm" placeholder="Akan terisi otomatis..." readonly tabindex="-1">
                                </div>
                            </div>

                            <div class="mb-5">
                                <label class="block text-sm font-bold text-slate-700 mb-2">Jenis Barang <span class="text-red-500">*</span></label>
                                <select name="jenis_titipan" class="w-full rounded-xl border-slate-300 focus:ring-[#0f172a] focus:border-[#0f172a] text-sm" required>
                                    <option value="">-- Pilih --</option>
                                    <option value="Makanan">Makanan/Minuman</option>
                                    <option value="Pakaian">Pakaian/Baju</option>
                                    <option value="Uang">Uang Tunai</option>
                                    <option value="Obat-obatan">Obat-obatan</option>
                                    <option value="Lainnya">Lainnya</option>
                                </select>
                            </div>

                            <div class="mb-5">
                                <label class="block text-sm font-bold text-slate-700 mb-2">Foto Barang <span class="text-red-500">*</span></label>
                                <input type="file" name="foto_barang" accept="image/*" class="w-full text-sm text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-bold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100" required>
                            </div>

                            <div class="mb-2">
                                <label class="block text-sm font-bold text-slate-700 mb-2">Rincian Barang <span class="text-red-500">*</span></label>
                                <textarea name="deskripsi_barang" rows="3" class="w-full rounded-xl border-slate-300 focus:ring-[#0f172a] focus:border-[#0f172a] text-sm" placeholder="Contoh: Nasi Goreng 2 Bungkus, Uang 50rb" required></textarea>
                            </div>
                        </div>

                        <div class="bg-white px-6 py-4 flex flex-row-reverse border-t border-slate-100 gap-3">
                            <button type="submit" class="inline-flex w-full justify-center rounded-xl bg-[#0f172a] px-6 py-2.5 text-sm font-bold text-white shadow-lg hover:bg-[#F5C542] hover:text-[#0f172a] sm:w-auto transition-all">Kirim Titipan</button>
                            <button type="button" class="inline-flex w-full justify-center rounded-xl bg-white border border-slate-300 px-6 py-2.5 text-sm font-bold text-slate-700 hover:bg-slate-50 sm:w-auto transition-all" onclick="document.getElementById('modalTitipan').classList.add('hidden')">Batal</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    {{-- ========================================== --}}
    {{-- INFO MODAL TATA TERTIB --}}
    {{-- ========================================== --}}
    <div id="infoModal" class="fixed inset-0 z-50 hidden" aria-labelledby="modal-title" role="dialog" aria-modal="true">
        <div class="fixed inset-0 bg-slate-900/70 backdrop-blur-sm transition-opacity" onclick="document.getElementById('infoModal').classList.add('hidden')"></div>
        <div class="fixed inset-0 z-10 overflow-y-auto">
            <div class="flex min-h-full items-center justify-center p-4 text-center sm:p-0">
                <div class="relative transform overflow-hidden rounded-2xl bg-white text-left shadow-2xl transition-all sm:my-8 sm:w-full sm:max-w-4xl animate-scale-up">
                    <div class="bg-[#0f172a] px-6 py-4 flex justify-between items-center border-b border-slate-700">
                        <h3 class="text-lg font-bold leading-6 text-white flex items-center gap-2"><span class="bg-[#F5C542] text-[#0f172a] p-1 rounded"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg></span> Tata Tertib Kunjungan</h3>
                        <button type="button" class="text-slate-400 hover:text-white" onclick="document.getElementById('infoModal').classList.add('hidden')"><svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                            </svg></button>
                    </div>
                    <div class="px-6 py-6 max-h-[75vh] overflow-y-auto bg-slate-50">
                        <div class="mb-8">
                            <h4 class="font-bold text-red-600 mb-4 flex items-center gap-2 text-sm uppercase tracking-wider border-b border-red-200 pb-2">Dilarang Keras Masuk (X)</h4>
                            <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-5 gap-4">
                                <div class="bg-white p-3 rounded-xl border border-red-100 flex flex-col items-center text-center shadow-sm relative overflow-hidden group">
                                    <div class="w-12 h-12 bg-red-50 rounded-full flex items-center justify-center mb-2"><svg class="w-6 h-6 text-slate-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 18h.01M8 21h8a2 2 0 002-2V5a2 2 0 00-2-2H8a2 2 0 00-2 2v14a2 2 0 002 2z"></path>
                                        </svg></div><span class="text-xs font-bold text-slate-700">Handphone</span>
                                </div>
                                <div class="bg-white p-3 rounded-xl border border-red-100 flex flex-col items-center text-center shadow-sm relative overflow-hidden group">
                                    <div class="w-12 h-12 bg-red-50 rounded-full flex items-center justify-center mb-2"><svg class="w-6 h-6 text-slate-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"></path>
                                        </svg></div><span class="text-xs font-bold text-slate-700">Narkoba</span>
                                </div>
                                <div class="bg-white p-3 rounded-xl border border-red-100 flex flex-col items-center text-center shadow-sm relative overflow-hidden group">
                                    <div class="w-12 h-12 bg-red-50 rounded-full flex items-center justify-center mb-2"><svg class="w-6 h-6 text-slate-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"></path>
                                        </svg></div><span class="text-xs font-bold text-slate-700">Kamera</span>
                                </div>
                                <div class="bg-white p-3 rounded-xl border border-red-100 flex flex-col items-center text-center shadow-sm relative overflow-hidden group">
                                    <div class="w-12 h-12 bg-red-50 rounded-full flex items-center justify-center mb-2"><svg class="w-6 h-6 text-slate-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                        </svg></div><span class="text-xs font-bold text-slate-700">Sajam</span>
                                </div>
                                <div class="bg-white p-3 rounded-xl border border-red-100 flex flex-col items-center text-center shadow-sm relative overflow-hidden group">
                                    <div class="w-12 h-12 bg-red-50 rounded-full flex items-center justify-center mb-2"><svg class="w-6 h-6 text-slate-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                                        </svg></div><span class="text-xs font-bold text-slate-700">Pecah Belah</span>
                                </div>
                            </div>
                        </div>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div class="bg-white rounded-xl border border-emerald-100 p-5 shadow-sm">
                                <h4 class="font-bold text-emerald-700 mb-3 flex items-center gap-2 text-sm uppercase tracking-wide">Pakaian (Boleh)</h4>
                                <ul class="space-y-2 text-sm text-slate-600">
                                    <li>✅ Kemeja / Kaos Berkerah</li>
                                    <li>✅ Celana Panjang Sopan</li>
                                    <li>✅ Wajib Bersepatu</li>
                                </ul>
                            </div>
                            <div class="bg-white rounded-xl border border-red-100 p-5 shadow-sm">
                                <h4 class="font-bold text-red-700 mb-3 flex items-center gap-2 text-sm uppercase tracking-wide">Pakaian (Dilarang)</h4>
                                <ul class="space-y-2 text-sm text-slate-600">
                                    <li>❌ Celana Pendek / Boxer</li>
                                    <li>❌ Kaos Kutang / Singlet</li>
                                    <li>❌ Sandal Jepit</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="bg-white px-4 py-4 sm:flex sm:flex-row-reverse sm:px-6 border-t border-slate-100">
                        <button type="button" class="inline-flex w-full justify-center rounded-xl bg-[#0f172a] px-5 py-2.5 text-sm font-bold text-white shadow-sm hover:bg-[#F5C542] hover:text-[#0f172a] sm:ml-3 sm:w-auto transition-all" onclick="document.getElementById('infoModal').classList.add('hidden')">Saya Mengerti</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- ========================================== --}}
    {{-- SCRIPT PENCARIAN TAHANAN --}}
    {{-- ========================================== --}}
    <script>
        const activePrisonersTitipan = @json($tahanans ?? []);

        function cariTahananTitipan(keyword) {
            let pesan = document.getElementById('pesanValidasiTitipan');
            let inputNo = document.getElementById('inputNoTahananTitipan');
            let namaInput = document.getElementById('nama_tahanan_titipan');
            let lokasiInput = document.getElementById('lokasi_tahanan_titipan');

            inputNo.classList.remove('border-green-500', 'ring-green-500', 'border-red-500');

            if (keyword.trim() === "") {
                pesan.innerHTML = "Ketik nomor tahanan secara lengkap untuk mencari.";
                pesan.className = "text-[11px] mt-1 text-blue-500 font-bold h-4";
                if (namaInput) {
                    namaInput.value = "";
                    namaInput.classList.remove('bg-green-100', 'font-bold', 'text-green-800');
                }
                if (lokasiInput) {
                    lokasiInput.value = "";
                    lokasiInput.classList.remove('bg-green-100', 'font-bold', 'text-green-800');
                }
                return;
            }

            let match = activePrisonersTitipan.find(t =>
                t.no_tahanan && t.no_tahanan.toLowerCase() === keyword.toLowerCase().trim()
            );

            if (match) {
                pesan.innerHTML = "✅ Nomor Ditemukan (Data Terisi)";
                pesan.className = "text-[11px] mt-1 text-green-600 font-bold h-4";
                inputNo.classList.add('border-green-500', 'ring-green-500');
                if (namaInput && match.nama_tahanan) {
                    namaInput.value = match.nama_tahanan;
                    namaInput.classList.add('bg-green-100', 'font-bold', 'text-green-800');
                }
                if (lokasiInput && match.lokasi_tahanan) {
                    lokasiInput.value = match.lokasi_tahanan;
                    lokasiInput.classList.add('bg-green-100', 'font-bold', 'text-green-800');
                }
            } else {
                pesan.innerHTML = "❌ Data tidak ditemukan. Pastikan ketik lengkap!";
                pesan.className = "text-[11px] mt-1 text-red-600 font-bold h-4";
                inputNo.classList.add('border-red-500');
                if (namaInput) {
                    namaInput.value = "";
                    namaInput.classList.remove('bg-green-100', 'font-bold', 'text-green-800');
                }
                if (lokasiInput) {
                    lokasiInput.value = "";
                    lokasiInput.classList.remove('bg-green-100', 'font-bold', 'text-green-800');
                }
            }
        }
    </script>
</x-app-layout>