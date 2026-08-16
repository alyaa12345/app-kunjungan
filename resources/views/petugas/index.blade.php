<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4 bg-white pt-2 pb-4">
            <div>
                <span class="bg-amber-500 text-white text-[10px] font-bold px-2.5 py-1 rounded-md tracking-widest uppercase shadow-sm">
                    Mode Kejaksaan
                </span>
                <h2 class="font-bold text-2xl text-slate-900 leading-tight mt-2">
                    Ruang Kerja Admin
                </h2>
                <p class="text-sm text-slate-500 font-medium mt-1">
                    Pusat verifikasi legalitas izin kunjungan dan pengelolaan master data.
                </p>
            </div>

            <div class="flex items-center gap-3 bg-slate-50 p-1.5 rounded-2xl border border-slate-200">
                <div class="px-4 py-2 text-center">
                    <div class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">Menunggu</div>
                    <div class="text-xl font-black text-amber-600 leading-none mt-1">{{ $menungguVerifikasi ?? 0 }}</div>
                </div>
                <div class="w-px h-8 bg-slate-200"></div>
                <div class="px-4 py-2 text-center">
                    <div class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">Disetujui Hari Ini</div>
                    <div class="text-xl font-black text-emerald-600 leading-none mt-1">{{ $totalKunjungan ?? 0 }}</div>
                </div>
            </div>
        </div>
    </x-slot>

    <div class="py-8 bg-slate-50 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            @if(session('success'))
            <div class="bg-emerald-50 border-l-4 border-emerald-500 p-4 rounded-r shadow-sm mb-6 flex items-center gap-3">
                <div class="w-8 h-8 bg-emerald-500 rounded-full flex items-center justify-center text-white shrink-0">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                    </svg>
                </div>
                <p class="font-bold text-emerald-800 text-sm">{{ session('success') }}</p>
            </div>
            @endif

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <a href="#" class="block bg-white rounded-2xl shadow-sm border border-slate-200 p-6 flex flex-col justify-between group hover:border-amber-400 hover:shadow-md transition-all cursor-pointer relative overflow-hidden">
                    <div class="absolute -right-4 -top-4 w-24 h-24 bg-amber-50 rounded-full opacity-50 group-hover:scale-150 transition-transform duration-500"></div>
                    <div class="flex items-center gap-4 relative z-10">
                        <div class="w-12 h-12 bg-amber-100 text-amber-600 rounded-xl flex items-center justify-center group-hover:bg-amber-500 group-hover:text-white transition-colors">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                        <div>
                            <h3 class="font-bold text-slate-800 text-lg">Verifikasi Izin</h3>
                            <p class="text-[11px] text-slate-500 font-bold uppercase tracking-wider mt-0.5">Permohonan Kunjungan</p>
                        </div>
                    </div>
                </a>

                <a href="{{ url('/petugas/tahanan') }}" class="block bg-white rounded-2xl shadow-sm border border-slate-200 p-6 flex flex-col justify-between group hover:border-blue-400 hover:shadow-md transition-all cursor-pointer relative overflow-hidden">
                    <div class="absolute -right-4 -top-4 w-24 h-24 bg-blue-50 rounded-full opacity-50 group-hover:scale-150 transition-transform duration-500"></div>
                    <div class="flex items-center gap-4 relative z-10">
                        <div class="w-12 h-12 bg-blue-100 text-blue-600 rounded-xl flex items-center justify-center group-hover:bg-blue-600 group-hover:text-white transition-colors">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                            </svg>
                        </div>
                        <div>
                            <h3 class="font-bold text-slate-800 text-lg">Master Tahanan</h3>
                            <p class="text-[11px] text-slate-500 font-bold uppercase tracking-wider mt-0.5">Kelola Data Warga Binaan</p>
                        </div>
                    </div>
                </a>

                <a href="{{ url('/petugas/laporan') }}" class="block bg-white rounded-2xl shadow-sm border border-slate-200 p-6 flex flex-col justify-between group hover:border-emerald-400 hover:shadow-md transition-all cursor-pointer relative overflow-hidden">
                    <div class="absolute -right-4 -top-4 w-24 h-24 bg-emerald-50 rounded-full opacity-50 group-hover:scale-150 transition-transform duration-500"></div>
                    <div class="flex items-center gap-4 relative z-10">
                        <div class="w-12 h-12 bg-emerald-100 text-emerald-600 rounded-xl flex items-center justify-center group-hover:bg-emerald-600 group-hover:text-white transition-colors">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 011.414.586l4 4a1 1 0 01.586 1.414V19a2 2 0 01-2 2z"></path>
                            </svg>
                        </div>
                        <div>
                            <h3 class="font-bold text-slate-800 text-lg">Laporan & Survei</h3>
                            <p class="text-[11px] text-slate-500 font-bold uppercase tracking-wider mt-0.5">Rekapitulasi & Nilai CSI</p>
                        </div>
                    </div>
                </a>
            </div>

            <div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden mt-8">
                <div class="p-6 border-b border-slate-100 flex justify-between items-center bg-white">
                    <div>
                        <h3 class="text-[15px] font-extrabold text-slate-800 tracking-wide">Permohonan Izin Masuk</h3>
                        <p class="text-xs text-slate-500 mt-1 font-medium">Membutuhkan verifikasi legalitas segera.</p>
                    </div>
                    <span class="bg-amber-100 text-amber-700 border border-amber-200 text-[11px] font-bold px-3 py-1.5 rounded-full tracking-wide">Perlu Diproses: {{ $kunjungans->count() }}</span>
                </div>

                @if($kunjungans->isEmpty())
                <div class="p-20 flex flex-col items-center justify-center text-center bg-slate-50/50">
                    <div class="w-20 h-20 bg-white shadow-sm border border-slate-100 rounded-full flex items-center justify-center mb-5">
                        <svg class="w-10 h-10 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"></path>
                        </svg>
                    </div>
                    <h4 class="font-black text-slate-700 text-xl tracking-wide">Meja Kerja Bersih!</h4>
                    <p class="text-sm text-slate-500 mt-2 max-w-md">Tidak ada permohonan kunjungan baru yang menunggu verifikasi legalitas dari Kejaksaan saat ini.</p>
                </div>
                @else
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead class="bg-slate-50 text-slate-500 text-[11px] uppercase tracking-wider">
                            <tr>
                                <th class="p-4 font-bold">Pemohon / Tanggal</th>
                                <th class="p-4 font-bold">Detail Tahanan</th>
                                <th class="p-4 font-bold">KTP & Pengikut</th>
                                <th class="p-4 font-bold text-center">Aksi Verifikasi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100">
                            @foreach($kunjungans as $item)
                            <tr class="hover:bg-slate-50/50 transition">
                                <td class="p-4">
                                    <div class="flex flex-col">
                                        <span class="font-black text-slate-800 text-sm">{{ $item->nama_pengunjung }}</span>
                                        <span class="text-xs text-slate-500 mt-0.5">NIK: {{ $item->nik_pengunjung }}</span>
                                        <div class="mt-2 flex items-center gap-1">
                                            <svg class="w-3 h-3 text-amber-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                            </svg>
                                            <span class="text-xs font-bold text-amber-600">{{ \Carbon\Carbon::parse($item->tanggal_kunjungan)->format('d M Y') }}</span>
                                        </div>
                                    </div>
                                </td>

                                <td class="p-4">
                                    <div class="flex flex-col">
                                        <span class="font-bold text-slate-800 text-sm">{{ $item->nama_tahanan }}</span>
                                        <span class="text-xs text-slate-500 mt-0.5">{{ $item->lokasi_tahanan }}</span>
                                        <span class="text-[10px] font-bold text-blue-600 bg-blue-50 px-2 py-0.5 rounded w-fit mt-1.5 uppercase tracking-wide">SESI {{ $item->jam_kunjungan }}</span>
                                    </div>
                                </td>

                                <td class="p-4">
                                    <div class="flex flex-col gap-2">
                                        <div class="text-xs text-slate-600 font-medium">
                                            Pengikut: <span class="font-bold text-slate-800">{{ $item->jumlah_pengikut }} Orang</span>
                                        </div>
                                        <a href="{{ asset('storage/'.$item->foto_ktp) }}" target="_blank" class="inline-flex items-center gap-1.5 text-xs font-bold text-indigo-600 bg-indigo-50 hover:bg-indigo-100 px-3 py-1.5 rounded-lg w-fit transition border border-indigo-100">
                                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                            </svg>
                                            Cek Foto KTP
                                        </a>
                                    </div>
                                </td>

                                <td class="p-4 text-center">
                                    <div class="flex justify-center gap-2">
                                        <form action="{{ url('/petugas/update-status/' . $item->id) }}" method="POST" onsubmit="return confirm('Yakin ingin MENYETUJUI izin kunjungan ini?');" class="inline-block">
                                            @csrf
                                            @method('PATCH')
                                            <input type="hidden" name="status" value="disetujui">
                                            <button type="submit" class="bg-emerald-500 hover:bg-emerald-600 text-white p-2 rounded-lg transition shadow-sm" title="Setujui Izin">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path>
                                                </svg>
                                            </button>
                                        </form>

                                        <button type="button" onclick="document.getElementById('modalTolak-{{ $item->id }}').classList.remove('hidden')" class="bg-rose-500 hover:bg-rose-600 text-white p-2 rounded-lg transition shadow-sm" title="Tolak Izin">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M6 18L18 6M6 6l12 12"></path>
                                            </svg>
                                        </button>
                                    </div>

                                    <div id="modalTolak-{{ $item->id }}" class="fixed inset-0 z-50 hidden" aria-labelledby="modal-title" role="dialog" aria-modal="true">
                                        <div class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm transition-opacity"></div>
                                        <div class="fixed inset-0 z-10 overflow-y-auto">
                                            <div class="flex min-h-full items-center justify-center p-4 text-center sm:p-0">
                                                <div class="relative transform overflow-hidden rounded-2xl bg-white text-left shadow-2xl transition-all sm:my-8 sm:w-full sm:max-w-md">
                                                    <div class="bg-rose-600 px-4 py-3 flex justify-between items-center text-white">
                                                        <h3 class="text-sm font-bold flex items-center gap-2"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                                                            </svg> Tolak Permohonan #REQ-{{ $item->id }}</h3>
                                                        <button type="button" onclick="document.getElementById('modalTolak-{{ $item->id }}').classList.add('hidden')" class="hover:bg-rose-700 p-1 rounded transition"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                                            </svg></button>
                                                    </div>
                                                    <form action="{{ url('/petugas/update-status/' . $item->id) }}" method="POST">
                                                        @csrf
                                                        @method('PATCH')
                                                        <input type="hidden" name="status" value="ditolak">
                                                        <div class="px-6 py-6">
                                                            <label class="block text-sm font-bold text-slate-700 mb-2">Alasan Penolakan <span class="text-red-500">*</span></label>
                                                            <textarea name="alasan" rows="3" class="w-full rounded-xl border-slate-300 focus:ring-rose-500 focus:border-rose-500 text-sm" placeholder="Contoh: KTP tidak jelas / Kuota penuh" required></textarea>
                                                        </div>
                                                        <div class="bg-slate-50 px-6 py-4 flex justify-end gap-2 border-t border-slate-100">
                                                            <button type="button" onclick="document.getElementById('modalTolak-{{ $item->id }}').classList.add('hidden')" class="bg-white border border-slate-300 text-slate-700 font-bold px-4 py-2 rounded-lg text-sm hover:bg-slate-50 transition">Batal</button>
                                                            <button type="submit" class="bg-rose-600 text-white font-bold px-4 py-2 rounded-lg text-sm hover:bg-rose-700 transition">Kirim Penolakan</button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
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