<nav x-data="{ open: false }" class="bg-[#0f172a] border-b border-[#F5C542] sticky top-0 z-50 shadow-md">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">

            <div class="flex">
                <div class="shrink-0 flex items-center gap-3">
                    <a href="#">
                        <img src="{{ asset('assets/logo-kejari.png') }}" class="h-8 w-8 object-contain" onerror="this.style.display='none'">
                    </a>
                    <div class="flex flex-col justify-center">
                        <span class="font-bold text-white text-lg leading-none tracking-tight">SIP-RUTAN</span>
                        <div class="text-[10px] uppercase leading-none mt-1 tracking-widest font-bold text-[#F5C542]">
                            @if(Auth::user()->role == 'kepala')
                            AREA PIMPINAN
                            @elseif(Auth::user()->role == 'petugas')
                            AREA STAFF
                            @else
                            KEJARI BANJARMASIN
                            @endif
                        </div>
                    </div>
                </div>

                <div class="hidden space-x-8 sm:-my-px sm:ml-10 sm:flex">

                    {{-- ================================================= --}}
                    {{-- 1. MENU KHUSUS KEPALA                             --}}
                    {{-- ================================================= --}}
                    @if(Auth::user()->role == 'kepala')
                    <x-nav-link :href="route('kepala.index')" :active="request()->routeIs('kepala.index')" class="text-[#F5C542] font-bold">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        Meja Pimpinan
                    </x-nav-link>

                    <x-nav-link :href="route('kepala.laporan')" :active="request()->routeIs('kepala.laporan')" class="text-white hover:text-[#F5C542]">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                        </svg>
                        Laporan & Arsip
                    </x-nav-link>

                    {{-- ================================================= --}}
                    {{-- 2. MENU KHUSUS PETUGAS (LENGKAP)                  --}}
                    {{-- ================================================= --}}
                    @elseif(Auth::user()->role == 'petugas')
                    <x-nav-link :href="route('petugas.index')" :active="request()->routeIs('petugas.index')" class="text-white hover:text-[#F5C542]">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        Verifikasi
                    </x-nav-link>

                    <x-nav-link :href="route('petugas.gate')" :active="request()->routeIs('petugas.gate')" class="text-white hover:text-[#F5C542]">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm12 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z"></path>
                        </svg>
                        Gate Check
                    </x-nav-link>

                    <x-nav-link :href="route('petugas.riwayat')" :active="request()->routeIs('petugas.riwayat')" class="text-white hover:text-[#F5C542]">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        Arsip
                    </x-nav-link>

                    <x-nav-link :href="route('petugas.laporan')" :active="request()->routeIs('petugas.laporan')" class="text-white hover:text-[#F5C542]">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                        Laporan
                    </x-nav-link>

                    {{-- ================================================= --}}
                    {{-- 3. MENU MASYARAKAT                                --}}
                    {{-- ================================================= --}}
                    @elseif(Auth::user()->role == 'masyarakat')
                    <x-nav-link :href="route('masyarakat.index')" :active="request()->routeIs('masyarakat.index')" class="text-white">
                        Beranda
                    </x-nav-link>
                    <x-nav-link :href="route('masyarakat.riwayat')" :active="request()->routeIs('masyarakat.riwayat')" class="text-white">
                        Riwayat Saya
                    </x-nav-link>
                    @endif

                </div>
            </div>

            <div class="hidden sm:flex sm:items-center sm:ml-6">
                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button class="flex items-center text-sm font-medium text-gray-300 hover:text-white transition duration-150 ease-in-out">
                            <div class="text-right mr-3 hidden md:block">
                                <div class="text-[10px] uppercase tracking-wider text-[#F5C542] font-bold leading-none mb-1">
                                    {{ strtoupper(Auth::user()->role) }}
                                </div>
                                <div class="font-bold text-white leading-none">{{ Auth::user()->name }}</div>
                            </div>
                            <div class="h-9 w-9 rounded bg-[#F5C542] text-[#0f172a] flex items-center justify-center font-bold text-lg shadow-sm">
                                {{ substr(Auth::user()->name, 0, 1) }}
                            </div>
                        </button>
                    </x-slot>

                    <x-slot name="content">
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <x-dropdown-link :href="route('logout')" onclick="event.preventDefault(); this.closest('form').submit();" class="text-red-600 font-bold border-t border-gray-100">
                                {{ __('Log Out') }}
                            </x-dropdown-link>
                        </form>
                    </x-slot>
                </x-dropdown>
            </div>

            <div class="-mr-2 flex items-center sm:hidden">
                <button @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-white hover:bg-gray-700 focus:outline-none transition duration-150 ease-in-out">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden bg-[#1e293b] border-t border-slate-700">
        <div class="pt-2 pb-3 space-y-1">
            @if(Auth::user()->role == 'kepala')
            <x-responsive-nav-link :href="route('kepala.index')" :active="request()->routeIs('kepala.index')" class="text-[#F5C542]">Meja Pimpinan</x-responsive-nav-link>
            <x-responsive-nav-link :href="route('kepala.laporan')" :active="request()->routeIs('kepala.laporan')" class="text-white">Laporan</x-responsive-nav-link>

            @elseif(Auth::user()->role == 'petugas')
            <x-responsive-nav-link :href="route('petugas.index')" :active="request()->routeIs('petugas.index')" class="text-white">Meja Verifikasi</x-responsive-nav-link>
            <x-responsive-nav-link :href="route('petugas.gate')" :active="request()->routeIs('petugas.gate')" class="text-white">Gate Check</x-responsive-nav-link>
            <x-responsive-nav-link :href="route('petugas.riwayat')" :active="request()->routeIs('petugas.riwayat')" class="text-white">Arsip & Riwayat</x-responsive-nav-link>
            <x-responsive-nav-link :href="route('petugas.laporan')" :active="request()->routeIs('petugas.laporan')" class="text-white">Laporan</x-responsive-nav-link>

            @elseif(Auth::user()->role == 'masyarakat')
            <x-responsive-nav-link :href="route('masyarakat.index')" :active="request()->routeIs('masyarakat.index')" class="text-white">Beranda</x-responsive-nav-link>
            <x-responsive-nav-link :href="route('masyarakat.riwayat')" :active="request()->routeIs('masyarakat.riwayat')" class="text-white">Riwayat Saya</x-responsive-nav-link>
            @endif
        </div>

        <div class="pt-4 pb-1 border-t border-slate-700">
            <div class="mt-3 space-y-1">
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <x-responsive-nav-link :href="route('logout')" onclick="event.preventDefault(); this.closest('form').submit();" class="text-red-500">
                        {{ __('Log Out') }}
                    </x-responsive-nav-link>
                </form>
            </div>
        </div>
    </div>
</nav>