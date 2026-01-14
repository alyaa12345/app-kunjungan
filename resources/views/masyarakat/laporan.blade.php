<x-app-layout>
    <div class="min-h-screen bg-[#F8FAFC] font-sans pb-20">

        <div class="print:hidden">

            <div class="bg-[#0f172a] shadow-md relative overflow-hidden py-10 px-6">
                <div class="absolute inset-0 opacity-10 bg-[url('https://www.transparenttextures.com/patterns/cubes.png')]"></div>

                <div class="max-w-6xl mx-auto flex flex-col md:flex-row justify-between items-center relative z-10 gap-6">
                    <div>
                        <span class="text-[#F5C542] font-bold tracking-widest text-xs uppercase mb-1 block">Area Masyarakat</span>
                        <h1 class="text-2xl md:text-3xl font-bold text-white tracking-tight">Jadwal & Tiket Kunjungan</h1>
                        <p class="text-slate-400 text-sm mt-1">Kelola tiket kunjungan Anda atau cetak laporan untuk arsip.</p>
                    </div>

                    <button onclick="window.print()" class="group bg-[#F5C542] hover:bg-yellow-400 text-[#0f172a] px-5 py-2.5 rounded-xl font-bold shadow-lg shadow-yellow-500/20 transition-all flex items-center gap-2 text-sm">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path>
                        </svg>
                        <span>Cetak Laporan</span>
                    </button>
                </div>
            </div>

            <div class="max-w-6xl mx-auto px-6 mt-8 relative z-20">
                <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-6">

                    @forelse($data as $item)
                    <div class="bg-white rounded-2xl shadow-md border border-slate-100 overflow-hidden hover:shadow-xl hover:-translate-y-1 transition-all duration-300 group flex flex-col h-full">

                        <div class="p-5 border-b border-slate-50 flex justify-between items-start bg-gradient-to-br from-white to-slate-50">
                            <div class="flex items-center gap-3">
                                <div class="bg-blue-100 text-blue-600 p-2.5 rounded-xl shrink-0">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                    </svg>
                                </div>
                                <div>
                                    <p class="text-[10px] text-slate-400 font-bold uppercase tracking-wider">Tanggal Kunjungan</p>
                                    <p class="font-bold text-slate-800 text-lg whitespace-nowrap">{{ \Carbon\Carbon::parse($item->tanggal_kunjungan)->format('d M Y') }}</p>
                                </div>
                            </div>

                            <div class="shrink-0">
                                @if($item->status == 'disetujui')
                                <span class="bg-emerald-100 text-emerald-700 text-[10px] font-bold px-2 py-1 rounded-md border border-emerald-200 uppercase">Disetujui</span>
                                @elseif($item->status == 'ditolak')
                                <span class="bg-red-100 text-red-700 text-[10px] font-bold px-2 py-1 rounded-md border border-red-200 uppercase">Ditolak</span>
                                @else
                                <span class="bg-amber-100 text-amber-700 text-[10px] font-bold px-2 py-1 rounded-md border border-amber-200 uppercase animate-pulse">Proses</span>
                                @endif
                            </div>
                        </div>

                        <div class="p-5 space-y-4 flex-grow">
                            <div class="flex justify-between items-center">
                                <div class="overflow-hidden">
                                    <p class="text-[10px] text-slate-400 uppercase font-bold mb-1">Tahanan Tujuan</p>
                                    <div class="flex items-center gap-2">
                                        <div class="w-8 h-8 rounded-full bg-slate-100 flex items-center justify-center font-bold text-slate-500 text-xs border border-slate-200 shrink-0">
                                            {{ substr($item->nama_tahanan, 0, 1) }}
                                        </div>
                                        <p class="font-bold text-slate-700 uppercase text-sm truncate">{{ $item->nama_tahanan }}</p>
                                    </div>
                                </div>
                                <div class="text-right shrink-0">
                                    <p class="text-[10px] text-slate-400 uppercase font-bold mb-1">ID Tiket</p>
                                    <p class="font-mono text-sm font-bold text-slate-600 bg-slate-50 px-2 py-1 rounded border border-slate-200">REQ-{{ $item->id }}</p>
                                </div>
                            </div>

                            <div class="bg-slate-50 rounded-xl p-3 border border-slate-100 text-xs space-y-2">
                                <div class="flex justify-between">
                                    <span class="text-slate-500 font-medium">Pengikut</span>
                                    <span class="font-bold text-slate-700">{{ $item->jumlah_pengikut }} Orang</span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-slate-500 font-medium">Lokasi Sel</span>
                                    <span class="font-bold text-blue-600 bg-blue-50 px-1.5 rounded">{{ $item->nomor_kamar ?? '-' }}</span>
                                </div>
                            </div>

                            <div class="pt-2 border-t border-dashed border-slate-200 mt-2">
                                <div class="flex items-center justify-between">
                                    <span class="text-[10px] text-slate-400 font-bold uppercase">Verifikator:</span>
                                    <span class="text-xs font-bold text-slate-700">
                                        {{ $item->petugas->name ?? '-' }}
                                    </span>
                                </div>
                            </div>
                        </div>

                        <div class="px-5 py-4 bg-slate-50 border-t border-slate-100 mt-auto">
                            @if($item->status == 'disetujui')
                            <button onclick="openTicketModal('{{ $item->id }}', '{{ $item->nama_tahanan }}', '{{ \Carbon\Carbon::parse($item->tanggal_kunjungan)->format('d M Y') }}', '{{ \Carbon\Carbon::parse($item->created_at)->format('H:i') }}', '{{ $item->nomor_kamar ?? '-' }}', '{{ $item->jumlah_pengikut }}')"
                                class="w-full py-2.5 bg-white border border-blue-200 text-blue-600 hover:bg-blue-600 hover:text-white rounded-lg text-xs font-bold transition-all shadow-sm flex items-center justify-center gap-2 uppercase tracking-wider">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                </svg>
                                Lihat E-Tiket
                            </button>
                            @else
                            <div class="w-full py-2.5 bg-slate-100 text-slate-400 rounded-lg text-xs font-bold text-center uppercase tracking-wider flex items-center justify-center gap-2 cursor-not-allowed">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                Menunggu Verifikasi
                            </div>
                            @endif
                        </div>
                    </div>
                    @empty
                    <div class="col-span-1 md:col-span-2 xl:col-span-3 text-center py-20 bg-white rounded-2xl border border-dashed border-slate-300">
                        <div class="inline-block p-4 rounded-full bg-slate-50 mb-3">
                            <svg class="w-12 h-12 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                            </svg>
                        </div>
                        <h3 class="text-lg font-bold text-slate-700">Tidak Ada Jadwal</h3>
                        <p class="text-slate-500 text-sm mt-1">Anda belum membuat pengajuan kunjungan.</p>
                    </div>
                    @endforelse
                </div>
            </div>
        </div>

        <div id="ticketModal" class="fixed inset-0 z-50 hidden" aria-labelledby="modal-title" role="dialog" aria-modal="true">
            <div class="fixed inset-0 bg-slate-900/80 backdrop-blur-sm transition-opacity" onclick="closeTicketModal()"></div>

            <div class="fixed inset-0 z-10 overflow-y-auto">
                <div class="flex min-h-full items-center justify-center p-4 text-center sm:p-0">

                    <div class="relative transform overflow-hidden rounded-3xl bg-white text-left shadow-2xl transition-all sm:my-8 sm:w-full sm:max-w-sm">

                        <button onclick="closeTicketModal()" class="absolute top-4 right-4 text-white hover:text-yellow-400 z-20 transition-colors">
                            <svg class="w-8 h-8 drop-shadow-md" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                        </button>

                        <div class="bg-[#0f172a] p-8 text-white relative overflow-hidden">
                            <img src="{{ asset('assets/logo-kejari.png') }}" class="absolute -right-6 -top-6 w-40 h-40 opacity-10 rotate-12">
                            <div class="relative z-10">
                                <p class="text-[10px] font-bold tracking-[0.2em] text-[#F5C542] uppercase">Kejaksaan Negeri</p>
                                <h3 class="text-3xl font-black tracking-tighter mt-1">VISITOR PASS</h3>

                                <div class="mt-8">
                                    <p class="text-[10px] text-slate-400 uppercase tracking-widest mb-1">Pengunjung Utama</p>
                                    <h2 class="text-2xl font-bold uppercase text-white truncate leading-tight">{{ Auth::user()->name }}</h2>
                                </div>
                            </div>
                        </div>

                        <div class="p-8 bg-white relative">
                            <div class="absolute -left-4 top-[-16px] w-8 h-8 bg-slate-900/80 rounded-full z-10"></div>
                            <div class="absolute -right-4 top-[-16px] w-8 h-8 bg-slate-900/80 rounded-full z-10"></div>

                            <div class="grid grid-cols-2 gap-8 mb-6 mt-2">
                                <div>
                                    <p class="text-[10px] text-slate-400 uppercase tracking-widest font-bold">Tujuan</p>
                                    <p id="modalTahanan" class="text-base font-bold text-slate-800 uppercase truncate mt-1">...</p>
                                </div>
                                <div class="text-right">
                                    <p class="text-[10px] text-slate-400 uppercase tracking-widest font-bold">Rombongan</p>
                                    <p id="modalJml" class="text-base font-bold text-slate-800 mt-1">...</p>
                                </div>
                            </div>

                            <div class="grid grid-cols-2 gap-8 items-end">
                                <div>
                                    <p class="text-[10px] text-slate-400 uppercase tracking-widest font-bold">Tanggal</p>
                                    <p id="modalTgl" class="text-base font-bold text-slate-800 mt-1">...</p>
                                    <p id="modalJam" class="text-xs text-slate-500">...</p>
                                </div>
                                <div class="text-right">
                                    <p class="text-[10px] text-slate-400 uppercase tracking-widest font-bold mb-1">Blok/Kamar</p>
                                    <span id="modalKamar" class="bg-blue-100 text-blue-700 px-3 py-1.5 rounded-lg text-sm font-bold">...</span>
                                </div>
                            </div>
                        </div>

                        <div class="bg-slate-50 p-8 pt-0 text-center pb-10 border-t border-dashed border-slate-200">
                            <div class="h-12 w-full bg-[url('https://upload.wikimedia.org/wikipedia/commons/thumb/d/d0/Code_39_243.svg/1200px-Code_39_243.svg.png')] bg-repeat-x bg-contain opacity-40 mt-8 mix-blend-darken"></div>
                            <p id="modalId" class="text-[10px] text-slate-400 font-mono mt-3 uppercase tracking-widest">REQ-...</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="hidden print:block bg-white text-black p-0 m-0 w-full h-full">

            <div class="flex items-center justify-center border-b-4 border-double border-black pb-4 mb-8 relative">
                <div class="absolute left-0 top-0">
                    <img src="{{ asset('assets/logo-kejari.png') }}" class="h-24 w-auto object-contain">
                </div>
                <div class="text-center w-full px-24">
                    <h3 class="text-lg font-bold uppercase tracking-wide">KEJAKSAAN REPUBLIK INDONESIA</h3>
                    <h2 class="text-2xl font-black uppercase tracking-wider scale-y-110 text-[#166534] print-color-force">KEJAKSAAN NEGERI BANJARMASIN</h2>
                    <p class="text-sm italic mt-1">Jl. Brigjen H. Hasan Basri No. 4, Pangeran, Kec. Banjarmasin Utara, Kota Banjarmasin</p>
                    <p class="text-xs">Telp: (0511) 330XXXX | Email: kn.banjarmasin@kejaksaan.go.id</p>
                </div>
            </div>

            <div class="text-center mb-8">
                <h1 class="text-lg font-bold uppercase underline decoration-1 underline-offset-2">LAPORAN REKAPITULASI KUNJUNGAN</h1>
                <p class="text-sm mt-1 uppercase font-bold">PELAPOR: {{ Auth::user()->name }}</p>
            </div>

            <table class="w-full text-sm border-collapse border border-black mb-8">
                <thead>
                    <tr class="bg-gray-200 text-black font-bold uppercase text-xs text-center print-color-force">
                        <th class="border border-black px-2 py-2 w-10">No</th>
                        <th class="border border-black px-2 py-2 w-24">Tanggal</th>
                        <th class="border border-black px-2 py-2 w-20">ID Tiket</th>
                        <th class="border border-black px-2 py-2">Nama Tahanan</th>
                        <th class="border border-black px-2 py-2 w-16">Jml</th>
                        <th class="border border-black px-2 py-2 w-20">Status</th>
                        <th class="border border-black px-2 py-2">Petugas Verifikator</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($data as $index => $item)
                    <tr>
                        <td class="border border-black px-2 py-2 text-center">{{ $index + 1 }}</td>
                        <td class="border border-black px-2 py-2 text-center">{{ \Carbon\Carbon::parse($item->tanggal_kunjungan)->format('d/m/Y') }}</td>
                        <td class="border border-black px-2 py-2 text-center font-mono text-xs">REQ-{{ $item->id }}</td>
                        <td class="border border-black px-2 py-2 uppercase font-bold">{{ $item->nama_tahanan }}</td>
                        <td class="border border-black px-2 py-2 text-center">{{ $item->jumlah_pengikut }}</td>
                        <td class="border border-black px-2 py-2 text-center font-bold text-[10px] uppercase">
                            {{ $item->status }}
                        </td>
                        <td class="border border-black px-2 py-2 text-center italic">
                            {{ $item->petugas->name ?? '-' }}
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>

            <div class="flex justify-end mt-16 px-4 break-inside-avoid">
                <div class="text-center w-64">
                    <p class="text-sm">Banjarmasin, {{ \Carbon\Carbon::now()->translatedFormat('d F Y') }}</p>
                    <p class="text-sm mb-20">Pemohon / Pelapor,</p>
                    <p class="text-sm font-bold underline uppercase">{{ Auth::user()->name }}</p>
                    <p class="text-sm">Masyarakat</p>
                </div>
            </div>
        </div>
    </div>

    <script>
        function openTicketModal(id, tahanan, tgl, jam, kamar, jml) {
            document.getElementById('modalId').innerText = 'REQ-' + id;
            document.getElementById('modalTahanan').innerText = tahanan;
            document.getElementById('modalTgl').innerText = tgl;
            document.getElementById('modalJam').innerText = 'Dibuat: ' + jam + ' WITA';
            document.getElementById('modalKamar').innerText = kamar;
            document.getElementById('modalJml').innerText = jml + ' Orang';
            document.getElementById('ticketModal').classList.remove('hidden');
        }

        function closeTicketModal() {
            document.getElementById('ticketModal').classList.add('hidden');
        }
    </script>

    <style>
        @media print {
            @page {
                margin: 0;
                size: A4 portrait;
            }

            body {
                background: white !important;
                font-family: 'Times New Roman', serif !important;
                color: black !important;
                padding: 2.5cm;
            }

            nav,
            header,
            footer,
            button,
            .print\:hidden {
                display: none !important;
            }

            table {
                width: 100%;
                border: 1px solid black;
                border-collapse: collapse;
            }

            th,
            td {
                border: 1px solid black !important;
                padding: 5px;
            }

            img {
                filter: none !important;
            }

            .print-color-force {
                color: #166534 !important;
                -webkit-print-color-adjust: exact;
            }
        }
    </style>
</x-app-layout>