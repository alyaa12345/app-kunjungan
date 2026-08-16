<x-app-layout>
    <script src="https://unpkg.com/html5-qrcode" type="text/javascript"></script>

    <x-slot name="header">
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4 bg-white pt-2 pb-4">
            <div>
                <span class="bg-slate-900 text-white text-[10px] font-bold px-2.5 py-1 rounded-md tracking-widest uppercase shadow-sm">
                    Area Pos Penjagaan
                </span>
                <h2 class="font-bold text-2xl text-slate-900 leading-tight mt-2">
                    Gate Check-In Pengunjung & Barang
                </h2>
                <p class="text-sm text-slate-500 font-medium mt-1">
                    Scan QR Code dari surat izin untuk memverifikasi Kunjungan Tatap Muka atau Titipan Barang.
                </p>
            </div>
        </div>
    </x-slot>

    <div class="py-8 bg-slate-50 min-h-screen relative">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            @if(session('success'))
            <div class="bg-emerald-50 border-l-4 border-emerald-500 p-5 rounded-r-xl shadow-sm mb-6 flex items-center gap-4">
                <div class="w-10 h-10 bg-emerald-500 rounded-full flex items-center justify-center text-white shrink-0 shadow-md">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path>
                    </svg>
                </div>
                <h3 class="font-black text-emerald-800 text-lg">{{ session('success') }}</h3>
            </div>
            @endif

            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">

                <div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden flex flex-col">
                    <div class="p-5 border-b border-slate-100 bg-slate-800 text-white flex items-center justify-between">
                        <h3 class="font-bold flex items-center gap-2">
                            <svg class="w-5 h-5 text-[#F5C542]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h4a1 1 0 010 2H5v3a1 1 0 01-2 0V4zm14-1a1 1 0 011 1v3a1 1 0 01-2 0V5h-3a1 1 0 010-2h4zM3 20a1 1 0 011-1h4a1 1 0 110 2H5v-3a1 1 0 01-2 0v4zm14 1a1 1 0 01-1-1v-3a1 1 0 112 0v4a1 1 0 01-1 1h-4z"></path>
                            </svg>
                            Kamera Scanner QR
                        </h3>
                    </div>
                    <div class="p-4 flex-1 flex flex-col items-center justify-center bg-slate-50 relative">
                        <div id="reader" class="w-full max-w-sm mx-auto overflow-hidden rounded-xl shadow-inner border-2 border-dashed border-slate-300 bg-white"></div>
                        <p class="text-xs text-slate-500 mt-4 font-medium text-center">Arahkan QR Code dari surat pengunjung atau barang ke kamera.</p>
                    </div>
                </div>

                <div class="space-y-6">
                    <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-200">
                        <h3 class="text-sm font-extrabold text-slate-800 uppercase tracking-wide mb-4">Input ID Manual (Jika Kamera Rusak)</h3>
                        <form action="{{ route('lapas.gate-check') }}" method="GET" class="flex gap-3">
                            <input type="text" name="tiket_id" class="w-full text-sm border-slate-200 rounded-xl bg-slate-50 focus:bg-white focus:ring-1 focus:ring-[#F5C542] focus:border-[#F5C542] font-bold" placeholder="Contoh: 12">
                            <button type="submit" class="bg-[#0f172a] hover:bg-slate-800 text-[#F5C542] px-6 py-2 rounded-xl font-bold transition-all shadow-sm">Cek</button>
                        </form>
                    </div>

                    <div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden min-h-[300px]">
                        <div class="p-5 border-b border-slate-100 bg-white flex justify-between items-center">
                            <h3 class="text-sm font-extrabold text-slate-800 uppercase tracking-wide">Hasil Verifikasi Kunjungan</h3>
                            @if(isset($tipe_tiket))
                            <span class="bg-indigo-100 text-indigo-800 text-[10px] font-bold px-2 py-0.5 rounded-full uppercase border border-indigo-200">{{ $tipe_tiket }}</span>
                            @endif
                        </div>

                        <div class="p-6">
                            @if(request('tiket_id') && !$visitor)
                            <div class="bg-red-50 border border-red-200 rounded-2xl p-6 text-center">
                                <div class="w-16 h-16 bg-red-100 text-red-500 rounded-full flex items-center justify-center mx-auto mb-4">
                                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                                    </svg>
                                </div>
                                <h4 class="font-black text-red-700 text-lg mb-2">Akses Ditolak!</h4>
                                <p class="text-sm text-red-600 font-medium">{{ $message }}</p>
                                <a href="{{ route('lapas.gate-check') }}" class="inline-block mt-4 text-xs font-bold text-slate-500 hover:text-slate-800 underline">Reset Scanner</a>
                            </div>

                            @elseif(isset($visitor) && $visitor)
                            <div class="bg-blue-50 border border-blue-200 rounded-2xl p-6 relative overflow-hidden">
                                <svg class="absolute top-0 right-0 w-32 h-32 text-blue-100 opacity-50 transform translate-x-8 -translate-y-8" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                                </svg>

                                <h4 class="font-black text-blue-800 text-lg mb-4 relative z-10">Data Sesuai & Valid!</h4>

                                <div class="space-y-3 relative z-10">
                                    <div>
                                        <div class="text-[10px] uppercase font-bold text-blue-500 tracking-wider">
                                            {{ $tipe_tiket == 'KUNJUNGAN' ? 'Nama Pengunjung' : 'Nama Pengirim Barang' }}
                                        </div>
                                        <div class="font-bold text-slate-800 text-lg">
                                            {{ $tipe_tiket == 'KUNJUNGAN' ? $visitor->nama_pengunjung : $visitor->user->name }}
                                        </div>
                                    </div>
                                    <div class="grid grid-cols-2 gap-4">
                                        <div>
                                            <div class="text-[10px] uppercase font-bold text-blue-500 tracking-wider">Warga Binaan</div>
                                            <div class="font-bold text-slate-700">{{ $visitor->nama_tahanan }}</div>
                                        </div>
                                        <div>
                                            <div class="text-[10px] uppercase font-bold text-blue-500 tracking-wider">
                                                {{ $tipe_tiket == 'KUNJUNGAN' ? 'Sesi Kunjungan' : 'Jenis Barang' }}
                                            </div>
                                            <div class="font-bold text-slate-700">
                                                {{ $tipe_tiket == 'KUNJUNGAN' ? $visitor->jam_kunjungan : $visitor->jenis_titipan }}
                                            </div>
                                        </div>
                                    </div>

                                    <form action="{{ route('lapas.gate.proses') }}" method="POST" class="pt-4" onsubmit="return confirm('Proses Check-in ini ke dalam Lapas?');">
                                        @csrf
                                        <input type="hidden" name="id" value="{{ $visitor->id }}">
                                        <input type="hidden" name="tipe_tiket" value="{{ $tipe_tiket }}">
                                        <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 rounded-xl transition-all shadow-md flex items-center justify-center gap-2">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                            </svg>
                                            {{ $tipe_tiket == 'KUNJUNGAN' ? 'Check-In Pengunjung' : 'Terima Titipan Barang' }}
                                        </button>
                                    </form>
                                </div>
                            </div>
                            @else
                            <div class="flex flex-col items-center justify-center text-center h-full text-slate-400 opacity-60">
                                <svg class="w-16 h-16 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm12 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z"></path>
                                </svg>
                                <p class="font-medium">Menunggu pindaian QR Code...</p>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            function onScanSuccess(decodedText, decodedResult) {
                html5QrcodeScanner.clear();
                window.location.href = "?tiket_id=" + encodeURIComponent(decodedText);
            }

            let html5QrcodeScanner = new Html5QrcodeScanner(
                "reader", {
                    fps: 10,
                    qrbox: {
                        width: 250,
                        height: 250
                    }
                },
                false
            );
            html5QrcodeScanner.render(onScanSuccess);
        });
    </script>

    <style>
        #reader {
            border: none !important;
        }

        #reader__dashboard_section_csr span {
            display: none !important;
        }

        #reader__dashboard_section_csr button {
            background: #0f172a;
            color: #F5C542;
            border: none;
            padding: 8px 16px;
            border-radius: 8px;
            font-weight: bold;
            cursor: pointer;
            margin-top: 10px;
        }
    </style>
</x-app-layout>