@extends('admin.layout')

@section('content')

    <div class="space-y-8 mt-12 pb-12">

        <!-- HERO / WELCOME BANNER -->
        <div
            class="relative bg-gradient-to-r from-red-800 via-red-900 to-rose-950 text-white rounded-3xl p-8 overflow-hidden shadow-lg border border-red-700/30">
            <!-- Decorative mesh graphic -->
            <div class="absolute inset-0 bg-[radial-gradient(circle_at_top_right,rgba(254,226,226,0.15),transparent_50%)]">
            </div>
            <div class="absolute -right-16 -bottom-16 w-64 h-64 rounded-full bg-red-700/20 blur-3xl"></div>

            <div class="relative z-10 flex flex-col md:flex-row md:items-center justify-between gap-6">
                <div>
                    <h1 class="text-3xl md:text-4xl font-extrabold tracking-tight mb-2">
                        Dashboard Admin
                    </h1>

                    @if($perizinanPending > 0)
                        <div
                            class="mt-4 inline-flex items-center gap-2 px-3 py-1.5 rounded-full bg-amber-500/20 text-amber-300 border border-amber-500/30 text-xs font-semibold shadow-sm animate-pulse">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z">
                                </path>
                            </svg>
                            Terdapat <strong>{{ $perizinanPending }}</strong> pengajuan izin/sakit yang membutuhkan persetujuan
                            Anda.
                        </div>
                    @endif
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

        {{-- STATISTIK DASHBOARD --}}
        <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-5 gap-2 mb-8">

            {{-- 1. TOTAL KARYAWAN --}}
            <div
                class="bg-white rounded-3xl p-5 shadow-sm border border-gray-100 hover:shadow-lg transition-all duration-300">
                <div class="flex items-start justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-400 uppercase tracking-wide">
                            Total Karyawan
                        </p>
                        <h3 class="text-4xl font-bold text-gray-900 mt-3">
                            {{ $totalKaryawan }}
                        </h3>
                        <span class="text-sm text-gray-500">
                            Orang
                        </span>
                    </div>
                    <div class="w-10 h-10 rounded-2xl bg-sky-100 text-sky-600 flex items-center justify-center shrink-0">
                        <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z">
                            </path>
                        </svg>
                    </div>
                </div>
            </div>

            {{-- 2. HADIR HARI INI --}}
            <div
                class="bg-white rounded-3xl p-5 shadow-sm border border-gray-100 hover:shadow-lg transition-all duration-300">
                <div class="flex items-start justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-400 uppercase tracking-wide">
                            Hadir Hari Ini
                        </p>
                        <h3 class="text-4xl font-bold text-gray-900 mt-3">
                            {{ $kehadiranHariIni }}
                        </h3>
                        <span class="text-sm text-gray-500">
                            Orang
                        </span>
                    </div>
                    <div
                        class="w-10 h-10 rounded-2xl bg-emerald-100 text-emerald-600 flex items-center justify-center shrink-0">
                        <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4">
                            </path>
                        </svg>
                    </div>
                </div>
            </div>

            {{-- 3. PENDAPATAN --}}
            <div
                class="bg-white rounded-3xl p-5 shadow-sm border border-gray-100 hover:shadow-lg transition-all duration-300 overflow-hidden">
                <div class="flex items-start gap-3">
                    <div class="flex-1 min-w-0">
                        <p class="text-sm font-medium text-gray-400 uppercase tracking-wide">
                            Pendapatan Bulan Ini
                        </p>
                        <h3 class="text-2xl font-bold text-gray-900 mt-3 break-words leading-tight">
                            Rp {{ number_format($pendapatanBulanIni, 0) }}
                        </h3>
                    </div>
                    <div class="w-10 h-10 rounded-2xl bg-teal-100 text-teal-600 flex items-center justify-center shrink-0">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z">
                            </path>
                        </svg>
                    </div>

                </div>
            </div>

            {{-- 4. STOK BARANG --}}
            <div
                class="bg-white rounded-3xl p-5 shadow-sm border border-gray-100 hover:shadow-lg transition-all duration-300">
                <div class="flex items-start justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-400 uppercase tracking-wide">
                            Stok Barang
                        </p>
                        <h3 class="text-4xl font-bold text-gray-900 mt-3">
                            {{ number_format($totalStokBarang, 0, ',', '.') }}
                        </h3>
                        <span class="text-sm text-gray-500">
                            Unit
                        </span>
                    </div>
                    <div
                        class="w-10 h-10 rounded-2xl bg-amber-100 text-amber-600 flex items-center justify-center shrink-0">
                        <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4">
                            </path>
                        </svg>
                    </div>
                </div>
            </div>

            {{-- 5. PERIZINAN --}}
            <div
                class="bg-white rounded-3xl p-5 shadow-sm border border-gray-100 hover:shadow-lg transition-all duration-300">
                <div class="flex items-start justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-400 uppercase tracking-wide">
                            Perizinan Pending
                        </p>
                        <h3 class="text-4xl font-bold text-gray-900 mt-3">
                            {{ $perizinanPending }}
                        </h3>
                        <span class="text-sm text-gray-500">
                            Izin
                        </span>
                    </div>
                    <div class="w-10 h-10 rounded-2xl bg-rose-100 text-rose-600 flex items-center justify-center shrink-0">
                        <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 12h6m-3-3v6m8 0A9 9 0 1112 3a9 9 0 019 9z">
                            </path>
                        </svg>
                    </div>
                </div>
            </div>

        </div>

        <!-- CHARTS SECTION -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

            <!-- COMPARATIVE FINANCIAL TRENDS CHART (Pemasukan vs Pengeluaran) -->
            <div class="bg-white p-6 rounded-3xl shadow-sm border border-gray-100 lg:col-span-2">
                <div class="flex items-center justify-between mb-6">
                    <div>
                        <h2 class="text-lg font-bold text-gray-800">Analisis Pendapatan & Pengeluaran</h2>
                        <p class="text-xs text-gray-400 mt-0.5">Tren arus kas dalam 6 bulan terakhir</p>
                    </div>
                    <!-- Legend Indicators -->
                    <div class="flex items-center gap-3 text-xs font-semibold">
                        <span class="inline-flex items-center gap-1"><span
                                class="w-2.5 h-2.5 rounded-full bg-teal-500"></span> Pendapatan</span>
                        <span class="inline-flex items-center gap-1"><span
                                class="w-2.5 h-2.5 rounded-full bg-rose-500"></span> Pengeluaran</span>
                    </div>
                </div>
                <div class="h-80 relative">
                    <canvas id="financialChart"></canvas>
                </div>
            </div>

            <!-- INVENTORY STOCK DISTRIBUTION BY CATEGORY -->
            <div class="bg-white p-6 rounded-3xl shadow-sm border border-gray-100">
                <div>
                    <h2 class="text-lg font-bold text-gray-800">Penyebaran Stok Barang</h2>
                    <p class="text-xs text-gray-400 mt-0.5">Distribusi unit barang berdasarkan kategori</p>
                </div>
                <div class="relative h-64 mt-6 flex items-center justify-center">
                    <canvas id="categoryStockChart"></canvas>
                </div>
                <div
                    class="mt-4 border-t border-gray-50 pt-4 flex flex-wrap justify-center gap-x-4 gap-y-2 text-[10px] font-semibold text-gray-500">
                    <!-- Dynamic legend will be built by chart.js or custom script below -->
                    <span>*Hanya menampilkan kategori dengan stok aktif</span>
                </div>
            </div>

        </div>

        @if(auth()->check() && auth()->user()->role == 'supervisor')
        <!-- QUICK ACCESS / QUICK ACTIONS CONTROL CENTER -->
        <div class="bg-white p-8 rounded-3xl shadow-sm border border-gray-100">
            <div class="mb-6">
                <h2 class="text-xl font-bold text-gray-800">Pusat Kendali Cepat</h2>
                <p class="text-sm text-gray-400 mt-0.5">Pintasan praktis untuk mengakses fitur-fitur utama sistem</p>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                <!-- 1. Kelola Karyawan Link -->
                <a href="/admin/kelola_karyawan"
                    class="group p-5 rounded-2xl bg-gray-50 hover:bg-red-50 border border-gray-100 hover:border-red-200 transition-all duration-300 text-left">
                    <div
                        class="w-10 h-10 rounded-xl bg-sky-100 text-sky-600 flex items-center justify-center group-hover:bg-red-800 group-hover:text-white transition-all duration-300 mb-4 shadow-sm">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                            xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z">
                            </path>
                        </svg>
                    </div>
                    <h3 class="font-bold text-gray-800 group-hover:text-red-800 transition-colors text-base">Kelola Karyawan
                    </h3>
                    <p class="text-xs text-gray-400 mt-1 leading-relaxed">Tambah baru, edit profile, bank account, dan peran
                        user.</p>
                </a>

                <!-- 2. Penjadwalan Shift Link -->
                <a href="{{ route('admin.penjadwalan.index') }}"
                    class="group p-5 rounded-2xl bg-gray-50 hover:bg-red-50 border border-gray-100 hover:border-red-200 transition-all duration-300 text-left">
                    <div
                        class="w-10 h-10 rounded-xl bg-amber-100 text-amber-600 flex items-center justify-center group-hover:bg-red-800 group-hover:text-white transition-all duration-300 mb-4 shadow-sm">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                            xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z">
                            </path>
                        </svg>
                    </div>
                    <h3 class="font-bold text-gray-800 group-hover:text-red-800 transition-colors text-base">Penjadwalan
                        Shift</h3>
                    <p class="text-xs text-gray-400 mt-1 leading-relaxed">Kelola kalender shift kerja (Pagi / Malam) seluruh
                        divisi.</p>
                </a>

                <!-- 3. Persetujuan Perizinan Link -->
                <a href="{{ route('admin.perizinan.index') }}"
                    class="group p-5 rounded-2xl bg-gray-50 hover:bg-red-50 border border-gray-100 hover:border-red-200 transition-all duration-300 text-left">
                    <div
                        class="w-10 h-10 rounded-xl bg-rose-100 text-rose-600 flex items-center justify-center group-hover:bg-red-800 group-hover:text-white transition-all duration-300 mb-4 shadow-sm">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                            xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <h3 class="font-bold text-gray-800 group-hover:text-red-800 transition-colors text-base">Persetujuan
                        Izin</h3>
                    <p class="text-xs text-gray-400 mt-1 leading-relaxed">Konfirmasi status perizinan, dispensasi sakit,
                        atau dinas.</p>
                </a>

                <!-- 4. Payroll System Link -->
                <a href="{{ route('admin.penggajian.payroll') }}"
                    class="group p-5 rounded-2xl bg-gray-50 hover:bg-red-50 border border-gray-100 hover:border-red-200 transition-all duration-300 text-left">
                    <div
                        class="w-10 h-10 rounded-xl bg-teal-100 text-teal-600 flex items-center justify-center group-hover:bg-red-800 group-hover:text-white transition-all duration-300 mb-4 shadow-sm">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                            xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z">
                            </path>
                        </svg>
                    </div>
                    <h3 class="font-bold text-gray-800 group-hover:text-red-800 transition-colors text-base">Manajemen
                        Payroll</h3>
                    <p class="text-xs text-gray-400 mt-1 leading-relaxed">Kalkulasi gaji pokok, insentif, potongan absensi,
                        & slip gaji.</p>
                </a>
            </div>
        </div>
        @endif

    </div>

    <!-- CHART JS -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

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

        // 1. COMPARATIVE FINANCIAL CHART (Pemasukan vs Pengeluaran)
        const financialCtx = document.getElementById('financialChart').getContext('2d');

        new Chart(financialCtx, {
            type: 'bar',
            data: {
                labels: {!! json_encode($financialLabels) !!},
                datasets: [
                    {
                        label: 'Pendapatan',
                        data: {!! json_encode($incomeData) !!},
                        backgroundColor: '#0d9488', // Teal 600
                        borderRadius: 8,
                        borderSkipped: false,
                        barPercentage: 0.6,
                        categoryPercentage: 0.7
                    },
                    {
                        label: 'Pengeluaran',
                        data: {!! json_encode($expenseData) !!},
                        backgroundColor: '#f43f5e', // Rose 500
                        borderRadius: 8,
                        borderSkipped: false,
                        barPercentage: 0.6,
                        categoryPercentage: 0.7
                    }
                ]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: false // We use our own customized header legends
                    },
                    tooltip: {
                        padding: 12,
                        cornerRadius: 12,
                        backgroundColor: 'rgba(15, 23, 42, 0.95)',
                        titleColor: '#fff',
                        bodyColor: '#cbd5e1',
                        callbacks: {
                            label: function (context) {
                                let label = context.dataset.label || '';
                                if (label) {
                                    label += ': ';
                                }
                                if (context.parsed.y !== null) {
                                    label += new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR', maximumFractionDigits: 0 }).format(context.parsed.y);
                                }
                                return label;
                            }
                        }
                    }
                },
                scales: {
                    x: {
                        grid: {
                            display: false
                        },
                        ticks: {
                            color: '#94a3b8',
                            font: {
                                size: 11,
                                weight: '500'
                            }
                        }
                    },
                    y: {
                        grid: {
                            color: '#f1f5f9'
                        },
                        ticks: {
                            color: '#94a3b8',
                            font: {
                                size: 10
                            },
                            callback: function (value) {
                                if (value >= 1e6) return 'Rp ' + (value / 1e6) + 'jt';
                                if (value >= 1e3) return 'Rp ' + (value / 1e3) + 'rb';
                                return 'Rp ' + value;
                            }
                        }
                    }
                }
            }
        });

        // 2. CATEGORY STOCK DISTRIBUTION DOUGHNUT CHART
        const categoryStockCtx = document.getElementById('categoryStockChart').getContext('2d');

        new Chart(categoryStockCtx, {
            type: 'doughnut',
            data: {
                labels: {!! json_encode($kategoriLabels) !!},
                datasets: [{
                    data: {!! json_encode($kategoriData) !!},
                    backgroundColor: [
                        '#6366f1', // Indigo
                        '#8b5cf6', // Purple
                        '#ec4899', // Pink
                        '#f59e0b', // Amber
                        '#3b82f6', // Blue
                        '#14b8a6', // Teal
                        '#10b981', // Emerald
                        '#64748b'  // Slate
                    ],
                    borderWidth: 3,
                    borderColor: '#ffffff',
                    hoverOffset: 8
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                cutout: '72%',
                plugins: {
                    legend: {
                        position: 'bottom',
                        labels: {
                            boxWidth: 8,
                            padding: 12,
                            color: '#64748b',
                            font: {
                                size: 10,
                                weight: '500'
                            }
                        }
                    },
                    tooltip: {
                        padding: 12,
                        cornerRadius: 12,
                        backgroundColor: 'rgba(15, 23, 42, 0.95)',
                        callbacks: {
                            label: function (context) {
                                const val = context.parsed;
                                return ' ' + context.label + ': ' + val.toLocaleString('id-ID') + ' Unit';
                            }
                        }
                    }
                }
            }
        });
    </script>

@endsection