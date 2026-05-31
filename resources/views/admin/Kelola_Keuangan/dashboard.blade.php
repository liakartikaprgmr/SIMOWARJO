@extends('admin.layout')

@section('title', 'Dashboard Keuangan')
@section('breadcrumb', 'Keuangan / Dashboard')

@section('content')
    <div class="space-y-6 mt-16 px-4 pb-12">

        {{-- HEADER & FILTER --}}
        <div class="flex flex-col lg:flex-row lg:items-center justify-between gap-4">
            <div class="bg-red-800 text-white rounded-xl p-6 mb-6 shadow-md flex items-center justify-between">
    <div>
        <h1 class="text-2xl font-bold">Dashboard Keuangan</h1>
        <p class="text-red-200 text-sm mt-1">
            Ringkasan performa finansial, pemasukan, pengeluaran, dan arus kas warung.
        </p>
    </div>

    <div class="hidden md:block">
        <svg xmlns="http://www.w3.org/2000/svg"
            class="h-12 w-12 text-red-300 opacity-75"
            fill="none"
            viewBox="0 0 24 24"
            stroke="currentColor">

            <path stroke-linecap="round"
                stroke-linejoin="round"
                stroke-width="2"
                d="M12 8c-1.657 0-3 1.343-3 3s1.343 3 3 3 3-1.343 3-3-1.343-3-3-3z" />

            <path stroke-linecap="round"
                stroke-linejoin="round"
                stroke-width="2"
                d="M19.4 15a1.65 1.65 0 00.33 1.82l.06.06a2 2 0 11-2.83 2.83l-.06-.06a1.65 1.65 0 00-1.82-.33 1.65 1.65 0 00-1 1.51V21a2 2 0 11-4 0v-.09a1.65 1.65 0 00-1-1.51 1.65 1.65 0 00-1.82.33l-.06.06a2 2 0 11-2.83-2.83l.06-.06a1.65 1.65 0 00.33-1.82 1.65 1.65 0 00-1.51-1H3a2 2 0 110-4h.09a1.65 1.65 0 001.51-1 1.65 1.65 0 00-.33-1.82l-.06-.06a2 2 0 112.83-2.83l.06.06a1.65 1.65 0 001.82.33h.01a1.65 1.65 0 001-1.51V3a2 2 0 114 0v.09a1.65 1.65 0 001 1.51h.01a1.65 1.65 0 001.82-.33l.06-.06a2 2 0 112.83 2.83l-.06.06a1.65 1.65 0 00-.33 1.82v.01a1.65 1.65 0 001.51 1H21a2 2 0 110 4h-.09a1.65 1.65 0 00-1.51 1z" />
        </svg>
    </div>
