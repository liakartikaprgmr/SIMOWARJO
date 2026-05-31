@extends('admin.layout')

@section('title', 'Laporan Keuangan')
@section('breadcrumb', 'Keuangan / Laporan')

@section('content')
    <div class="space-y-5 mt-16">

        {{-- ── Header ── --}}
        <div class="bg-red-800 text-white rounded-xl p-6 mb-6 shadow-md flex items-center justify-between">
            <div>
                <h1 class="text-2xl font-bold">Laporan Kas</h1>
            </div>

            <div class="flex items-center gap-2">
                <a href="{{ route('admin.kelola_keuangan.laporan.pdf') }}?bulan={{ $bulan }}&tahun={{ $tahun }}"
                    target="_blank"
                    class="inline-flex items-center gap-2 bg-white hover:bg-white text-red-800 text-sm font-semibold px-4 py-2.5 rounded-xl transition-colors shadow-sm border border-red-700">

                    <svg class="w-4 h-4" viewBox="0 0 24 24" fill="currentColor">
                        <path
                            d="M20 2H8c-1.1 0-2 .9-2 2v12c0 1.1.9 2 2 2h12c1.1 0 2-.9 2-2V4c0-1.1-.9-2-2-2m-8.5 7.5c0 .83-.67 1.5-1.5 1.5H9v2H7.5V7H10c.83 0 1.5.67 1.5 1.5zm5 2c0 .83-.67 1.5-1.5 1.5h-2.5V7H15c.83 0 1.5.67 1.5 1.5zm4-3H19v1h1.5V11H19v2h-1.5V7h3zM9 9.5h1v-1H9zM4 6H2v14c0 1.1.9 2 2 2h14v-2H4zm10 5.5h1v-3h-1z" />
                    </svg>
                    Export PDF
                </a>

                <a href="{{ route('admin.kelola_keuangan.laporan.excel') }}?bulan={{ $bulan }}&tahun={{ $tahun }}"
                    class="inline-flex items-center gap-2 bg-white hover:bg-white text-red-800 text-sm font-semibold px-4 py-2.5 rounded-xl transition-colors shadow-sm border border-red-700">

                    <svg class="w-4 h-4" viewBox="0 0 24 24" fill="currentColor">
                        <path
                            d="M14 2H6c-1.1 0-2 .9-2 2v16c0 1.1.9 2 2 2h12c1.1 0 2-.9 2-2V8zm-1 7V3.5L18.5 9H13zM8 16.01l1.5-2.01L11 16l1.5-2 1.5 2.01-3 4z" />
                    </svg>
                    Export Excel
                </a>
            </div>
        </div>

        {{-- ── Filter Periode ── --}}
        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm px-5 py-4">
            <form method="GET" action="{{ route('admin.kelola_keuangan.laporan') }}" class="flex flex-wrap items-end gap-3">
                <div>
                    <label class="text-xs font-semibold text-gray-500 uppercase tracking-wider block mb-1">Bulan</label>
                    <select name="bulan"
                        class="text-sm border border-gray-200 rounded-lg px-3 py-2 bg-white focus:outline-none focus:ring-2 focus:ring-red-300">
                        @foreach($bulanList as $b)
                            <option value="{{ $b['value'] }}" {{ $bulan == $b['value'] ? 'selected' : '' }}>{{ $b['label'] }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="text-xs font-semibold text-gray-500 uppercase tracking-wider block mb-1">Tahun</label>
                    <select name="tahun"
                        class="text-sm border border-gray-200 rounded-lg px-3 py-2 bg-white focus:outline-none focus:ring-2 focus:ring-red-300">
                        @foreach($tahunList as $t)
                            <option value="{{ $t }}" {{ $tahun == $t ? 'selected' : '' }}>{{ $t }}</option>
                        @endforeach
                    </select>
                </div>
                <button type="submit"
                    class="bg-red-800 hover:bg-red-900 text-white text-sm font-semibold px-4 py-2 rounded-lg transition-colors">
                    Tampilkan
                </button>
            </form>
        </div>

        {{-- ── Ringkasan ── --}}
        <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
            <div class="bg-green-50 border border-green-200 rounded-2xl p-5">
                <p class="text-xs font-bold text-green-600 uppercase tracking-wider">Total Pemasukan</p>
                <p class="text-2xl font-bold text-green-700 mt-1">Rp {{ number_format($totalPemasukan, 0, ',', '.') }}</p>
                @foreach($ringkasanPemasukan as $kat => $val)
                    <p class="text-xs text-green-600 mt-1">
                        {{ match ($kat) { 'sales' => 'Penjualan', default => ucfirst($kat)} }}:
                        Rp {{ number_format($val, 0, ',', '.') }}
                    </p>
                @endforeach
            </div>
            <div class="bg-red-50 border border-red-200 rounded-2xl p-5">
                <p class="text-xs font-bold text-red-600 uppercase tracking-wider">Total Pengeluaran</p>
                <p class="text-2xl font-bold text-red-700 mt-1">Rp {{ number_format($totalPengeluaran, 0, ',', '.') }}</p>
                @foreach($ringkasanPengeluaran as $kat => $val)
                    <p class="text-xs text-red-600 mt-1">
                        {{ match ($kat) { 'barang_masuk' => 'Pembelian Barang', 'gaji' => 'Penggajian', 'operasional' => 'Operasional', default => 'Lain-lain'} }}:
                        Rp {{ number_format($val, 0, ',', '.') }}
                    </p>
                @endforeach
            </div>
            <div
                class="border rounded-2xl p-5 {{ $labaBersih >= 0 ? 'bg-emerald-50 border-emerald-200' : 'bg-orange-50 border-orange-200' }}">
                <p
                    class="text-xs font-bold uppercase tracking-wider {{ $labaBersih >= 0 ? 'text-emerald-600' : 'text-orange-600' }}">
                    {{ $labaBersih >= 0 ? 'Laba Bersih' : 'Rugi Bersih' }}
                </p>
                <p class="text-2xl font-bold mt-1 {{ $labaBersih >= 0 ? 'text-emerald-700' : 'text-orange-700' }}">
                    Rp {{ number_format(abs($labaBersih), 0, ',', '.') }}
                </p>
                <p class="text-xs mt-1 {{ $labaBersih >= 0 ? 'text-emerald-600' : 'text-orange-600' }}">
                    Margin: {{ $totalPemasukan > 0 ? number_format(($labaBersih / $totalPemasukan) * 100, 1) : 0 }}%
                </p>
            </div>
        </div>

        {{-- ── Tabel Transaksi ── --}}
        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
            <div class="px-5 py-4 border-b border-gray-50">
                <h2 class="text-sm font-bold text-gray-700">Rincian Transaksi — {{ $namaBulan }} {{ $tahun }}</h2>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-sm">
                    <thead>
                        <tr class="bg-gray-50 border-b border-gray-100">
                            <th class="text-left px-5 py-3 text-xs font-bold text-gray-500 uppercase tracking-wider">Tanggal
                            </th>
                            <th class="text-left px-4 py-3 text-xs font-bold text-gray-500 uppercase tracking-wider">
                                Kategori</th>
                            <th class="text-left px-4 py-3 text-xs font-bold text-gray-500 uppercase tracking-wider">
                                Keterangan</th>
                            <th class="text-right px-4 py-3 text-xs font-bold text-green-600 uppercase tracking-wider">
                                Pemasukan</th>
                            <th class="text-right px-5 py-3 text-xs font-bold text-red-600 uppercase tracking-wider">
                                Pengeluaran</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-50">
                        @forelse($transaksi as $trx)
                            <tr class="hover:bg-gray-50/50 transition-colors">
                                <td class="px-5 py-3 text-gray-700 whitespace-nowrap">
                                    {{ \Carbon\Carbon::parse($trx->tanggal)->format('d M Y') }}
                                </td>
                                <td class="px-4 py-3">
                                    <span class="px-2 py-0.5 rounded text-xs font-semibold {{ $trx->badge_kategori }}">
                                        {{ $trx->label_kategori }}
                                    </span>
                                </td>
                                <td class="px-4 py-3 text-gray-600 max-w-xs truncate">{{ $trx->keterangan ?? '-' }}</td>
                                <td class="px-4 py-3 text-right font-semibold text-green-700">
                                    {{ $trx->jenis === 'pemasukan' ? 'Rp ' . number_format($trx->jumlah, 0, ',', '.') : '' }}
                                </td>
                                <td class="px-5 py-3 text-right font-semibold text-red-700">
                                    {{ $trx->jenis === 'pengeluaran' ? 'Rp ' . number_format($trx->jumlah, 0, ',', '.') : '' }}
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-5 py-10 text-center text-gray-400">Belum ada transaksi pada periode
                                    ini.</td>
                            </tr>
                        @endforelse
                    </tbody>
                    <tfoot class="bg-gray-50 border-t-2 border-gray-200">
                        <tr>
                            <td colspan="3" class="px-5 py-3 text-sm font-bold text-gray-700">TOTAL</td>
                            <td class="px-4 py-3 text-right text-sm font-bold text-green-700">
                                Rp {{ number_format($totalPemasukan, 0, ',', '.') }}
                            </td>
                            <td class="px-5 py-3 text-right text-sm font-bold text-red-700">
                                Rp {{ number_format($totalPengeluaran, 0, ',', '.') }}
                            </td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>

    </div>
@endsection