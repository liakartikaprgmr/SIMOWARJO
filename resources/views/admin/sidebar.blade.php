<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Admin Dashboard</title>

    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100">
    <!-- NAVBAR -->
    <header class="fixed top-0 left-0 right-0 h-16 bg-white shadow flex items-center justify-between px-3 md:px-6 z-50">
        <!-- LOGO -->
        <div class="flex items-center gap-2 min-w-0">
            <!-- HAMBURGER MOBILE -->
            <button id="menuBtn" class="md:hidden text-2xl flex-shrink-0">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
                    <path fill="currentColor"
                        d="M4 18h16c.55 0 1-.45 1-1s-.45-1-1-1H4c-.55 0-1 .45-1 1s.45 1 1 1m0-5h16c.55 0 1-.45 1-1s-.45-1-1-1H4c-.55 0-1 .45-1 1s.45 1 1 1M3 7c0 .55.45 1 1 1h16c.55 0 1-.45 1-1s-.45-1-1-1H4c-.55 0-1 .45-1 1" />
                </svg>
            </button>
            <!-- LOGO -->
            <img src="{{ asset('assets/logo.png') }}" class="w-8 h-8 md:w-10 md:h-10 flex-shrink-0" alt="Logo">
            <!-- JUDUL -->
            <h1 class="font-bold text-sm md:text-lg text-red-800 whitespace-nowrap">
                SIMOWARJO
            </h1>
        </div>

        <!-- PROFILE -->
        @php $user = auth()->user(); @endphp

        <div class="relative flex-shrink-0">
            <button id="profileBtn"
                class="flex items-center gap-2 hover:bg-gray-50 rounded-lg p-1 md:p-2 transition max-w-[170px] md:max-w-none">
                <!-- FOTO -->
                <img src="{{ $user?->foto ? url($user->foto) : 'https://i.pravatar.cc/40' }}"
                    class="w-8 h-8 md:w-10 md:h-10 rounded-full object-cover flex-shrink-0" alt="Profile">
                <!-- NAMA & EMAIL -->
                <div class="text-left overflow-hidden">
                    <p class="font-semibold text-xs md:text-sm truncate">
                        {{ $user?->nama ?? 'Guest User' }}
                    </p>
                    <p class="hidden md:block text-gray-500 text-xs truncate">
                        {{ $user?->email ?? 'Not Logged In' }}
                    </p>
                </div>

                <!-- ICON DROPDOWN -->
                <svg xmlns="http://www.w3.org/2000/svg" class="hidden md:block w-4 h-4 text-gray-500 flex-shrink-0"
                    fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                </svg>
            </button>

            @if(auth()->check())
                <div id="profileDropdown"
                    class="hidden absolute right-0 mt-2 w-56 bg-white border border-gray-100 rounded-lg shadow-lg py-2 z-50">
                    <div class="px-4 py-2 border-b">
                        <p class="font-semibold text-sm">
                            {{ $user?->nama }}
                        </p>
                        <p class="text-xs text-gray-500 break-all">
                            {{ $user?->email }}
                        </p>
                    </div>

                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button type="submit"
                            class="w-full text-left px-4 py-2 text-sm text-red-600 hover:bg-red-50 hover:text-red-800 transition flex items-center gap-2">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2"
                                stroke="currentColor" class="w-4 h-4">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M15.75 9V5.25A2.25 2.25 0 0013.5 3h-6a2.25 2.25 0 00-2.25 2.25v13.5A2.25 2.25 0 007.5 21h6a2.25 2.25 0 002.25-2.25V15M12 9l-3 3m0 0l3 3m-3-3h12.75" />
                            </svg>
                            Logout
                        </button>
                    </form>
                </div>
            @endif
        </div>
    </header>

    <!-- SIDEBAR -->
    <aside id="sidebar"
        class="fixed top-16 left-0 w-64 h-screen bg-red-800 text-white pt-6 pb-20 overflow-y-auto transform -translate-x-full md:translate-x-0 transition-transform duration-300 z-40">
        <nav class="px-4 space-y-6">
            <!-- UTAMA -->
            <div>
                <p class="text-xs text-red-200 mb-2">UTAMA</p>
                <a href="/admin/dashboard" class="flex items-center gap-2 p-2 rounded-lg hover:bg-red-700">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
                        <path fill="currentColor"
                            d="M4 13h6c.55 0 1-.45 1-1V4c0-.55-.45-1-1-1H4c-.55 0-1 .45-1 1v8c0 .55.45 1 1 1m0 8h6c.55 0 1-.45 1-1v-4c0-.55-.45-1-1-1H4c-.55 0-1 .45-1 1v4c0 .55.45 1 1 1m10 0h6c.55 0 1-.45 1-1v-8c0-.55-.45-1-1-1h-6c-.55 0-1 .45-1 1v8c0 .55.45 1 1 1M13 4v4c0 .55.45 1 1 1h6c.55 0 1-.45 1-1V4c0-.55-.45-1-1-1h-6c-.55 0-1 .45-1 1" />
                    </svg>
                    Dashboard
                </a>
                @if(auth()->check() && (auth()->user()->role == 'supervisor' || auth()->user()->role == 'admin' || auth()->user()->role == 'leader_shift'))
                    <a href="{{ route('admin.presensi_wajah') }}"
                        class="flex items-center gap-2 p-2 rounded-lg hover:bg-red-700 mt-2">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
                            <circle cx="12" cy="12" r="3.2" fill="currentColor" />
                            <path fill="currentColor"
                                d="M9 2L7.17 4H4c-1.1 0-2 .9-2 2v12c0 1.1.9 2 2 2h16c1.1 0 2-.9 2-2V6c0-1.1-.9-2-2-2h-3.17L15 2zm3 15c-2.76 0-5-2.24-5-5s2.24-5 5-5s5 2.24 5 5s-2.24 5-5 5" />
                        </svg>
                        Presensi Wajah
                        <span
                            class="ml-auto text-[10px] px-2 py-0.5 rounded-full bg-blue-500/20 text-blue-300 font-semibold">
                            AI
                        </span>
                    </a>
                @endif

                @if(auth()->check() && auth()->user()->role == 'leader_shift')
                    <a href="{{ route('karyawan.jadwal_kerja') }}"
                        class="flex items-center gap-2 p-2 rounded-lg hover:bg-red-700 mt-2">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
                            <path fill="currentColor"
                                d="M19 4h-1V2h-2v2H8V2H6v2H5c-1.11 0-1.99.9-1.99 2L3 20a2 2 0 0 0 2 2h14c1.1 0 2-.9 2-2V6c0-1.1-.9-2-2-2m0 16H5V10h14zM9 14H7v-2h2zm4 0h-2v-2h2zm4 0h-2v-2h2zm-8 4H7v-2h2zm4 0h-2v-2h2zm4 0h-2v-2h2z" />
                        </svg>
                        Jadwal Kerja Anda
                    </a>
                @endif
            </div>

            <!-- MANAJEMEN -->
            <div>
                <p class="text-xs text-red-200 mb-2">MANAJEMEN</p>
                <a href="/admin/kelola_karyawan" class="flex items-center gap-2 p-2 rounded-lg hover:bg-red-700">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
                        <path fill="currentColor"
                            d="M9 13.75c-2.34 0-7 1.17-7 3.5V19h14v-1.75c0-2.33-4.66-3.5-7-3.5M4.34 17c.84-.58 2.87-1.25 4.66-1.25s3.82.67 4.66 1.25zM9 12c1.93 0 3.5-1.57 3.5-3.5S10.93 5 9 5S5.5 6.57 5.5 8.5S7.07 12 9 12m0-5c.83 0 1.5.67 1.5 1.5S9.83 10 9 10s-1.5-.67-1.5-1.5S8.17 7 9 7m7.04 6.81c1.16.84 1.96 1.96 1.96 3.44V19h4v-1.75c0-2.02-3.5-3.17-5.96-3.44M15 12c1.93 0 3.5-1.57 3.5-3.5S16.93 5 15 5c-.54 0-1.04.13-1.5.35c.63.89 1 1.98 1 3.15s-.37 2.26-1 3.15c.46.22.96.35 1.5.35" />
                    </svg>
                    Kelola Karyawan
                </a>

                @if(auth()->check() && auth()->user()->role == 'supervisor')
                    <!-- Dropdown Kelola Geolokasi -->
                    <div>
                        <a href="{{ route('admin.geolokasi.index') }}"
                            class="w-full flex items-center gap-2 p-2 rounded-lg hover:bg-red-700 focus:outline-none mt-2">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
                                <path fill="currentColor"
                                    d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7zm0 9.5c-1.38 0-2.5-1.12-2.5-2.5s1.12-2.5 2.5-2.5s2.5 1.12 2.5 2.5s-1.12 2.5-2.5 2.5z" />
                            </svg>
                            <span>Kelola Geolokasi</span>
                        </a>
                    </div>

                    <!-- Dropdown Kelola Penjadwalan -->
                    <div>
                        <button id="jadwalBtn"
                            class="w-full flex items-center justify-between p-2 rounded-lg hover:bg-red-700 focus:outline-none">
                            <div class="flex items-center gap-2">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
                                    <path fill="currentColor"
                                        d="M12 22H5a2 2 0 0 1-2-2l.01-14c0-1.1.88-2 1.99-2h1V3c0-.55.45-1 1-1s1 .45 1 1v1h8V3c0-.55.45-1 1-1s1 .45 1 1v1h1c1.1 0 2 .9 2 2v6h-2v-2H5v10h7zm10.13-5.01l.71-.71a.996.996 0 0 0 0-1.41l-.71-.71a.996.996 0 0 0-1.41 0l-.71.71zm-.71.71l-5.01 5.01c-.18.18-.44.29-.7.29H14.5c-.28 0-.5-.22-.5-.5v-1.21c0-.27.11-.52.29-.71l5.01-5.01z" />
                                </svg>
                                <span>Kelola Penjadwalan</span>
                            </div>
                            <svg id="jadwalIcon" class="w-4 h-4 transition-transform duration-200"
                                xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                            </svg>
                        </button>
                        <!-- Sub-menu -->
                        <div id="jadwalDropdown" class="hidden mt-1 space-y-1 pl-4">
                            <a href="{{ route('admin.penjadwalan.create') }}"
                                class="flex items-center gap-2 p-2 rounded-lg hover:bg-red-700 text-sm">
                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24">
                                    <path fill="currentColor"
                                        d="M19 3h-1V1h-2v2H8V1H6v2H5c-1.11 0-1.99.9-1.99 2L3 19c0 1.1.89 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zm0 16H5V8h14v11zM7 10h5v5H7v-5z" />
                                </svg>
                                Jadwal Shift
                            </a>
                            <a href="{{ route('admin.penjadwalan.index') }}"
                                class="flex items-center gap-2 p-2 rounded-lg hover:bg-red-700 text-sm">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
                                    <path fill="currentColor"
                                        d="M19 3h-1V2c0-.55-.45-1-1-1s-1 .45-1 1v1H8V2c0-.55-.45-1-1-1s-1 .45-1 1v1H5a2 2 0 0 0-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2m-7 3c1.66 0 3 1.34 3 3s-1.34 3-3 3s-3-1.34-3-3s1.34-3 3-3m6 12H6v-1c0-2 4-3.1 6-3.1s6 1.1 6 3.1z" />
                                </svg>
                                Lihat Jadwal
                            </a>
                        </div>
                    </div>

                    <!-- Dropdown Kelola Penggajian -->
                    <div>
                        <button id="gajiBtn"
                            class="w-full flex items-center justify-between p-2 rounded-lg hover:bg-red-700 focus:outline-none">
                            <div class="flex items-center gap-2">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
                                    <path fill="currentColor"
                                        d="M11.8 10.9c-2.27-.59-3-1.2-3-2.15c0-1.09 1.01-1.85 2.7-1.85c1.78 0 2.44.85 2.5 2.1h2.21c-.07-1.72-1.12-3.3-3.21-3.81V3h-3v2.16c-1.94.42-3.5 1.68-3.5 3.61c0 2.31 1.91 3.46 4.7 4.13c2.5.6 3 1.48 3 2.41c0 .69-.49 1.79-2.7 1.79c-2.06 0-2.87-.92-2.98-2.1h-2.2c.12 2.19 1.76 3.42 3.68 3.83V21h3v-2.15c1.95-.37 3.5-1.5 3.5-3.55c0-2.84-2.43-3.81-4.7-4.4" />
                                </svg>
                                <span>Kelola Penggajian</span>
                            </div>
                            <svg id="gajiIcon" class="w-4 h-4 transition-transform duration-200"
                                xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                            </svg>
                        </button>
                        <!-- Sub-menu -->
                        <div id="gajiDropdown" class="hidden mt-1 space-y-1 pl-4">
                            <a href="{{ route('admin.penggajian.komponen_gaji.index') }}"
                                class="flex items-center gap-2 p-2 rounded-lg hover:bg-red-700 text-sm">
                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24">
                                    <path fill="currentColor"
                                        d="M3 17.25V21h3.75L17.81 9.94l-3.75-3.75L3 17.25zM20.71 7.04a.996.996 0 0 0 0-1.41l-2.34-2.34a.996.996 0 0 0-1.41 0l-1.83 1.83l3.75 3.75l1.83-1.83z" />
                                </svg>
                                Komponen Gaji
                            </a>
                            <a href="{{ route('admin.penggajian.payroll') }}"
                                class="flex items-center gap-2 p-2 rounded-lg hover:bg-red-700 text-sm">
                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24">
                                    <path fill="currentColor"
                                        d="M11.8 10.9c-2.27-.59-3-1.2-3-2.15c0-1.09 1.01-1.85 2.7-1.85c1.78 0 2.44.85 2.5 2.1h2.21c-.07-1.72-1.12-3.3-3.21-3.81V3h-3v2.16c-1.94.42-3.5 1.68-3.5 3.61c0 2.31 1.91 3.46 4.7 4.13c2.5.6 3 1.48 3 2.41c0 .69-.49 1.79-2.7 1.79c-2.06 0-2.87-.92-2.98-2.1h-2.2c.12 2.19 1.76 3.42 3.68 3.83V21h3v-2.15c1.95-.37 3.5-1.5 3.5-3.55c0-2.84-2.43-3.81-4.7-4.4" />
                                </svg>
                                Payroll
                            </a>
                            <a href="{{ route('admin.penggajian.slip_gaji') }}"
                                class="flex items-center gap-2 p-2 rounded-lg hover:bg-red-700 text-sm">
                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24">
                                    <path fill="currentColor"
                                        d="M14 2H6c-1.1 0-1.99.9-1.99 2L4 20c0 1.1.89 2 1.99 2H18c1.1 0 2-.9 2-2V8l-6-6zm2 16H8v-2h8v2zm0-4H8v-2h8v2zm-3-5V3.5L18.5 9H13z" />
                                </svg>
                                Slip Gaji
                            </a>
                        </div>
                    </div>
                    <!-- Dropdown Kelola Keuangan -->
                    <div>
                        <button id="keuanganBtn"
                            class="w-full flex items-center justify-between p-2 rounded-lg hover:bg-red-700 focus:outline-none">
                            <div class="flex items-center gap-2">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
                                    <path fill="currentColor" d="M4 9h4v11H4zm12 4h4v7h-4zm-6-9h4v16h-4z" />
                                </svg>
                                <span>Kelola Keuangan</span>
                            </div>
                            <svg id="keuanganIcon" class="w-4 h-4 transition-transform duration-200"
                                xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                            </svg>
                        </button>
                        <!-- Sub-menu -->
                        <div id="keuanganDropdown" class="hidden mt-1 space-y-1 pl-4">
                            <a href="{{ route('admin.kelola_keuangan.dashboard') }}"
                                class="flex items-center gap-2 p-2 rounded-lg hover:bg-red-700 text-sm">
                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24">
                                    <path fill="currentColor"
                                        d="M3 13h8V3H3v10zm0 8h8v-6H3v6zm10 0h8V11h-8v10zm0-18v6h8V3h-8z" />
                                </svg>
                                Dashboard Keuangan
                            </a>
                            <a href="{{ route('admin.kelola_keuangan.sales.index') }}"
                                class="flex items-center gap-2 p-2 rounded-lg hover:bg-red-700 text-sm">
                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24">
                                    <path fill="currentColor"
                                        d="M16 6l2.29 2.29-4.88 4.88-4-4L2 16.59 3.41 18l6-6 4 4 6.3-6.29L22 12V6z" />
                                </svg>
                                Penjualan Harian
                            </a>
                            <a href="{{ route('admin.kelola_keuangan.cashflow.index') }}"
                                class="flex items-center gap-2 p-2 rounded-lg hover:bg-red-700 text-sm">
                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24">
                                    <path fill="currentColor"
                                        d="M3 3h18v18H3V3zm16 16V5H5v14h14zm-4-4h-2v-2h2v2zm0-4h-2v-2h2v2zm-4 4H9v-2h2v2zm0-4H9v-2h2v2z" />
                                </svg>
                                Cashflow
                            </a>
                            <a href="{{ route('admin.kelola_keuangan.laporan') }}"
                                class="flex items-center gap-2 p-2 rounded-lg hover:bg-red-700 text-sm">
                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24">
                                    <path fill="currentColor"
                                        d="M19 3H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zM9 17H7v-7h2v7zm4 0h-2V7h2v10zm4 0h-2v-4h2v4z" />
                                </svg>
                                Laporan Kas
                            </a>
                        </div>
                    </div>
                @endif
            </div>


            <!-- OPERASIONAL -->
            <div>
                <p class="text-xs text-red-200 mb-2">OPERASIONAL</p>
                <!-- Dropdown Kelola Presensi -->
                <div>
                    <button id="presensiBtn"
                        class="w-full flex items-center justify-between p-2 rounded-lg hover:bg-red-700 focus:outline-none">
                        <div class="flex items-center gap-2">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
                                <path fill="currentColor"
                                    d="M19 3h-1V2c0-.55-.45-1-1-1s-1 .45-1 1v1H8V2c0-.55-.45-1-1-1s-1 .45-1 1v1H5a2 2 0 0 0-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2m-7 3c1.66 0 3 1.34 3 3s-1.34 3-3 3s-3-1.34-3-3s1.34-3 3-3m6 12H6v-1c0-2 4-3.1 6-3.1s6 1.1 6 3.1z" />
                            </svg>
                            <span>Kelola Presensi</span>
                        </div>
                        <svg id="presensiIcon" class="w-4 h-4 transition-transform duration-200"
                            xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                        </svg>
                    </button>
                    <!-- Sub-menu -->
                    <div id="presensiDropdown" class="hidden mt-1 space-y-1 pl-4">
                        <a href="{{ route('admin.presensi.kehadiran') }}"
                            class="flex items-center gap-2 p-2 rounded-lg hover:bg-red-700 text-sm">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24">
                                <path fill="currentColor"
                                    d="M11.99 2C6.47 2 2 6.48 2 12s4.47 10 9.99 10C17.52 22 22 17.52 22 12S17.52 2 11.99 2M12 20c-4.42 0-8-3.58-8-8s3.58-8 8-8s8 3.58 8 8s-3.58 8-8 8" />
                                <path fill="currentColor" d="M12.5 7H11v6l5.25 3.15l.75-1.23l-4.5-2.67z" />
                            </svg>
                            Daftar Kehadiran
                        </a>
                    </div>
                </div>

                @if(auth()->check() && auth()->user()->role == 'supervisor')
                    <!-- Dropdown Kelola Perizinan -->
                    <div>
                        <button id="perizinanBtn"
                            class="w-full flex items-center justify-between p-2 rounded-lg hover:bg-red-700 focus:outline-none mt-2">
                            <div class="flex items-center gap-2">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
                                    <path fill="currentColor"
                                        d="M19 3H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zM9 17H7v-7h2v7zm4 0h-2V7h2v10zm4 0h-2v-4h2v4z" />
                                </svg>
                                <span>Kelola Perizinan</span>
                            </div>
                            <svg id="perizinanIcon" class="w-4 h-4 transition-transform duration-200"
                                xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                            </svg>
                        </button>
                        <!-- Sub-menu -->
                        <div id="perizinanDropdown" class="hidden mt-1 space-y-1 pl-4">
                            <a href="{{ route('admin.perizinan.index') }}"
                                class="flex items-center gap-2 p-2 rounded-lg hover:bg-red-700 text-sm">
                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24">
                                    <path fill="currentColor"
                                        d="M22 5.18L10.59 16.6l-4.24-4.24l1.41-1.41l2.83 2.83l10-10zM12 20c-4.41 0-8-3.59-8-8s3.59-8 8-8c1.57 0 3.04.46 4.28 1.25l1.45-1.45A10 10 0 0 0 12 2C6.48 2 2 6.48 2 12s4.48 10 10 10c1.73 0 3.36-.44 4.78-1.22l-1.5-1.5c-1 .46-2.11.72-3.28.72m7-5h-3v2h3v3h2v-3h3v-2h-3v-3h-2z" />
                                </svg>
                                Persetujuan Izin & Sakit
                            </a>
                        </div>
                    </div>
                @endif

                <!-- Dropdown Kelola Stok Barang -->
                <div>
                    <button id="stokBtn"
                        class="w-full flex items-center justify-between p-2 rounded-lg hover:bg-red-700 focus:outline-none">
                        <div class="flex items-center gap-2">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
                                <path fill="currentColor"
                                    d="M20 4H4v2h16zm1 10v-2l-1-5H4l-1 5v2h1v6h10v-6h4v6h2v-6zm-9 4H6v-4h6z" />
                            </svg>
                            <span>Kelola Stok Barang</span>
                        </div>
                        <svg id="stokIcon" class="w-4 h-4 transition-transform duration-200"
                            xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                        </svg>
                    </button>
                    <!-- Sub-menu -->
                    <div id="stokDropdown" class="hidden mt-1 space-y-1 pl-4">
                        <a href="{{ route('admin.kelola_barang.index') }}"
                            class="flex items-center gap-2 p-2 rounded-lg hover:bg-red-700 text-sm">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24">
                                <path fill="currentColor"
                                    d="M20 4H4v2h16zm1 10v-2l-1-5H4l-1 5v2h1v6h10v-6h4v6h2v-6zm-9 4H6v-4h6z" />
                            </svg>
                            Daftar Stok
                        </a>
                        <a href="{{ route('admin.kelola_barang.masuk') }}"
                            class="flex items-center gap-2 p-2 rounded-lg hover:bg-red-700 text-sm">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24">
                                <path fill="currentColor"
                                    d="M7 18c-1.1 0-1.99.9-1.99 2S5.9 22 7 22s2-.9 2-2s-.9-2-2-2M1 2v2h2l3.6 7.59l-1.35 2.45c-.16.28-.25.61-.25.96c0 1.1.9 2 2 2h12v-2H7.42c-.14 0-.25-.11-.25-.25l.03-.12l.9-1.63h7.45c.75 0 1.41-.41 1.75-1.03l3.58-6.49A1.003 1.003 0 0 0 20 4H5.21l-.94-2zm16 16c-1.1 0-1.99.9-1.99 2s.89 2 1.99 2s2-.9 2-2s-.9-2-2-2" />
                            </svg>
                            Barang Masuk
                        </a>
                        <a href="{{ route('admin.kelola_barang.keluar') }}"
                            class="flex items-center gap-2 p-2 rounded-lg hover:bg-red-700 text-sm">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24">
                                <path fill="currentColor"
                                    d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10v4m0 0v4m0-4H7m10 4H7" />
                            </svg>
                            Barang Keluar
                        </a>
                    </div>
                </div>
            </div>
        </nav>
    </aside>

    <div id="sidebarOverlay" class="fixed inset-0 bg-black/50 hidden z-30 md:hidden">
    </div>

    <!-- SCRIPT SIDEBAR -->
    <script>
        const menuBtn = document.getElementById('menuBtn');
        const sidebar = document.getElementById('sidebar');
        const overlay = document.getElementById('sidebarOverlay');

        if (menuBtn) {
            menuBtn.addEventListener('click', () => {
                sidebar.classList.toggle('-translate-x-full');
                overlay.classList.toggle('hidden');
            });
        }

        if (overlay) {
            overlay.addEventListener('click', () => {
                sidebar.classList.add('-translate-x-full');
                overlay.classList.add('hidden');
            });
        }

        const stokBtn = document.getElementById('stokBtn');
        const stokDropdown = document.getElementById('stokDropdown');
        const stokIcon = document.getElementById('stokIcon');

        stokBtn.addEventListener('click', () => {
            stokDropdown.classList.toggle('hidden');
            stokIcon.classList.toggle('rotate-180');
        });

        const presensiBtn = document.getElementById('presensiBtn');
        const presensiDropdown = document.getElementById('presensiDropdown');
        const presensiIcon = document.getElementById('presensiIcon');

        presensiBtn.addEventListener('click', () => {
            presensiDropdown.classList.toggle('hidden');
            presensiIcon.classList.toggle('rotate-180');
        });

        const perizinanBtn = document.getElementById('perizinanBtn');
        const perizinanDropdown = document.getElementById('perizinanDropdown');
        const perizinanIcon = document.getElementById('perizinanIcon');

        if (perizinanBtn) {
            perizinanBtn.addEventListener('click', () => {
                perizinanDropdown.classList.toggle('hidden');
                perizinanIcon.classList.toggle('rotate-180');
            });
        }

        const jadwalBtn = document.getElementById('jadwalBtn');
        const jadwalDropdown = document.getElementById('jadwalDropdown');
        const jadwalIcon = document.getElementById('jadwalIcon');

        if (jadwalBtn) {
            jadwalBtn.addEventListener('click', () => {
                jadwalDropdown.classList.toggle('hidden');
                jadwalIcon.classList.toggle('rotate-180');
            });
        }

        const gajiBtn = document.getElementById('gajiBtn');
        const gajiDropdown = document.getElementById('gajiDropdown');
        const gajiIcon = document.getElementById('gajiIcon');

        if (gajiBtn) {
            gajiBtn.addEventListener('click', () => {
                gajiDropdown.classList.toggle('hidden');
                gajiIcon.classList.toggle('rotate-180');
            });
        }

        const keuanganBtn = document.getElementById('keuanganBtn');
        const keuanganDropdown = document.getElementById('keuanganDropdown');
        const keuanganIcon = document.getElementById('keuanganIcon');

        if (keuanganBtn) {
            keuanganBtn.addEventListener('click', () => {
                keuanganDropdown.classList.toggle('hidden');
                keuanganIcon.classList.toggle('rotate-180');
            });
        }


        // Profile Dropdown Toggle
        const profileBtn = document.getElementById('profileBtn');
        const profileDropdown = document.getElementById('profileDropdown');

        if (profileBtn && profileDropdown) {
            profileBtn.addEventListener('click', (e) => {
                e.stopPropagation();
                profileDropdown.classList.toggle('hidden');
            });

            document.addEventListener('click', (e) => {
                if (!profileBtn.contains(e.target) && !profileDropdown.contains(e.target)) {
                    profileDropdown.classList.add('hidden');
                }
            });
        }
    </script>
</body>

</html>