</div>

            <div class="bg-white p-2 rounded-xl shadow-sm border border-gray-100">
                <form method="GET" action="{{ route('admin.kelola_keuangan.dashboard') }}" class="flex items-center gap-2">
                    <select name="bulan"
                        class="text-sm border-none bg-gray-50 text-gray-700 rounded-lg px-3 py-2 focus:ring-2 focus:ring-red-500 cursor-pointer outline-none">
                        @foreach ($bulanList as $b)
                            <option value="{{ $b['value'] }}" {{ $bulan == $b['value'] ? 'selected' : '' }}>
                                {{ $b['label'] }}
                            </option>
                        @endforeach
                    </select>
                    <select name="tahun"
                        class="text-sm border-none bg-gray-50 text-gray-700 rounded-lg px-3 py-2 focus:ring-2 focus:ring-red-500 cursor-pointer outline-none">
                        @foreach ($tahunList as $t)
                            <option value="{{ $t }}" {{ $tahun == $t ? 'selected' : '' }}>{{ $t }}</option>
                        @endforeach
                    </select>
                    <button type="submit"
                        class="bg-red-700 hover:bg-red-800 text-white p-2 rounded-lg transition-colors shadow-sm">
                        <svg class="w-5 h-5" viewBox="0 0 24 24" fill="currentColor">
                            <path d="M10 18h4v-2h-4v2zM3 6v2h18V6H3zm3 7h12v-2H6v2z" />
                        </svg>
                    </button>
                </form>
            </div>
        </div>

        {{-- METRIK UTAMA --}}
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-5">
            {{-- Omzet Hari Ini --}}
            <div class="bg-white rounded-2xl p-5 shadow-sm border border-gray-100 hover:shadow-md transition-shadow relative overflow-hidden group">
                <div class="absolute -right-4 -top-4 w-24 h-24 bg-green-50 rounded-full opacity-50 group-hover:scale-110 transition-transform"></div>
                <div class="relative z-10 flex items-start justify-between">
                    <div>
                        <p class="text-xs font-bold text-gray-500 uppercase tracking-wider">Omzet Hari Ini</p>
                        <h3 class="text-2xl font-black text-gray-800 mt-2">Rp {{ number_format($omzetHariIni, 0, ',', '.') }}</h3>
                    </div>
                    <div class="w-10 h-10 rounded-full bg-green-100 flex items-center justify-center text-green-600">
                        <svg class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M12 2v20M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6" />
                        </svg>
                    </div>
                </div>
            </div>

            {{-- Saldo Kas --}}
            <div class="bg-white rounded-2xl p-5 shadow-sm border border-gray-100 hover:shadow-md transition-shadow relative overflow-hidden group">
                <div class="absolute -right-4 -top-4 w-24 h-24 bg-blue-50 rounded-full opacity-50 group-hover:scale-110 transition-transform"></div>
                <div class="relative z-10 flex items-start justify-between">
                    <div>
                        <p class="text-xs font-bold text-gray-500 uppercase tracking-wider">Saldo Kas Saat Ini</p>
                        <h3 class="text-2xl font-black text-gray-800 mt-2">Rp {{ number_format($saldoKas, 0, ',', '.') }}</h3>
                    </div>
                    <div class="w-10 h-10 rounded-full bg-blue-100 flex items-center justify-center text-blue-600">
                        <svg class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <rect x="2" y="5" width="20" height="14" rx="2" />
                            <path d="M2 10h20" />
                        </svg>
                    </div>
                </div>
            </div>

            {{-- Laba Estimasi (Bulan Ini) --}}
            <div class="bg-white rounded-2xl p-5 shadow-sm border border-gray-100 hover:shadow-md transition-shadow relative overflow-hidden group">
                <div class="absolute -right-4 -top-4 w-24 h-24 {{ $labaBersih >= 0 ? 'bg-emerald-50' : 'bg-red-50' }} rounded-full opacity-50 group-hover:scale-110 transition-transform"></div>
                <div class="relative z-10 flex items-start justify-between">
                    <div>
                        <p class="text-xs font-bold text-gray-500 uppercase tracking-wider">Laba / Rugi Bulan Ini</p>
                        <h3 class="text-2xl font-black {{ $labaBersih >= 0 ? 'text-emerald-600' : 'text-red-600' }} mt-2">
                            Rp {{ number_format(abs($labaBersih), 0, ',', '.') }}
                        </h3>
                    </div>
                    <div class="w-10 h-10 rounded-full {{ $labaBersih >= 0 ? 'bg-emerald-100 text-emerald-600' : 'bg-red-100 text-red-600' }} flex items-center justify-center">
                        @if($labaBersih >= 0)
                            <svg class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M23 6l-9.5 9.5-5-5L1 18"/><path d="M17 6h6v6"/></svg>
                        @else
                            <svg class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M23 18l-9.5-9.5-5 5L1 6"/><path d="M17 18h6v-6"/></svg>
                        @endif
                    </div>
                </div>
            </div>

            {{-- Pengeluaran Terbesar --}}
            <div class="bg-white rounded-2xl p-5 shadow-sm border border-gray-100 hover:shadow-md transition-shadow relative overflow-hidden group">
                <div class="absolute -right-4 -top-4 w-24 h-24 bg-orange-50 rounded-full opacity-50 group-hover:scale-110 transition-transform"></div>
                <div class="relative z-10 flex items-start justify-between">
                    <div>
                        <p class="text-xs font-bold text-gray-500 uppercase tracking-wider">Pengeluaran Terbesar</p>
                        @if($pengeluaranTerbesar)
                            <h3 class="text-xl font-black text-orange-600 mt-2 truncate max-w-[140px]" title="{{ $pengeluaranTerbesar->kategori }}">{{ ucfirst($pengeluaranTerbesar->kategori) }}</h3>
                            <p class="text-xs text-gray-500 mt-1 font-semibold">Rp {{ number_format($pengeluaranTerbesar->jumlah, 0, ',', '.') }}</p>
                        @else
                            <h3 class="text-xl font-black text-gray-400 mt-2">-</h3>
                        @endif
                    </div>
                    <div class="w-10 h-10 rounded-full bg-orange-100 flex items-center justify-center text-orange-600">
                        <svg class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M12 2v20M17 19H9.5a3.5 3.5 0 0 1 0-7h5a3.5 3.5 0 0 0 0-7H6" />
                        </svg>
                    </div>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            {{-- BAGIAN KIRI: GRAFIK & CASHFLOW --}}
            <div class="lg:col-span-2 space-y-6">
                
                {{-- Grafik Penjualan --}}
                <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-5">
                    <h2 class="text-base font-bold text-gray-800 mb-4 flex items-center gap-2">
                        <svg class="w-5 h-5 text-indigo-500" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M3 3v18h18"/><path d="M18 9l-5 5-4-4-4 4"/></svg>
                        Grafik Penjualan Harian
                    </h2>
                    <div class="relative h-64">
                        <canvas id="salesChart"></canvas>
                    </div>
                </div>

                {{-- Cash In vs Cash Out Progress --}}
                <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-5">
                    <h2 class="text-base font-bold text-gray-800 mb-4 flex items-center gap-2">
                        <svg class="w-5 h-5 text-teal-500" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21.21 15.89A10 10 0 1 1 8 2.83"/><path d="M22 12A10 10 0 0 0 12 2v10z"/></svg>
                        Cash In vs Cash Out
                    </h2>
                    
                    @php
                        $total = $totalPemasukan + $totalPengeluaran;
                        $pctIn = $total > 0 ? ($totalPemasukan / $total) * 100 : 0;
                        $pctOut = $total > 0 ? ($totalPengeluaran / $total) * 100 : 0;
                    @endphp

                    <div class="mb-2 flex justify-between text-sm font-bold">
                        <span class="text-green-600">Pemasukan ({{ number_format($pctIn, 1) }}%)</span>
                        <span class="text-red-600">Pengeluaran ({{ number_format($pctOut, 1) }}%)</span>
                    </div>
                    
                    <div class="flex h-4 w-full rounded-full overflow-hidden bg-gray-100">
                        <div style="width: {{ $pctIn }}%" class="bg-green-500 transition-all duration-1000"></div>
                        <div style="width: {{ $pctOut }}%" class="bg-red-500 transition-all duration-1000"></div>
                    </div>
                    
                    <div class="flex justify-between mt-3 text-sm">
                        <span class="font-semibold text-gray-700">Rp {{ number_format($totalPemasukan, 0, ',', '.') }}</span>
                        <span class="font-semibold text-gray-700">Rp {{ number_format($totalPengeluaran, 0, ',', '.') }}</span>
                    </div>
                </div>

            </div>

            {{-- BAGIAN KANAN: SHIFT & TRANSAKSI TERBARU --}}
            <div class="lg:col-span-1 space-y-6">
                
                {{-- Performa Shift --}}
                <div class="bg-gradient-to-br from-red-800 to-red-900 rounded-2xl shadow-sm p-5 text-white">
                    <h2 class="text-base font-bold mb-4 flex items-center gap-2">
                        <svg class="w-5 h-5 text-red-200" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
                        Performa Shift
                    </h2>
                    <div class="space-y-4">
                        @php
                            $shifts = ['pagi' => 'Pagi','malam' => 'Malam'];
                            $maxShift = $performaShift->max() ?: 1;
                        @endphp
                        @foreach($shifts as $key => $label)
                            @php
                                $val = $performaShift[$key] ?? 0;
                                $pct = ($val / $maxShift) * 100;
                            @endphp
                            <div>
                                <div class="flex justify-between text-xs font-semibold mb-1">
                                    <span>{{ $label }}</span>
                                    <span>Rp {{ number_format($val, 0, ',', '.') }}</span>
                                </div>
                                <div class="w-full bg-red-950/50 rounded-full h-2">
                                    <div class="bg-white h-2 rounded-full transition-all duration-1000" style="width: {{ $pct }}%"></div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>

                {{-- Transaksi Terbaru --}}
                <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden flex flex-col h-[400px]">
                    <div class="p-4 border-b border-gray-50 flex items-center justify-between bg-gray-50/50">
                        <h2 class="text-sm font-bold text-gray-800 flex items-center gap-2">
                            <svg class="w-4 h-4 text-gray-500" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="22 12 18 12 15 21 9 3 6 12 2 12"/></svg>
                            Transaksi Terbaru
                        </h2>
                        <a href="{{ route('admin.kelola_keuangan.cashflow.index') }}" class="text-xs text-red-600 font-semibold hover:underline">Lihat Semua</a>
                    </div>
                    <div class="flex-1 overflow-y-auto p-4 space-y-4">
                        @forelse($transaksiTerbaru as $trx)
                            <div class="flex items-center justify-between group">
                                <div class="flex items-center gap-3">
                                    <div class="w-8 h-8 rounded-full flex items-center justify-center {{ $trx->jenis === 'pemasukan' ? 'bg-green-100 text-green-600' : 'bg-red-100 text-red-600' }}">
                                        @if($trx->jenis === 'pemasukan')
                                            <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 19V5M5 12l7-7 7 7"/></svg>
                                        @else
                                            <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 5v14M19 12l-7 7-7-7"/></svg>
                                        @endif
                                    </div>
                                    <div>
                                        <p class="text-xs font-bold text-gray-800">{{ ucfirst($trx->kategori) }}</p>
                                        <p class="text-[10px] text-gray-400">{{ \Carbon\Carbon::parse($trx->tanggal)->format('d M Y') }}</p>
                                    </div>
                                </div>
                                <div class="text-right">
                                    <p class="text-xs font-bold {{ $trx->jenis === 'pemasukan' ? 'text-green-600' : 'text-red-600' }}">
                                        {{ $trx->jenis === 'pemasukan' ? '+' : '-' }} Rp {{ number_format($trx->jumlah, 0, ',', '.') }}
                                    </p>
                                </div>
                            </div>
                        @empty
                            <p class="text-xs text-center text-gray-400 py-4">Belum ada transaksi</p>
                        @endforelse
                    </div>
                </div>

            </div>
        </div>
    </div>

    {{-- CHART.JS --}}
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const ctx = document.getElementById('salesChart').getContext('2d');
            
            // Gradient Fill for Line Chart
            let gradient = ctx.createLinearGradient(0, 0, 0, 400);
            gradient.addColorStop(0, 'rgba(79, 70, 229, 0.2)'); // Indigo
            gradient.addColorStop(1, 'rgba(79, 70, 229, 0)');

            new Chart(ctx, {
                type: 'line',
                data: {
                    labels: @json($chartLabels),
                    datasets: [{
                        label: 'Penjualan Harian (Rp)',
                        data: @json($chartPenjualan),
                        borderColor: '#4f46e5',
                        backgroundColor: gradient,
                        borderWidth: 2,
                        pointBackgroundColor: '#ffffff',
                        pointBorderColor: '#4f46e5',
                        pointBorderWidth: 2,
                        pointRadius: 4,
                        pointHoverRadius: 6,
                        fill: true,
                        tension: 0.4 // smooth curve
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: { display: false },
                        tooltip: {
                            backgroundColor: '#1f2937',
                            padding: 12,
                            titleFont: { size: 13 },
                            bodyFont: { size: 13, weight: 'bold' },
                            callbacks: {
                                label: function(context) {
                                    let value = context.parsed.y;
                                    return 'Rp ' + new Intl.NumberFormat('id-ID').format(value);
                                }
                            }
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            grid: { color: '#f3f4f6', drawBorder: false },
                            ticks: {
                                font: { size: 10 },
                                color: '#9ca3af',
                                callback: function(value) {
                                    if(value >= 1000000) return (value/1000000) + 'M';
                                    if(value >= 1000) return (value/1000) + 'k';
                                    return value;
                                }
                            }
                        },
                        x: {
                            grid: { display: false, drawBorder: false },
                            ticks: { font: { size: 10 }, color: '#9ca3af' }
                        }
                    },
                    interaction: { mode: 'index', intersect: false }
                }
            });
        });
    </script>
@endsection