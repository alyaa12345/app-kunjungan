<x-app-layout>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/qrcodejs/1.0.0/qrcode.min.js"></script>

    <div class="min-h-screen bg-[#0f172a] py-12 px-4 sm:px-6 lg:px-8 flex items-center justify-center relative overflow-hidden">
        <div class="absolute top-0 left-0 w-full h-full overflow-hidden z-0 opacity-20">
            <div class="absolute top-[-10%] right-[-10%] w-96 h-96 bg-blue-500 rounded-full blur-[100px]"></div>
            <div class="absolute bottom-[-10%] left-[-10%] w-96 h-96 bg-purple-500 rounded-full blur-[100px]"></div>
        </div>

        <div class="max-w-4xl w-full relative z-10">
            <div class="mb-6 text-center md:text-left">
                <a href="{{ route('masyarakat.index') }}" class="text-slate-400 hover:text-white flex items-center gap-2 transition justify-center md:justify-start">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                    </svg>
                    Kembali ke Beranda
                </a>
            </div>

            <div class="bg-white rounded-3xl overflow-hidden shadow-2xl flex flex-col md:flex-row">

                <div class="flex-1 p-8 md:p-10 relative">
                    <div class="flex justify-between items-start mb-8 border-b border-gray-100 pb-6">
                        <div class="flex items-center gap-4">
                            <img src="{{ asset('assets/logo-kejari.png') }}" class="w-12 h-12 object-contain">
                            <div>
                                <h2 class="text-xl font-bold text-slate-800">E-PASS KUNJUNGAN</h2>
                                <p class="text-xs text-slate-500 uppercase tracking-widest">Kejaksaan Negeri Banjarmasin</p>
                            </div>
                        </div>
                        <div class="text-right">
                            <p class="text-[10px] text-slate-400 font-bold uppercase">ID Permohonan</p>
                            <p class="text-2xl font-mono font-bold text-[#F5C542]">#REQ-{{ $kunjungan->id }}</p>
                        </div>
                    </div>

                    <div class="grid grid-cols-2 gap-8 mb-8">
                        <div>
                            <p class="text-[10px] text-slate-400 font-bold uppercase mb-1">Pengunjung (Pemohon)</p>
                            <p class="text-lg font-bold text-slate-800">{{ $kunjungan->nama_pengunjung }}</p>
                            <p class="text-xs text-slate-500 mt-1">+ {{ $kunjungan->jumlah_pengikut }} Anggota Keluarga</p>
                        </div>
                        <div>
                            <p class="text-[10px] text-slate-400 font-bold uppercase mb-1">Mengunjungi Tahanan</p>
                            <p class="text-lg font-bold text-slate-800">{{ $kunjungan->nama_tahanan }}</p>
                            <span class="inline-block bg-slate-100 text-slate-600 text-[10px] px-2 py-1 rounded mt-1 font-bold">Kamar: {{ $kunjungan->nomor_kamar }}</span>
                        </div>
                    </div>

                    <div class="grid grid-cols-2 gap-8">
                        <div>
                            <p class="text-[10px] text-slate-400 font-bold uppercase mb-1">Tanggal</p>
                            <p class="text-base font-bold text-slate-800">{{ \Carbon\Carbon::parse($kunjungan->tanggal_kunjungan)->translatedFormat('d F Y') }}</p>
                        </div>
                        <div>
                            <p class="text-[10px] text-slate-400 font-bold uppercase mb-1">Sesi Waktu</p>
                            <p class="text-base font-bold text-slate-800">{{ $kunjungan->jam_kunjungan }}</p>
                        </div>
                    </div>

                    <div class="mt-8 pt-6 border-t border-gray-100">
                        @if($kunjungan->status == 'disetujui')
                        <div class="flex items-center gap-3 text-emerald-600 bg-emerald-50 p-4 rounded-xl border border-emerald-100">
                            <div class="p-2 bg-white rounded-full shadow-sm"><svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                </svg></div>
                            <div>
                                <p class="font-bold text-sm">DISETUJUI</p>
                                <p class="text-xs opacity-80">Silakan scan QR Code di loket petugas.</p>
                            </div>
                        </div>
                        @elseif($kunjungan->status == 'ditolak')
                        <div class="flex items-center gap-3 text-red-600 bg-red-50 p-4 rounded-xl border border-red-100">
                            <div class="p-2 bg-white rounded-full shadow-sm"><svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                </svg></div>
                            <div>
                                <p class="font-bold text-sm">DITOLAK</p>
                                <p class="text-xs opacity-80">{{ $kunjungan->keterangan_petugas ?? 'Data tidak valid' }}</p>
                            </div>
                        </div>
                        @else
                        <div class="flex items-center gap-3 text-yellow-600 bg-yellow-50 p-4 rounded-xl border border-yellow-100">
                            <div class="p-2 bg-white rounded-full shadow-sm animate-pulse"><svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg></div>
                            <div>
                                <p class="font-bold text-sm">MENUNGGU VERIFIKASI</p>
                                <p class="text-xs opacity-80">Mohon tunggu petugas memproses data Anda.</p>
                            </div>
                        </div>
                        @endif
                    </div>
                </div>

                <div class="relative bg-[#0f172a] md:w-80 p-8 flex flex-col items-center justify-center text-white border-t md:border-t-0 md:border-l-4 border-dashed border-white/20">
                    <div class="absolute -top-3 md:top-auto md:-left-3 md:bottom-1/2 w-6 h-6 bg-[#0f172a] md:bg-[#F1F5F9] rounded-full"></div>
                    <div class="absolute -bottom-3 md:bottom-auto md:top-1/2 md:-left-3 w-6 h-6 bg-[#0f172a] md:bg-[#F1F5F9] rounded-full"></div>

                    <div class="text-center w-full">
                        <p class="text-xs font-bold text-[#F5C542] uppercase tracking-[0.2em] mb-6">SCAN HERE</p>

                        <div class="bg-white p-4 rounded-xl inline-block shadow-2xl mb-4">
                            @if($kunjungan->status == 'disetujui')
                            <div id="qrcode-canvas"></div>
                            @else
                            <div class="w-[128px] h-[128px] bg-gray-100 flex items-center justify-center rounded text-gray-400 text-xs text-center p-2">
                                BELUM<br>AKTIF
                            </div>
                            @endif
                        </div>

                        <p class="font-mono text-xl font-bold tracking-widest text-white/90">REQ-{{ $kunjungan->id }}</p>

                        @if($kunjungan->status == 'disetujui')
                        <button onclick="window.print()" class="mt-8 px-6 py-2 border border-white/30 rounded-full text-xs font-bold hover:bg-white hover:text-[#0f172a] transition w-full">
                            CETAK TIKET
                        </button>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    @if($kunjungan->status == 'disetujui')
    <script type="text/javascript">
        // Kita buat isinya simple string "REQ-{ID}" agar scanner cepat membacanya
        var qrData = "REQ-{{ $kunjungan->id }}";

        new QRCode(document.getElementById("qrcode-canvas"), {
            text: qrData,
            width: 150,
            height: 150,
            colorDark: "#000000",
            colorLight: "#ffffff",
            correctLevel: QRCode.CorrectLevel.H
        });
    </script>
    @endif
</x-app-layout>