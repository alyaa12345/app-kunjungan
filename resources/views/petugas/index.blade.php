<x-app-layout>
    <div class="min-h-screen bg-[#F1F5F9] font-sans pb-20">

        <div class="bg-white border-b border-gray-200 shadow-sm sticky top-0 z-30">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
                <div class="flex flex-col md:flex-row justify-between items-center gap-4">

                    <div class="flex-1 w-full">
                        <div class="flex items-center gap-2 mb-1">
                            <span class="px-2 py-0.5 rounded bg-[#0f172a] text-[#F5C542] text-[10px] font-bold uppercase tracking-widest border border-slate-700">
                                Mode Admin
                            </span>
                        </div>
                        <h1 class="text-2xl font-serif font-bold text-slate-800">Meja Verifikasi</h1>
                        <p class="text-sm text-slate-500">Validasi data pemohon sebelum masuk ke Gate.</p>
                    </div>

                    <div class="relative w-full md:w-72">
                        <input type="text" id="searchInput" onkeyup="searchTable()" placeholder="Cari Nama Pengunjung..."
                            class="w-full pl-10 pr-4 py-2.5 rounded-xl border border-slate-300 focus:ring-2 focus:ring-[#F5C542] focus:border-[#F5C542] text-sm shadow-sm transition-all bg-white">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-slate-400">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                            </svg>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-8">

            @if(session('success'))
            <div class="mb-6 rounded-xl bg-emerald-50 border-l-4 border-emerald-500 p-4 text-emerald-800 shadow-sm flex justify-between items-center animate-fade-in-down">
                <div class="flex items-center gap-3">
                    <svg class="w-5 h-5 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <span class="font-bold text-sm">{{ session('success') }}</span>
                </div>
                <button onclick="this.parentElement.remove()" class="text-emerald-600 hover:text-emerald-800">&times;</button>
            </div>
            @endif

            <div class="bg-white rounded-xl shadow-lg border border-slate-200 overflow-hidden min-h-[400px]">

                <div class="px-6 py-4 bg-slate-50 border-b border-slate-200 flex justify-between items-center">
                    <div class="flex items-center gap-2">
                        <h3 class="font-bold text-slate-700">Antrian Menunggu Verifikasi</h3>
                    </div>
                    <span class="bg-[#0f172a] text-white border border-slate-700 px-3 py-1 rounded-lg text-xs font-bold shadow-sm">
                        Total: {{ $kunjungans->count() }}
                    </span>
                </div>

                @if($kunjungans->isEmpty())
                <div class="flex flex-col items-center justify-center py-20 text-center">
                    <div class="w-20 h-20 bg-slate-50 rounded-full flex items-center justify-center mb-4 border border-slate-100">
                        <svg class="w-10 h-10 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                    </div>
                    <h4 class="font-bold text-slate-700">Semua Bersih!</h4>
                    <p class="text-sm text-slate-500 mt-1">Tidak ada permohonan baru yang perlu diverifikasi.</p>
                </div>
                @else
                <div class="overflow-x-auto">
                    <table class="w-full text-sm text-left" id="dataTable">
                        <thead class="bg-slate-100 text-slate-500 uppercase text-xs font-bold">
                            <tr>
                                <th class="px-6 py-4">Tiket & Tanggal</th>
                                <th class="px-6 py-4">Data Pemohon</th>
                                <th class="px-6 py-4">Tujuan Kunjungan</th>
                                <th class="px-6 py-4 text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100">
                            @foreach($kunjungans as $item)
                            <tr class="hover:bg-blue-50/40 transition-colors group">
                                <td class="px-6 py-4">
                                    <div class="font-bold text-slate-800">{{ \Carbon\Carbon::parse($item->tanggal_kunjungan)->format('d M Y') }}</div>
                                    <div class="inline-block bg-slate-100 text-slate-500 text-[10px] font-mono font-bold px-2 py-0.5 rounded border border-slate-200 mt-1 group-hover:border-blue-200 group-hover:text-blue-600 transition">
                                        #REQ-{{ $item->id }}
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="font-bold text-slate-800 text-base">{{ $item->nama_pengunjung }}</div>
                                    <div class="text-xs text-slate-500 mt-1 flex items-center gap-1">
                                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                                        </svg>
                                        Membawa {{ $item->jumlah_pengikut }} Anggota
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-3">
                                        <div class="w-8 h-8 rounded bg-[#0f172a] text-white flex items-center justify-center font-bold text-xs">
                                            {{ substr($item->nama_tahanan, 0, 1) }}
                                        </div>
                                        <div>
                                            <div class="font-bold text-slate-800">{{ $item->nama_tahanan }}</div>
                                            <div class="text-xs text-blue-600 font-bold bg-blue-50 px-2 py-0.5 rounded inline-block mt-0.5">Kamar: {{ $item->nomor_kamar }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 text-center">
                                    <button onclick="openVerifyModal('{{ $item->id }}', '{{ $item->nama_pengunjung }}', '{{ $item->jumlah_pengikut }}', '{{ $item->keperluan }}', '{{ $item->nama_tahanan }}', '{{ $item->nomor_kamar }}', '{{ \Carbon\Carbon::parse($item->tanggal_kunjungan)->format('d F Y') }}', '{{ $item->foto_ktp ? asset('storage/'.$item->foto_ktp) : '' }}')"
                                        class="inline-flex items-center gap-2 px-5 py-2 bg-[#0f172a] hover:bg-[#F5C542] hover:text-[#0f172a] text-white text-xs font-bold rounded-lg shadow-md transition-all transform active:scale-95">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                        </svg>
                                        VERIFIKASI
                                    </button>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                @endif
            </div>

            <div class="text-center text-xs text-slate-400 mt-8 mb-4">
                &copy; {{ date('Y') }} Sistem Informasi Pelayanan Rutan - Kejaksaan Negeri Banjarmasin
            </div>
        </div>
    </div>

    <div id="verifyModal" class="fixed inset-0 z-50 hidden bg-slate-900/95 backdrop-blur-sm flex items-center justify-center p-4 transition-opacity">
        <div class="bg-white rounded-xl shadow-2xl w-full max-w-5xl overflow-hidden flex flex-col h-[85vh] animate-scale-up">

            <div class="bg-[#0f172a] px-6 py-4 flex justify-between items-center border-b border-[#F5C542]">
                <div class="flex items-center gap-3">
                    <img src="{{ asset('assets/logo-kejari.png') }}" class="h-8 w-8 bg-white/10 rounded-full p-1">
                    <h2 class="text-lg font-serif font-bold text-white tracking-wide">Formulir Verifikasi Data</h2>
                </div>
                <button onclick="closeVerifyModal()" class="text-slate-400 hover:text-white hover:bg-white/10 rounded-full p-1 transition">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>

            <div class="flex-1 overflow-y-auto flex flex-col md:flex-row bg-white">

                <div class="w-full md:w-5/12 bg-slate-100 p-6 flex flex-col items-center justify-center border-r border-slate-200">
                    <div class="w-full max-w-sm">
                        <div class="flex justify-between items-center mb-2">
                            <span class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">Lampiran KTP Asli</span>
                            <span class="text-[10px] bg-white border border-slate-200 px-2 py-0.5 rounded text-slate-500">Wajib Cek</span>
                        </div>
                        <div class="relative bg-white rounded-lg shadow-sm border border-slate-300 overflow-hidden group cursor-zoom-in min-h-[200px] flex items-center justify-center">
                            <img id="modalKtpImage" src="" class="max-w-full max-h-[400px] object-contain transition-transform duration-300 group-hover:scale-105" alt="KTP">
                            <div id="noKtpMessage" class="hidden flex flex-col items-center text-slate-400 py-10">
                                <svg class="w-12 h-12 mb-2 opacity-30" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                </svg>
                                <span class="text-xs font-bold">Tidak Ada Foto Dilampirkan</span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="w-full md:w-7/12 p-8 overflow-y-auto">
                    <div class="space-y-8">

                        <div>
                            <h3 class="text-xs font-bold text-[#F5C542] bg-[#0f172a] px-2 py-1 inline-block rounded mb-4 uppercase tracking-widest">A. Data Pengunjung</h3>
                            <div class="grid grid-cols-2 gap-6">
                                <div class="bg-slate-50 p-3 rounded-lg border border-slate-100">
                                    <label class="text-[10px] font-bold text-slate-400 uppercase block mb-1">Nama Lengkap</label>
                                    <div id="modalVisitorName" class="text-lg font-bold text-slate-800">...</div>
                                </div>
                                <div class="bg-slate-50 p-3 rounded-lg border border-slate-100">
                                    <label class="text-[10px] font-bold text-slate-400 uppercase block mb-1">Jumlah Pengikut</label>
                                    <div id="modalVisitorCount" class="text-lg font-bold text-slate-800">...</div>
                                </div>
                            </div>
                        </div>

                        <div>
                            <h3 class="text-xs font-bold text-[#F5C542] bg-[#0f172a] px-2 py-1 inline-block rounded mb-4 uppercase tracking-widest">B. Tujuan Kunjungan</h3>
                            <div class="grid grid-cols-2 gap-6 mb-4">
                                <div class="bg-slate-50 p-3 rounded-lg border border-slate-100">
                                    <label class="text-[10px] font-bold text-slate-400 uppercase block mb-1">Nama Tahanan</label>
                                    <div id="modalInmateName" class="text-lg font-bold text-slate-800">...</div>
                                </div>
                                <div class="bg-slate-50 p-3 rounded-lg border border-slate-100">
                                    <label class="text-[10px] font-bold text-slate-400 uppercase block mb-1">Lokasi Kamar</label>
                                    <div id="modalInmateRoom" class="text-lg font-bold text-slate-800">...</div>
                                </div>
                            </div>
                            <div>
                                <label class="text-[10px] font-bold text-slate-400 uppercase block mb-2">Keperluan</label>
                                <div id="modalPurpose" class="p-4 bg-yellow-50 text-slate-700 italic rounded-lg border border-yellow-100 text-sm border-l-4 border-l-[#F5C542]">...</div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>

            <div class="bg-white p-5 border-t border-slate-200 flex justify-end gap-3 z-10 shadow-[0_-5px_15px_rgba(0,0,0,0.05)]">
                <button onclick="document.getElementById('rejectModal').classList.remove('hidden')" class="px-5 py-3 border-2 border-red-100 text-red-600 font-bold rounded-lg text-sm hover:bg-red-50 hover:border-red-200 transition flex items-center gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                    TOLAK BERKAS
                </button>

                <form id="modalApproveForm" action="" method="POST">
                    @csrf @method('PATCH')
                    <input type="hidden" name="status" value="disetujui">
                    <button type="submit" class="px-8 py-3 bg-[#0f172a] text-white font-bold rounded-lg text-sm hover:bg-[#F5C542] hover:text-[#0f172a] transition shadow-lg flex items-center gap-2" onclick="return confirm('Apakah data sudah diverifikasi dan sesuai?')">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                        DATA VALID & SETUJUI
                    </button>
                </form>
            </div>
        </div>
    </div>

    <div id="rejectModal" class="fixed inset-0 z-[60] hidden bg-black/80 flex items-center justify-center p-4">
        <div class="bg-white rounded-xl shadow-2xl w-full max-w-sm p-6 border-t-4 border-red-500 animate-scale-up">
            <div class="flex items-center gap-3 mb-4 text-red-600">
                <div class="bg-red-100 p-2 rounded-full"><svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                    </svg></div>
                <h3 class="font-bold text-slate-800 text-lg">Tolak Permohonan?</h3>
            </div>

            <form id="rejectForm" action="" method="POST">
                @csrf @method('PATCH')
                <input type="hidden" name="status" value="ditolak">
                <label class="text-xs font-bold text-slate-500 uppercase block mb-2">Alasan Penolakan</label>
                <textarea name="keterangan_petugas" class="w-full border-slate-300 rounded-lg text-sm mb-4 focus:ring-red-500 focus:border-red-500 min-h-[100px]" placeholder="Contoh: KTP Buram, Salah Kamar, dll..." required></textarea>

                <div class="flex justify-end gap-2">
                    <button type="button" onclick="document.getElementById('rejectModal').classList.add('hidden')" class="px-4 py-2 text-sm font-bold text-slate-500 hover:bg-slate-100 rounded-lg transition">Batal</button>
                    <button type="submit" class="px-4 py-2 text-sm font-bold bg-red-600 hover:bg-red-700 text-white rounded-lg shadow transition">Konfirmasi Tolak</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        // 1. Script Search Manual Table
        function searchTable() {
            let input = document.getElementById("searchInput");
            let filter = input.value.toUpperCase();
            let table = document.getElementById("dataTable");
            let tr = table.getElementsByTagName("tr");
            for (let i = 1; i < tr.length; i++) {
                let td = tr[i].getElementsByTagName("td")[1]; // Kolom Nama (Index 1)
                if (td) {
                    let txtValue = td.textContent || td.innerText;
                    tr[i].style.display = txtValue.toUpperCase().indexOf(filter) > -1 ? "" : "none";
                }
            }
        }

        // 2. Script Buka Modal Verifikasi
        function openVerifyModal(id, vName, vCount, vPurpose, iName, iRoom, date, ktpSrc) {
            // Isi Text
            document.getElementById('modalVisitorName').innerText = vName;
            document.getElementById('modalVisitorCount').innerText = vCount + " Orang";
            document.getElementById('modalPurpose').innerText = '"' + vPurpose + '"';
            document.getElementById('modalInmateName').innerText = iName;
            document.getElementById('modalInmateRoom').innerText = iRoom;

            // Isi Foto
            let img = document.getElementById('modalKtpImage');
            let noImg = document.getElementById('noKtpMessage');

            if (ktpSrc) {
                img.src = ktpSrc;
                img.classList.remove('hidden');
                noImg.classList.add('hidden');
            } else {
                img.classList.add('hidden');
                noImg.classList.remove('hidden');
            }

            // Set URL Form
            let url = "{{ route('petugas.updateStatus', ':id') }}".replace(':id', id);
            document.getElementById('modalApproveForm').action = url;
            document.getElementById('rejectForm').action = url;

            // Tampilkan Modal
            document.getElementById('verifyModal').classList.remove('hidden');
        }

        // 3. Script Tutup Modal
        function closeVerifyModal() {
            document.getElementById('verifyModal').classList.add('hidden');
        }
    </script>
</x-app-layout>