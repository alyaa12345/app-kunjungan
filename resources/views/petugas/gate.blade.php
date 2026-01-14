<x-app-layout>
    <div class="min-h-screen bg-[#F8FAFC] font-sans pb-20">

        <div class="bg-white border-b border-slate-200 shadow-sm sticky top-0 z-30">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4">
                <div class="flex justify-between items-center">
                    <div class="flex items-center gap-4">
                        <div class="bg-[#0f172a] text-[#F5C542] p-2.5 rounded-xl shadow-lg shadow-slate-900/10">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"></path>
                            </svg>
                        </div>
                        <div>
                            <h1 class="text-xl font-bold text-slate-800 tracking-tight">Gate Check-In</h1>
                            <p class="text-xs text-slate-500 font-medium">Pos Pemeriksaan Pintu Utama</p>
                        </div>
                    </div>

                    <div class="hidden md:flex items-center gap-2 px-4 py-1.5 bg-emerald-50 text-emerald-700 rounded-full border border-emerald-100 shadow-sm">
                        <span class="relative flex h-2.5 w-2.5">
                            <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-emerald-400 opacity-75"></span>
                            <span class="relative inline-flex rounded-full h-2.5 w-2.5 bg-emerald-500"></span>
                        </span>
                        <span class="text-xs font-bold uppercase tracking-widest">Sistem Siap</span>
                    </div>
                </div>
            </div>
        </div>

        <div class="max-w-3xl mx-auto px-4 mt-12">

            <div class="bg-white rounded-[2rem] shadow-2xl border border-slate-100 overflow-hidden relative min-h-[450px] flex flex-col items-center justify-center p-10 text-center">

                <div class="mb-8 relative group">
                    <div class="absolute inset-0 bg-blue-400 blur-[50px] opacity-20 rounded-full group-hover:opacity-30 transition duration-700"></div>
                    <img src="{{ asset('assets/logo-kejari.png') }}" class="h-28 w-28 relative z-10 drop-shadow-2xl transition-transform transform group-hover:scale-105 duration-500" onerror="this.style.display='none'">
                </div>

                <h2 class="text-3xl font-black text-slate-800 tracking-tight mb-2">SCAN ATAU KETIK</h2>
                <p class="text-slate-500 max-w-md mx-auto mb-10 font-medium text-sm">
                    Arahkan alat scanner ke barcode tiket, atau ketik kode tiket secara manual lalu tekan Enter.
                </p>

                <form action="{{ route('petugas.gate') }}" method="GET" autocomplete="off" class="w-full max-w-md relative mx-auto">
                    <div class="relative group">
                        <div class="absolute -inset-1 bg-gradient-to-r from-blue-600 to-[#F5C542] rounded-2xl blur opacity-25 group-hover:opacity-50 transition duration-500"></div>

                        <input type="text"
                            name="tiket_id"
                            id="mainInput"
                            class="relative w-full py-5 px-6 text-center text-3xl font-bold tracking-widest text-slate-800 bg-white border-2 border-slate-100 rounded-2xl focus:border-blue-500 focus:ring-0 transition-all placeholder-slate-200 shadow-xl uppercase"
                            placeholder="KODE TIKET"
                            autofocus
                            onblur="this.focus()">

                        <button type="submit" class="absolute inset-y-2 right-2 aspect-square bg-[#0f172a] text-white rounded-xl flex items-center justify-center hover:bg-[#F5C542] hover:text-slate-900 transition-colors shadow-lg">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path>
                            </svg>
                        </button>
                    </div>
                    <p class="text-[10px] text-slate-400 mt-6 font-mono uppercase tracking-widest bg-slate-50 border border-slate-100 inline-block px-4 py-1.5 rounded-full">
                        Cursor Auto-Lock Active
                    </p>
                </form>

                @if(isset($message) && $message)
                <div class="mt-8 p-4 bg-red-50 border border-red-100 rounded-2xl flex items-center justify-center gap-3 text-red-600 animate-bounce shadow-sm w-full max-w-md">
                    <div class="bg-red-100 p-2 rounded-full">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <div class="text-left">
                        <p class="font-bold text-xs uppercase tracking-wider">Gagal Verifikasi</p>
                        <p class="text-xs opacity-75">{{ $message }}</p>
                    </div>
                </div>
                @endif
            </div>
        </div>
    </div>

    <div id="scanResultModal" class="fixed inset-0 z-50 hidden bg-slate-900/80 backdrop-blur-md flex items-center justify-center p-4 transition-all duration-500">

        <div class="w-full max-w-sm bg-white rounded-3xl overflow-hidden shadow-2xl relative transform transition-all scale-100 animate-scale-up">

            <div class="bg-[#0f172a] p-6 text-white relative overflow-hidden">
                <img src="{{ asset('assets/logo-kejari.png') }}" class="absolute -right-4 -top-4 w-32 h-32 opacity-10 rotate-12 filter grayscale contrast-200">

                <div class="flex justify-between items-start relative z-10">
                    <div>
                        <p class="text-[10px] font-bold tracking-[0.2em] text-[#F5C542] uppercase">Kejaksaan Negeri</p>
                        <h3 class="text-xl font-black tracking-tighter mt-1">VISITOR PASS</h3>
                    </div>
                    <div class="text-right">
                        <span class="bg-emerald-500 text-white text-[10px] font-bold px-3 py-1 rounded-full shadow-lg shadow-emerald-500/50 animate-pulse border border-emerald-400">CLEARED</span>
                    </div>
                </div>

                <div class="mt-8 relative z-10">
                    <p class="text-[10px] text-slate-400 uppercase tracking-widest mb-1">Nama Pengunjung</p>
                    <h2 id="scanNama" class="text-2xl font-bold text-white leading-tight truncate uppercase tracking-tight">...</h2>
                </div>
            </div>

            <div class="p-6 bg-white relative">

                <div class="absolute -left-3 top-[-12px] w-6 h-6 bg-slate-900/80 rounded-full z-20"></div>
                <div class="absolute -right-3 top-[-12px] w-6 h-6 bg-slate-900/80 rounded-full z-20"></div>

                <div class="grid grid-cols-2 gap-6 mb-6 mt-2">
                    <div>
                        <p class="text-[10px] text-slate-400 uppercase tracking-widest font-bold">Tujuan</p>
                        <p id="scanTahanan" class="text-sm font-bold text-slate-800 uppercase truncate mt-0.5">...</p>
                    </div>
                    <div class="text-right">
                        <p class="text-[10px] text-slate-400 uppercase tracking-widest font-bold">Rombongan</p>
                        <p id="scanJumlah" class="text-sm font-bold text-slate-800 mt-0.5">...</p>
                    </div>
                </div>

                <div class="grid grid-cols-2 gap-6 items-end">
                    <div>
                        <p class="text-[10px] text-slate-400 uppercase tracking-widest font-bold">Check-In</p>
                        <p id="scanWaktuJam" class="text-2xl font-mono font-bold text-slate-800 leading-none mt-1">...</p>
                        <p id="scanWaktuTgl" class="text-[10px] text-slate-500 mt-1">...</p>
                    </div>
                    <div class="text-right">
                        <p class="text-[10px] text-slate-400 uppercase tracking-widest font-bold mb-1">Lokasi Blok</p>
                        <div class="inline-block bg-slate-100 border border-slate-200 px-3 py-1 rounded-lg">
                            <p id="scanKamar" class="text-lg font-black text-blue-600">...</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="relative w-full h-1 bg-white">
                <div class="absolute w-full border-t-2 border-dashed border-slate-200"></div>
            </div>

            <div class="bg-white p-6 pt-4 text-center pb-8">
                <div class="h-10 w-full bg-[url('https://upload.wikimedia.org/wikipedia/commons/thumb/d/d0/Code_39_243.svg/1200px-Code_39_243.svg.png')] bg-repeat-x bg-contain opacity-40 mb-4 mix-blend-darken"></div>

                <p class="text-[10px] text-slate-300 font-mono mb-6 uppercase tracking-[0.3em]">SECURE GATE ENTRY SYSTEM</p>

                <button onclick="closeScanModal()" class="w-full py-3.5 bg-[#0f172a] hover:bg-[#F5C542] hover:text-[#0f172a] text-white font-bold rounded-xl shadow-lg transition-all uppercase tracking-widest text-xs flex justify-center items-center gap-2 group">
                    <span>Scan Berikutnya</span>
                    <svg class="w-4 h-4 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path>
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            // 1. Fokus Otomatis saat halaman dimuat
            setTimeout(() => document.getElementById('mainInput').focus(), 500);

            // 2. Jika ada data visitor (Hasil Scan)
            @if(isset($visitor) && $visitor)
            // Isi Data ke Tiket
            document.getElementById('scanNama').innerText = "{{ $visitor->nama_pengunjung }}";
            document.getElementById('scanJumlah').innerText = "{{ $visitor->jumlah_pengikut }} Orang";
            document.getElementById('scanTahanan').innerText = "{{ $visitor->nama_tahanan }}";
            document.getElementById('scanKamar').innerText = "{{ $visitor->nomor_kamar }}"; // Angka Besar

            // Format Waktu
            document.getElementById('scanWaktuJam').innerText = "{{ \Carbon\Carbon::parse($visitor->updated_at)->format('H:i') }}";
            document.getElementById('scanWaktuTgl').innerText = "{{ \Carbon\Carbon::parse($visitor->updated_at)->format('d M Y') }}";

            // Tampilkan Modal
            document.getElementById('scanResultModal').classList.remove('hidden');

            // Mainkan Suara Sukses (Opsional)
            // let audio = new Audio("{{ asset('assets/success.mp3') }}");
            // audio.play().catch(e => {});
            @endif
        });

        function closeScanModal() {
            // Tutup Modal
            document.getElementById('scanResultModal').classList.add('hidden');

            // Bersihkan Input
            let inputField = document.getElementById('mainInput');
            inputField.value = '';

            // Fokus Kembali agar siap scan lagi
            inputField.focus();

            // Hapus parameter URL agar refresh aman
            if (window.history.replaceState) {
                window.history.replaceState(null, null, window.location.pathname);
            }
        }
    </script>
</x-app-layout>