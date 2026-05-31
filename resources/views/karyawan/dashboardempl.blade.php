@extends('karyawan.layoutempl')

@section('content')

    <div class="max-w-6xl mx-auto mt-2 md:mt-15 mb-2 space-y-5">

        <!-- HERO / WELCOME BANNER -->
        <div
            class="relative bg-gradient-to-r from-red-800 via-red-900 to-rose-950 text-white rounded-3xl p-8 overflow-hidden shadow-lg border border-red-700/30">
            <!-- Decorative mesh graphic -->
            <div class="absolute inset-0 bg-[radial-gradient(circle_at_top_right,rgba(254,226,226,0.15),transparent_50%)]">
            </div>
            <div class="absolute -right-16 -bottom-16 w-64 h-64 rounded-full bg-red-700/20 blur-3xl"></div>

            <div class="relative z-10 flex flex-col md:flex-row md:items-center justify-between gap-2">
                <div>
                    <p class="text-red-200 font-semibold mb-1 uppercase tracking-wider text-sm">Dashboard Employee</p>
                    <h1 class="text-3xl md:text-4xl font-extrabold tracking-tight mb-2">
                        Halo, {{ explode(' ', trim($karyawan->nama))[0] }}!
                    </h1>
                </div>

                <!-- Live Calendar Clock Pill -->
                <div
                    class="shrink-0 bg-white/10 backdrop-blur-md rounded-2xl px-5 py-4 border border-white/10 text-right md:text-left self-start md:self-center">
                    <p id="liveDate" class="text-base font-bold text-white mt-1">
                        {{ \Carbon\Carbon::now()->locale('id')->isoFormat('dddd, D MMMM YYYY') }}
                    </p>
                    <p id="liveTime" class="text-xl font-mono font-extrabold text-red-300 mt-0.5">00:00:00</p>
                </div>
            </div>
        </div>

        <!-- STATS CARDS GRID -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
            <!-- 1. STATUS ABSEN -->
            <div
                class="bg-white rounded-3xl p-6 shadow-sm border border-gray-100 hover:shadow-lg transition-all duration-300 flex items-center gap-4">
                <div
                    class="w-14 h-14 rounded-2xl bg-{{ $statusHadir == 'Sudah Absen' ? 'emerald' : 'rose' }}-100 text-{{ $statusHadir == 'Sudah Absen' ? 'emerald' : 'rose' }}-600 flex items-center justify-center shrink-0">
                    <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
                <div>
                    <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider">Absen Hari Ini</p>
                    <p class="text-xl font-bold text-gray-900 mt-1">{{ $statusHadir }}</p>
                </div>
            </div>

            <!-- 2. KEHADIRAN BULAN INI -->
            <div
                class="bg-white rounded-3xl p-6 shadow-sm border border-gray-100 hover:shadow-lg transition-all duration-300 flex items-center gap-4">
                <div class="w-14 h-14 rounded-2xl bg-sky-100 text-sky-600 flex items-center justify-center shrink-0">
                    <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z">
                        </path>
                    </svg>
                </div>
                <div>
                    <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider">Hadir Bulan Ini</p>
                    <p class="text-2xl font-bold text-gray-900 mt-1">{{ $totalHadirBulanIni }} <span
                            class="text-sm font-medium text-gray-500">Hari</span></p>
                </div>
            </div>

            <!-- 3. SHIFT HARI INI -->
            <div
                class="bg-white rounded-3xl p-6 shadow-sm border border-gray-100 hover:shadow-lg transition-all duration-300 flex items-center gap-4">
                <div class="w-14 h-14 rounded-2xl bg-amber-100 text-amber-600 flex items-center justify-center shrink-0">
                    <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
                <div>
                    <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider">Shift Hari Ini</p>
                    <p class="text-xl font-bold text-gray-900 mt-1 capitalize">{{ $shiftHariIni }}</p>
                </div>
            </div>

            <!-- 4. PERIZINAN PENDING -->
            <div
                class="bg-white rounded-3xl p-6 shadow-sm border border-gray-100 hover:shadow-lg transition-all duration-300 flex items-center gap-4">
                <div class="w-14 h-14 rounded-2xl bg-purple-100 text-purple-600 flex items-center justify-center shrink-0">
                    <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2">
                        </path>
                    </svg>
                </div>
                <div>
                    <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider">Perizinan Pending</p>
                    <p class="text-2xl font-bold text-gray-900 mt-1">{{ $perizinanPending }} <span
                            class="text-sm font-medium text-gray-500">Izin</span></p>
                </div>
            </div>
        </div>

        <!-- QUICK ACCESS MENU -->
        <div class="bg-white p-6 md:p-8 rounded-3xl shadow-sm border border-gray-100">
            <div class="mb-6">
                <h2 class="text-xl font-bold text-gray-800">Menu Akses Cepat</h2>
                <p class="text-sm text-gray-400 mt-0.5">Pintasan menuju layanan self-service Anda</p>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                <!-- Absen Kehadiran -->
                <a href="{{ route('karyawan.presensi') }}"
                    class="group p-5 rounded-2xl bg-gray-50 hover:bg-emerald-50 border border-gray-100 hover:border-emerald-200 transition-all duration-300 text-left">
                    <div
                        class="w-10 h-10 rounded-xl bg-emerald-100 text-emerald-600 flex items-center justify-center group-hover:bg-emerald-600 group-hover:text-white transition-all duration-300 mb-4 shadow-sm">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M3 9l9-7 9 7v11a2 2 0 01-2 2H5a2 2 0 01-2-2z"></path>
                            <polyline points="9 22 9 12 15 12 15 22"></polyline>
                        </svg>
                    </div>
                    <h3 class="font-bold text-gray-800 group-hover:text-emerald-700 transition-colors text-base">Mulai
                        Absen</h3>
                    <p class="text-xs text-gray-500 mt-1 leading-relaxed">Lakukan absensi masuk atau pulang hari ini.
                    </p>
                </a>

                <!-- Jadwal Shift -->
                <a href="{{ route('karyawan.jadwal_kerja') }}"
                    class="group p-5 rounded-2xl bg-gray-50 hover:bg-amber-50 border border-gray-100 hover:border-amber-200 transition-all duration-300 text-left">
                    <div
                        class="w-10 h-10 rounded-xl bg-amber-100 text-amber-600 flex items-center justify-center group-hover:bg-amber-600 group-hover:text-white transition-all duration-300 mb-4 shadow-sm">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z">
                            </path>
                        </svg>
                    </div>
                    <h3 class="font-bold text-gray-800 group-hover:text-amber-700 transition-colors text-base">Cek
                        Jadwal</h3>
                    <p class="text-xs text-gray-500 mt-1 leading-relaxed">Lihat jadwal kerja dan shift minggu ini.</p>
                </a>

                <!-- Pengajuan Izin -->
                <a href="{{ route('karyawan.izin') }}"
                    class="group p-5 rounded-2xl bg-gray-50 hover:bg-purple-50 border border-gray-100 hover:border-purple-200 transition-all duration-300 text-left">
                    <div
                        class="w-10 h-10 rounded-xl bg-purple-100 text-purple-600 flex items-center justify-center group-hover:bg-purple-600 group-hover:text-white transition-all duration-300 mb-4 shadow-sm">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z">
                            </path>
                        </svg>
                    </div>
                    <h3 class="font-bold text-gray-800 group-hover:text-purple-700 transition-colors text-base">Ajukan
                        Izin/Sakit</h3>
                    <p class="text-xs text-gray-500 mt-1 leading-relaxed">Kirim pengajuan izin, cuti, atau sakit ke
                        admin.</p>
                </a>

                <!-- Slip Gaji -->
                <a href="{{ route('karyawan.slip_gaji') }}"
                    class="group p-5 rounded-2xl bg-gray-50 hover:bg-blue-50 border border-gray-100 hover:border-blue-200 transition-all duration-300 text-left">
                    <div
                        class="w-10 h-10 rounded-xl bg-blue-100 text-blue-600 flex items-center justify-center group-hover:bg-blue-600 group-hover:text-white transition-all duration-300 mb-4 shadow-sm">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                            </path>
                        </svg>
                    </div>
                    <h3 class="font-bold text-gray-800 group-hover:text-blue-700 transition-colors text-base">Lihat Slip
                        Gaji</h3>
                    <p class="text-xs text-gray-500 mt-1 leading-relaxed">Akses dan cetak riwayat slip gaji bulanan
                        Anda.</p>
                </a>
            </div>
        </div>
    </div>

    <script>
        // LIVE TIME CLOCK SCRIPT
        function updateClock() {
            const timeElement = document.getElementById('liveTime');
            if (timeElement) {
                const now = new Date();
                const hours = String(now.getHours()).padStart(2, '0');
                const minutes = String(now.getMinutes()).padStart(2, '0');
                const seconds = String(now.getSeconds()).padStart(2, '0');
                timeElement.textContent = `${hours}:${minutes}:${seconds}`;
            }
        }
        setInterval(updateClock, 1000);
        updateClock();
    </script>

@endsection