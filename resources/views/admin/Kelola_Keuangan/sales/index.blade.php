@extends('admin.layout')

@section('title', 'Riwayat Penjualan')
@section('breadcrumb', 'Keuangan / Penjualan')

@section('content')
    <div class="space-y-5 mt-16">
        <div
            class="bg-red-800 text-white rounded-2xl px-8 py-6 shadow-md flex flex-col md:flex-row md:items-center md:justify-between gap-4 mb-6">
            <!-- Header -->
            <div>
                <h1 class="text-2xl font-bold">Riwayat Penjualan</h1>
            </div>

            <!-- Right Section -->
            <div class="flex items-center gap-4">
                <!-- Button -->
                <a href="{{ route('admin.kelola_keuangan.sales.create') }}"
                    class="inline-flex items-center gap-2 bg-white hover:bg-white text-red-800 text-sm font-semibold px-5 py-3 rounded-2xl transition-all shadow-md border border-red-700">
                    <svg class="w-4 h-4" viewBox="0 0 24 24" fill="currentColor">
                        <path d="M19 13h-6v6h-2v-6H5v-2h6V5h2v6h6z" />
                    </svg>
                    Input Penjualan Harian
                </a>
            </div>
        </div>

        {{-- ── Filter ── --}}
        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm px-5 py-4">
            <form method="GET" action="{{ route('admin.kelola_keuangan.sales.index') }}"
                class="flex flex-wrap items-end gap-3">
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

        {{-- ── Total Bulan Ini ── --}}
        <div class="bg-green-50 border border-green-200 rounded-2xl px-5 py-4 flex items-center justify-between">
            <div>
                <p class="text-xs font-semibold text-green-600 uppercase tracking-wider">Total Penjualan Bulan Ini</p>
                <p class="text-2xl font-bold text-green-700 mt-0.5">Rp {{ number_format($totalBulanIni, 0, ',', '.') }}</p>
            </div>
            <div class="w-12 h-12 bg-green-100 rounded-xl flex items-center justify-center">
                <svg class="w-6 h-6 text-green-600" viewBox="0 0 24 24" fill="currentColor">
                    <path d="M16 6l2.29 2.29-4.88 4.88-4-4L2 16.59 3.41 18l6-6 4 4 6.3-6.29L22 12V6z" />
                </svg>
            </div>
        </div>

        {{-- ── Tabel ── --}}
        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-sm">
                    <thead>
                        <tr class="bg-gray-50 border-b border-gray-100">
                            <th class="text-left px-5 py-3 text-xs font-bold text-gray-500 uppercase tracking-wider">Tanggal
                            </th>
                            <th class="text-left px-5 py-3 text-xs font-bold text-gray-500 uppercase tracking-wider">Shift
                            </th>
                            <th class="text-left px-5 py-3 text-xs font-bold text-gray-500 uppercase tracking-wider">
                                Keterangan</th>
                            <th class="text-right px-5 py-3 text-xs font-bold text-gray-500 uppercase tracking-wider">Total
                            </th>
                            <th class="text-left px-5 py-3 text-xs font-bold text-gray-500 uppercase tracking-wider">Diinput
                            </th>
                            <th class="px-5 py-3"></th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-50">
                        @forelse($sales as $s)
                                        <tr class="hover:bg-gray-50/50 transition-colors">
                                            <td class="px-5 py-3 font-medium text-gray-800 whitespace-nowrap">
                                                {{ \Carbon\Carbon::parse($s->tanggal)->format('d M Y') }}
                                            </td>
                                            <td class="px-5 py-3">
                                                <span
                                                    class="px-2 py-0.5 rounded text-xs font-semibold
                                                                                                                                                                                                                                                            {{ $s->shift === 'pagi' ? 'bg-yellow-100 text-yellow-700' :
                            ($s->shift === 'siang' ? 'bg-orange-100 text-orange-700' : 'bg-indigo-100 text-indigo-700') }}">
                                                    {{ ucfirst($s->shift) }}
                                                </span>
                                            </td>
                                            <td class="px-5 py-3 text-gray-500 max-w-[200px] truncate">{{ $s->keterangan ?? '-' }}</td>
                                            <td class="px-5 py-3 text-right font-bold text-green-700 whitespace-nowrap">
                                                Rp {{ number_format($s->total_penjualan, 0, ',', '.') }}
                                            </td>
                                            <td class="px-5 py-3 text-gray-500">{{ $s->pembuat?->nama ?? '-' }}</td>
                                            <td class="px-5 py-3">
                                                <div class="flex items-center gap-1 justify-end">
                                                    <form action="{{ route('admin.kelola_keuangan.sales.destroy', $s) }}" method="POST"
                                                        onsubmit="return confirm('Hapus data penjualan ini? Kas akan ikut diperbarui.')">
                                                        @csrf @method('DELETE')
                                                        <button type="submit"
                                                            class="w-8 h-8 rounded-lg bg-red-50 hover:bg-red-100 text-red-600 flex items-center justify-center transition-colors">
                                                            <svg class="w-4 h-4" viewBox="0 0 24 24" fill="currentColor">
                                                                <path
                                                                    d="M6 19c0 1.1.9 2 2 2h8c1.1 0 2-.9 2-2V7H6zM19 4h-3.5l-1-1h-5l-1 1H5v2h14z" />
                                                            </svg>
                                                        </button>
                                                    </form>
                                                </div>
                                            </td>
                                        </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-5 py-10 text-center text-gray-400">
                                    <svg class="w-10 h-10 mx-auto mb-2 text-gray-200" viewBox="0 0 24 24" fill="currentColor">
                                        <path
                                            d="M19 3H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2m-7 3c1.93 0 3.5 1.57 3.5 3.5S13.93 13 12 13s-3.5-1.57-3.5-3.5S10.07 6 12 6" />
                                    </svg>
                                    Belum ada data penjualan bulan ini.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if($sales->hasPages())
                <div class="px-5 py-4 border-t border-gray-50">
                    {{ $sales->links() }}
                </div>
            @endif
        </div>

    </div>
@endsection