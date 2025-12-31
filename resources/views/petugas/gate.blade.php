<x-app-layout>
    <div class="min-h-screen bg-[#F1F5F9] font-sans pb-20" x-data="{ mode: 'scan' }">

        <div class="bg-white border-b border-slate-200 shadow-sm sticky top-0 z-30">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4">
                <div class="flex justify-between items-center">
                    <div class="flex items-center gap-4">
                        <div class="bg-[#0f172a] text-[#F5C542] p-2 rounded-lg shadow-lg">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"></path>
                            </svg>
                        </div>
                        <div>
                            <h1 class="text-xl font-bold text-slate-800 tracking-tight">Gate Check-In</h1>
                            <p class="text-xs text-slate-500 font-medium">Pos Pemeriksaan Pintu Utama</p>
                        </div>
                    </div>

                    <div class="flex items-center gap-2 px-3 py-1 bg-emerald-50 text-emerald-700 rounded-full border border-emerald-100">
                        <span class="relative flex h-2 w-2">
                            <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-emerald-400 opacity-75"></span>
                            <span class="relative inline-flex rounded-full h-2 w-2 bg-emerald-500"></span>
                        </span>
                        <span class="text-xs font-bold uppercase tracking-wider">System Online</span>
                    </div>
                </div>
            </div>
        </div>

        <div class="max-w-4xl mx-auto px-4 mt-10">

            <div class="flex justify-center mb-8">
                <div class="bg-white p-1.5 rounded-2xl shadow-sm border border-slate-200 inline-flex">
                    <button @click="mode = 'scan'; setTimeout(() => document.getElementById('scanInput').focus(), 100)"
                        :class="{ 'bg-[#0f172a] text-[#F5C542] shadow-md': mode === 'scan', 'text-slate-500 hover:text-slate-800': mode !== 'scan' }"
                        class="px-6 py-2.5 rounded-xl text-sm font-bold transition-all flex items-center gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm12 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z"></path>
                        </svg>
                        MODE SCANNER
                    </button>
                    <button @click="mode = 'manual'; setTimeout(() => document.getElementById('manualInput').focus(), 100)"
                        :class="{ 'bg-[#0f172a] text-[#F5C542] shadow-md': mode === 'manual', 'text-slate-500 hover:text-slate-800': mode !== 'manual' }"
                        class="px-6 py-2.5 rounded-xl text-sm font-bold transition-all flex items-center gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                        </svg>
                        KETIK MANUAL
                    </button>
                </div>
            </div>

            <div class="bg-white rounded-3xl shadow-xl border border-slate-200 overflow-hidden relative min-h-[400px]">

                <div x-show="mode === 'scan'" x-transition.opacity class="p-12 text-center h-full flex flex-col items-center justify-center">
                    <div class="mb-8 relative">
                        <div class="absolute inset-0 bg-blue-500 blur-3xl opacity-20 rounded-full animate-pulse"></div>
                        <img src="{{ asset('assets/logo-kejari.png') }}" class="h-24 w-24 relative z-10 drop-shadow-xl" onerror="this.style.display='none'">
                    </div>
                    <h2 class="text-3xl font-black text-slate-800 tracking-tight mb-2">SIAP MENERIMA SCAN</h2>
                    <p class="text-slate-500 max-w-md mx-auto mb-8">Arahkan alat scanner ke barcode tiket pengunjung.</p>

                    <form action="{{ route('petugas.gate') }}" method="GET" autocomplete="off" class="w-full max-w-md relative">
                        <div class="relative group">
                            <input type="text"
                                name="tiket_id"
                                id="scanInput"
                                class="w-full py-4 text-center text-2xl font-bold tracking-widest text-transparent caret-blue-500 bg-slate-50 border-2 border-dashed border-slate-300 rounded-xl focus:border-[#F5C542] focus:ring-4 focus:ring-[#F5C542]/20 transition-all placeholder-slate-300"
                                placeholder="|||||||||||||||||"
                                autofocus
                                onblur="this.focus()"
                                style="color: #0f172a;">
                            <div class="absolute inset-y-0 right-4 flex items-center pointer-events-none">
                                <span class="animate-pulse h-3 w-3 bg-green-500 rounded-full"></span>
                            </div>
                        </div>
                        <p class="text-xs text-slate-400 mt-4 font-mono bg-slate-100 inline-block px-3 py-1 rounded">Sistem Auto-Focus Aktif</p>
                    </form>
                </div>

                <div x-show="mode === 'manual'" x-transition.opacity class="p-12 h-full flex flex-col items-center justify-center" style="display: none;">
                    <div class="w-16 h-16 bg-slate-100 rounded-2xl flex items-center justify-center mb-6 text-slate-600">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"></path>
                        </svg>
                    </div>

                    <h2 class="text-2xl font-bold text-slate-800 mb-2">Input Kode Tiket</h2>
                    <p class="text-slate-500 mb-8 text-sm">Masukkan Kode Tiket (Contoh: REQ-12)</p>

                    <form action="{{ route('petugas.gate') }}" method="GET" autocomplete="off" class="w-full max-w-sm">
                        <div class="mb-4">
                            <label class="block text-xs font-bold text-slate-700 uppercase mb-2">KODE TIKET</label>

                            <input type="text"
                                name="tiket_id"
                                id="manualInput"
                                class="w-full px-4 py-3 rounded-xl border border-slate-300 focus:border-[#F5C542] focus:ring-2 focus:ring-[#F5C542] text-lg font-bold text-slate-800 uppercase"
                                placeholder="Contoh: REQ-15">
                        </div>
                        <button type="submit" class="w-full py-3.5 bg-[#0f172a] hover:bg-[#F5C542] hover:text-[#0f172a] text-white font-bold rounded-xl shadow-lg transition-all flex justify-center items-center gap-2">
                            CEK DATA TIKET
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path>
                            </svg>
                        </button>
                    </form>
                </div>

                @if(isset($message) && $message)
                <div class="absolute bottom-0 left-0 w-full p-4 bg-red-50 border-t border-red-100 flex items-center justify-center gap-3 text-red-600 animate-bounce-up">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                    </svg>
                    <span class="font-bold text-sm">{{ $message }}</span>
                </div>
                @endif
            </div>
        </div>
    </div>

    <div id="scanResultModal" class="fixed inset-0 z-50 hidden bg-slate-900/90 backdrop-blur-md flex items-center justify-center p-4 transition-opacity duration-300">
        <div class="bg-white rounded-[2rem] shadow-2xl w-full max-w-md overflow-hidden transform scale-100 transition-transform relative">
            <div class="bg-emerald-500 px-8 py-8 text-center text-white">
                <div class="w-20 h-20 bg-white rounded-full flex items-center justify-center mx-auto mb-3 shadow-lg text-emerald-500">
                    <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path>
                    </svg>
                </div>
                <h2 class="text-3xl font-black uppercase tracking-widest">BERHASIL</h2>
                <div class="text-xs font-bold bg-white/20 inline-block px-4 py-1 rounded-full mt-2">TIKET VALID & DISETUJUI</div>
            </div>
            <div class="p-8 space-y-5 bg-white">
                <div class="text-center">
                    <h3 id="scanNama" class="text-2xl font-bold text-slate-800 leading-tight">...</h3>
                    <p class="text-slate-400 text-xs font-bold uppercase tracking-widest mt-1">Pengunjung Utama</p>
                </div>
                <div class="bg-slate-50 p-4 rounded-2xl border border-slate-100 flex flex-col gap-2">
                    <div class="flex justify-between border-b border-slate-200 pb-2">
                        <span class="text-xs font-bold text-slate-400 uppercase">Rombongan</span>
                        <span id="scanJumlah" class="text-sm font-bold text-slate-800">...</span>
                    </div>
                    <div class="flex justify-between border-b border-slate-200 pb-2">
                        <span class="text-xs font-bold text-slate-400 uppercase">Tujuan</span>
                        <span id="scanTahanan" class="text-sm font-bold text-slate-800">...</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-xs font-bold text-slate-400 uppercase">Kamar</span>
                        <span id="scanKamar" class="text-xs font-bold text-white bg-blue-600 px-2 py-0.5 rounded">...</span>
                    </div>
                </div>
                <div class="text-center">
                    <p id="scanWaktu" class="font-mono text-[10px] text-slate-400 bg-slate-100 inline-block px-2 py-1 rounded">...</p>
                </div>
                <button onclick="closeScanModal()" class="w-full py-4 bg-[#0f172a] text-white font-bold rounded-xl hover:bg-[#F5C542] hover:text-[#0f172a] transition-all shadow-lg uppercase tracking-widest text-sm">
                    SCAN BERIKUTNYA
                </button>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            // Fokus otomatis ke scanner saat load
            setTimeout(() => document.getElementById('scanInput').focus(), 500);

            @if(isset($visitor) && $visitor)
            document.getElementById('scanNama').innerText = "{{ $visitor->nama_pengunjung }}";
            document.getElementById('scanJumlah').innerText = "{{ $visitor->jumlah_pengikut }} Orang";
            document.getElementById('scanTahanan').innerText = "{{ $visitor->nama_tahanan }}";
            document.getElementById('scanKamar').innerText = "Kamar {{ $visitor->nomor_kamar }}";
            document.getElementById('scanWaktu').innerText = "Verifikasi: {{ \Carbon\Carbon::parse($visitor->updated_at)->format('d/m/Y H:i') }}";
            document.getElementById('scanResultModal').classList.remove('hidden');
            @endif
        });

        function closeScanModal() {
            document.getElementById('scanResultModal').classList.add('hidden');
            document.getElementById('scanInput').value = '';
            document.getElementById('manualInput').value = '';

            // Cek sedang mode apa, fokuskan kesana
            let activeMode = document.querySelector('[x-data]').__x.$data.mode;
            if (activeMode === 'scan') {
                document.getElementById('scanInput').focus();
            } else {
                document.getElementById('manualInput').focus();
            }

            if (window.history.replaceState) {
                window.history.replaceState(null, null, window.location.pathname);
            }
        }
    </script>
</x-app-layout>