<nav x-data="{ open: false }" class="bg-[#0f172a] border-b border-[#F5C542] sticky top-0 z-50 shadow-md">
    <div class="max-w-7xl mx-auto px-2 sm:px-4 lg:px-8">
        <div class="flex justify-between h-20">
            <div class="flex items-center shrink-0 mr-4">
                <a href="{{ route('dashboard') }}" class="flex items-center gap-2">
                    <img src="{{ asset('assets/logo-kejari.png') }}" class="h-9 w-9 object-contain" onerror="this.style.display='none'">
                    <div class="flex flex-col justify-center">
                        <span class="font-bold text-white text-lg leading-none tracking-tight whitespace-nowrap">SIP-RUTAN</span>
                        <div class="text-[10px] uppercase leading-none mt-1 tracking-widest font-bold text-[#F5C542] whitespace-nowrap">
                            @if(Auth::user()->role == 'kepala') AREA PIMPINAN
                            @elseif(Auth::user()->role == 'petugas') AREA STAFF
                            @elseif(Auth::user()->role == 'petugas_lapas') AREA LAPAS
                            @else KEJARI BJM @endif
                        </div>
                    </div>
                </a>
            </div>

            <div class="hidden md:flex items-center space-x-1 overflow-x-auto no-scrollbar flex-1 justify-center">

                @php
                $navClass = "whitespace-nowrap px-3 py-1.5 text-xs font-bold rounded-full transition-all duration-200 border border-transparent flex items-center gap-1.5";
                $activeClass = "bg-[#F5C542] text-[#0f172a] shadow-md transform scale-105";
                $inactiveClass = "text-slate-400 hover:text-white hover:bg-slate-800 hover:border-slate-600";
                @endphp

                {{-- === MENU PETUGAS === --}}
                @if(Auth::user()->role == 'petugas')
                <a href="{{ route('petugas.index') }}" class="{{ $navClass }} {{ request()->routeIs('petugas.index') ? $activeClass : $inactiveClass }}">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    Verifikasi
                </a>

                <a href="{{ route('petugas.titipan.index') }}" class="{{ $navClass }} {{ request()->routeIs('petugas.titipan.*') ? $activeClass : $inactiveClass }}">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                    </svg>
                    Verif Titipan
                </a>

                <a href="{{ route('petugas.tahanan.index') }}" class="{{ $navClass }} {{ request()->routeIs('petugas.tahanan.*') ? $activeClass : $inactiveClass }}">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                    </svg>
                    Data Tahanan
                </a>
                <a href="{{ route('petugas.survei.index') }}" class="{{ $navClass }} {{ request()->routeIs('petugas.survei.*') ? $activeClass : $inactiveClass }}">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                    </svg>
                    Hasil Survei
                </a>
                <a href="{{ route('petugas.riwayat') }}" class="{{ $navClass }} {{ request()->routeIs('petugas.riwayat') ? $activeClass : $inactiveClass }}">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4"></path>
                    </svg>
                    Arsip
                </a>
                <a href="{{ route('petugas.laporan.statistik') }}" class="{{ $navClass }} {{ request()->routeIs('petugas.laporan.*') ? $activeClass : $inactiveClass }}">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                    </svg>
                    Laporan
                </a>

                {{-- === MENU KEPALA === --}}
                @elseif(Auth::user()->role == 'kepala')
                <a href="{{ route('kepala.index') }}" class="{{ $navClass }} {{ request()->routeIs('kepala.index') ? $activeClass : $inactiveClass }}">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                    </svg>
                    Meja Pimpinan
                </a>
                <a href="{{ route('kepala.laporan.index') }}" class="{{ $navClass }} {{ request()->routeIs('kepala.laporan.index') ? $activeClass : $inactiveClass }}">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                    Laporan
                </a>
                <a href="{{ route('kepala.survei') }}" class="{{ $navClass }} {{ request()->routeIs('kepala.survei') ? $activeClass : $inactiveClass }}">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                    </svg>
                    Hasil Survei
                </a>

                {{-- === MENU PETUGAS LAPAS === --}}
                @elseif(Auth::user()->role == 'petugas_lapas')
                <a href="{{ route('lapas.dashboard') }}" class="{{ $navClass }} {{ request()->routeIs('lapas.dashboard') ? $activeClass : $inactiveClass }}">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                    </svg>
                    Pos Penjagaan
                </a>
                <a href="{{ route('lapas.gate-check') }}" class="{{ $navClass }} {{ request()->routeIs('lapas.gate-check') ? $activeClass : $inactiveClass }}">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4"></path>
                    </svg>
                    Gate Check
                </a>

                {{-- TAMBAHAN: Menu Kunjungan Desktop (Diubah ke URL) --}}
                <a href="{{ url('/lapas/kunjungan') }}" class="{{ $navClass }} {{ request()->is('lapas/kunjungan') ? $activeClass : $inactiveClass }}">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                    </svg>
                    Kunjungan
                </a>

                <a href="{{ route('lapas.titipan') }}" class="{{ $navClass }} {{ request()->routeIs('lapas.titipan') ? $activeClass : $inactiveClass }}">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                    </svg>
                    Titipan
                </a>
                <a href="{{ route('lapas.laporan') }}" class="{{ $navClass }} {{ request()->routeIs('lapas.laporan') ? $activeClass : $inactiveClass }}">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                    </svg>
                    Laporan Lapas
                </a>

                {{-- === MENU MASYARAKAT === --}}
                @elseif(Auth::user()->role == 'masyarakat')
                <a href="{{ route('masyarakat.index') }}" class="{{ $navClass }} {{ request()->routeIs('masyarakat.index') ? $activeClass : $inactiveClass }}">Beranda</a>
                <a href="{{ route('masyarakat.ulasan') }}" class="{{ $navClass }} {{ request()->routeIs('masyarakat.ulasan') ? $activeClass : $inactiveClass }}">Beri Ulasan</a>
                @endif
            </div>

            <div class="hidden md:flex items-center ml-4">
                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button class="flex items-center gap-2 text-gray-300 hover:text-white transition group">
                            <div class="text-right hidden lg:block">
                                <div class="text-[10px] uppercase font-bold text-[#F5C542] group-hover:text-yellow-300">{{ str_replace('_', ' ', Auth::user()->role) }}</div>
                                <div class="text-xs font-bold">{{ substr(Auth::user()->name, 0, 10) }}..</div>
                            </div>
                            <div class="h-8 w-8 rounded bg-[#F5C542] text-[#0f172a] flex items-center justify-center font-bold shadow-sm group-hover:bg-yellow-300">
                                {{ substr(Auth::user()->name, 0, 1) }}
                            </div>
                        </button>
                    </x-slot>
                    <x-slot name="content">
                        <x-dropdown-link :href="route('profile.edit')">{{ __('Profile') }}</x-dropdown-link>
                        
                        <!-- PERBAIKAN 1: Ganti komponen link dengan button submit native HTML -->
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="block w-full px-4 py-2 text-left text-sm leading-5 text-red-500 font-bold hover:bg-gray-100 focus:outline-none focus:bg-gray-100 transition duration-150 ease-in-out">
                                {{ __('Log Out') }}
                            </button>
                        </form>
                    </x-slot>
                </x-dropdown>
            </div>

            <div class="-mr-2 flex items-center md:hidden">
                <button @click="open = ! open" class="p-2 rounded-md text-[#F5C542] hover:bg-slate-800 focus:outline-none transition">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <div :class="{'block': open, 'hidden': ! open}" class="hidden md:hidden bg-[#1e293b] border-t border-slate-700">
        <div class="pt-2 pb-3 space-y-1 px-4">
            @if(Auth::user()->role == 'petugas')
            <x-responsive-nav-link :href="route('petugas.index')" :active="request()->routeIs('petugas.index')" class="text-white hover:text-[#F5C542]">Verifikasi</x-responsive-nav-link>
            <x-responsive-nav-link :href="route('petugas.titipan.index')" :active="request()->routeIs('petugas.titipan.*')" class="text-white hover:text-[#F5C542]">Verif Titipan</x-responsive-nav-link>
            <x-responsive-nav-link :href="route('petugas.tahanan.index')" :active="request()->routeIs('petugas.tahanan.*')" class="text-white hover:text-[#F5C542]">Data Tahanan</x-responsive-nav-link>
            <x-responsive-nav-link :href="route('petugas.survei.index')" :active="request()->routeIs('petugas.survei.*')" class="text-white hover:text-[#F5C542]">Hasil Survei</x-responsive-nav-link>
            <x-responsive-nav-link :href="route('petugas.riwayat')" :active="request()->routeIs('petugas.riwayat')" class="text-white hover:text-[#F5C542]">Arsip</x-responsive-nav-link>
            <x-responsive-nav-link :href="route('petugas.laporan.statistik')" :active="request()->routeIs('petugas.laporan.*')" class="text-white hover:text-[#F5C542]">Laporan</x-responsive-nav-link>

            @elseif(Auth::user()->role == 'kepala')
            <x-responsive-nav-link :href="route('kepala.index')" :active="request()->routeIs('kepala.index')" class="text-white hover:text-[#F5C542]">Meja Pimpinan</x-responsive-nav-link>
            <x-responsive-nav-link :href="route('kepala.laporan.index')" :active="request()->routeIs('kepala.laporan.index')" class="text-white hover:text-[#F5C542]">Laporan</x-responsive-nav-link>
            <x-responsive-nav-link :href="route('kepala.survei')" :active="request()->routeIs('kepala.survei')" class="text-white hover:text-[#F5C542]">Hasil Survei</x-responsive-nav-link>

            @elseif(Auth::user()->role == 'petugas_lapas')
            <x-responsive-nav-link :href="route('lapas.dashboard')" :active="request()->routeIs('lapas.dashboard')" class="text-white hover:text-[#F5C542]">Pos Penjagaan</x-responsive-nav-link>
            <x-responsive-nav-link :href="route('lapas.gate-check')" :active="request()->routeIs('lapas.gate-check')" class="text-white hover:text-[#F5C542]">Gate Check</x-responsive-nav-link>

            {{-- TAMBAHAN: Menu Kunjungan Mobile (Diubah ke URL) --}}
            <x-responsive-nav-link :href="url('/lapas/kunjungan')" :active="request()->is('lapas/kunjungan')" class="text-white hover:text-[#F5C542]">Kunjungan</x-responsive-nav-link>

            <x-responsive-nav-link :href="route('lapas.titipan')" :active="request()->routeIs('lapas.titipan')" class="text-white hover:text-[#F5C542]">Titipan</x-responsive-nav-link>
            <x-responsive-nav-link :href="route('lapas.laporan')" :active="request()->routeIs('lapas.laporan')" class="text-white hover:text-[#F5C542]">Laporan Lapas</x-responsive-nav-link>

            @elseif(Auth::user()->role == 'masyarakat')
            <x-responsive-nav-link :href="route('masyarakat.index')" :active="request()->routeIs('masyarakat.index')" class="text-white hover:text-[#F5C542]">Beranda</x-responsive-nav-link>
            <x-responsive-nav-link :href="route('masyarakat.ulasan')" :active="request()->routeIs('masyarakat.ulasan')" class="text-white hover:text-[#F5C542]">Beri Ulasan</x-responsive-nav-link>
            @endif
        </div>

        <div class="pt-4 pb-4 border-t border-slate-700 bg-slate-900/50">
            <div class="px-4 flex items-center gap-3">
                <div class="h-10 w-10 rounded-full bg-[#F5C542] flex items-center justify-center font-bold text-[#0f172a]">
                    {{ substr(Auth::user()->name, 0, 1) }}
                </div>
                <div>
                    <div class="font-medium text-base text-[#F5C542]">{{ Auth::user()->name }}</div>
                    <div class="font-medium text-sm text-slate-400">{{ Auth::user()->email }}</div>
                </div>
            </div>
            <div class="mt-3 space-y-1 px-4">
                <x-responsive-nav-link :href="route('profile.edit')" class="text-gray-300 hover:text-white">{{ __('Profile') }}</x-responsive-nav-link>
                
                <!-- PERBAIKAN 2: Ganti komponen link dengan button submit native HTML untuk versi mobile -->
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="block w-full text-left pl-3 pr-4 py-2 border-l-4 border-transparent text-base font-medium text-red-400 hover:text-red-300 hover:bg-slate-800 focus:outline-none transition duration-150 ease-in-out">
                        {{ __('Log Out') }}
                    </button>
                </form>
            </div>
        </div>
    </div>
</nav>