@extends('admin.layout')

@section('title', 'Cashflow')
@section('breadcrumb', 'Keuangan / Cashflow')

@section('content')
    <div class="space-y-5 mt-16">

        {{-- ── Header ── --}}
        <div class="bg-red-800 text-white rounded-xl p-6 mb-6 shadow-md flex items-center justify-between">
            <div>
                <h1 class="text-2xl font-bold">Manajemen Cashflow</h1>
                <p class="text-red-200 text-sm mt-1">Catat arus kas masuk dan keluar</p>
            </div>

            <div class="hidden md:block">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 text-red-300 opacity-75" fill="none"
                    viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M12 8c-1.5 0-2.5 1-2.5 2.5S10.5 13 12 13s2.5 1 2.5 2.5S13.5 18 12 18m0-14v2m0 12v2m8-10h-2M6 12H4" />
                </svg>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

            {{-- FORM INPUT CASHFLOW --}}
            <div class="lg:col-span-1">
                <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-5 sticky top-24">
                    <h2 class="text-sm font-bold text-gray-700 border-b border-gray-50 pb-3 mb-4">Input Transaksi Kas</h2>

                    <form action="{{ route('admin.kelola_keuangan.cashflow.store') }}" method="POST" class="space-y-4"
                        x-data="{ jenis: 'pemasukan' }">
                        @csrf

                        <div>
                            <label class="block text-xs font-semibold text-gray-600 mb-1.5">Tanggal <span
                                    class="text-red-500">*</span></label>
                            <input type="date" name="tanggal" value="{{ date('Y-m-d') }}" required
                                class="w-full text-sm border border-gray-200 rounded-xl px-3 py-2.5 focus:outline-none focus:ring-2 focus:ring-red-300">
                        </div>

                        <div>
                            <label class="block text-xs font-semibold text-gray-600 mb-1.5">Jenis Transaksi <span
                                    class="text-red-500">*</span></label>
                            <div class="flex gap-4">
                                <label class="flex items-center gap-2 cursor-pointer">
                                    <input type="radio" name="jenis" value="pemasukan" x-model="jenis"
                                        class="text-green-600 focus:ring-green-500">
                                    <span class="text-sm font-semibold text-green-700">Pemasukan</span>
                                </label>
                                <label class="flex items-center gap-2 cursor-pointer">
                                    <input type="radio" name="jenis" value="pengeluaran" x-model="jenis"
                                        class="text-red-600 focus:ring-red-500">
                                    <span class="text-sm font-semibold text-red-700">Pengeluaran</span>
                                </label>
                            </div>
                        </div>

                        <div>
                            <label class="block text-xs font-semibold text-gray-600 mb-1.5">Kategori <span
                                    class="text-red-500">*</span></label>
                            <select name="kategori" required
                                class="w-full text-sm border border-gray-200 rounded-xl px-3 py-2.5 focus:outline-none focus:ring-2 focus:ring-red-300">
                                <option value="">-- Pilih Kategori --</option>
                                <optgroup label="Pemasukan" x-show="jenis === 'pemasukan'">
                                    <option value="Penjualan harian">Penjualan harian</option>
                                    <option value="Modal masuk">Modal masuk</option>
                                    <option value="Piutang dibayar">Piutang dibayar</option>
                                    <option value="Pendapatan lain-lain">Pendapatan lain-lain</option>
                                </optgroup>
                                <optgroup label="Pengeluaran" x-show="jenis === 'pengeluaran'">
                                    <option value="Bahan baku">Bahan baku</option>
                                    <option value="Operasional">Operasional</option>
                                    <option value="SDM">SDM / Gaji</option>
                                    <option value="Maintenance">Maintenance</option>
                                    <option value="Marketing">Marketing</option>
                                    <option value="Administrasi">Administrasi</option>
                                    <option value="Lain-lain">Lain-lain</option>
                                </optgroup>
                            </select>
                        </div>

                        <div>
                            <label class="block text-xs font-semibold text-gray-600 mb-1.5">Jumlah (Rp) <span
                                    class="text-red-500">*</span></label>
                            <input type="number" name="jumlah" required min="1"
                                class="w-full text-sm border border-gray-200 rounded-xl px-3 py-2.5 focus:outline-none focus:ring-2 focus:ring-red-300">
                        </div>

                        <div>
                            <label class="block text-xs font-semibold text-gray-600 mb-1.5">Keterangan / Catatan</label>
                            <textarea name="keterangan" rows="2" placeholder="Catatan tambahan (opsional)..."
                                class="w-full text-sm border border-gray-200 rounded-xl px-3 py-2.5 focus:outline-none focus:ring-2 focus:ring-red-300 resize-none"></textarea>
                        </div>

                        <button type="submit"
                            class="w-full bg-green-800 hover:bg-green-900 text-white text-sm font-bold px-4 py-2.5 rounded-xl transition-all shadow-md shadow-green-100">
                            Simpan Transaksi
                        </button>
                    </form>
                </div>
            </div>

            {{-- TABEL RIWAYAT CASHFLOW --}}
            <div class="lg:col-span-2 space-y-4">

                <div class="bg-white rounded-2xl border border-gray-100 shadow-sm px-5 py-4 flex flex-wrap items-end gap-3">
                    <form method="GET" action="{{ route('admin.kelola_keuangan.cashflow.index') }}"
                        class="flex flex-wrap items-end gap-3 w-full">
                        <div>
                            <label
                                class="text-xs font-semibold text-gray-500 uppercase tracking-wider block mb-1">Bulan</label>
                            <select name="bulan"
                                class="text-sm border border-gray-200 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-red-300">
                                @foreach($bulanList as $b)
                                    <option value="{{ $b['value'] }}" {{ $bulan == $b['value'] ? 'selected' : '' }}>
                                        {{ $b['label'] }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label
                                class="text-xs font-semibold text-gray-500 uppercase tracking-wider block mb-1">Tahun</label>
                            <select name="tahun"
                                class="text-sm border border-gray-200 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-red-300">
                                @foreach($tahunList as $t)
                                    <option value="{{ $t }}" {{ $tahun == $t ? 'selected' : '' }}>{{ $t }}</option>
                                @endforeach
                            </select>
                        </div>
                        <button type="submit"
                            class="bg-gray-800 hover:bg-gray-900 text-white text-sm font-semibold px-4 py-2 rounded-lg transition-colors">
                            Filter
                        </button>
                    </form>
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div class="bg-green-50 border border-green-200 rounded-2xl px-5 py-4">
                        <p class="text-xs font-semibold text-green-600 uppercase tracking-wider mb-1">Total Pemasukan</p>
                        <p class="text-xl font-bold text-green-700">Rp {{ number_format($totalPemasukan, 0, ',', '.') }}</p>
                    </div>
                    <div class="bg-red-50 border border-red-200 rounded-2xl px-5 py-4">
                        <p class="text-xs font-semibold text-red-600 uppercase tracking-wider mb-1">Total Pengeluaran</p>
                        <p class="text-xl font-bold text-red-700">Rp {{ number_format($totalPengeluaran, 0, ',', '.') }}</p>
                    </div>
                </div>

                <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
                    <div class="overflow-x-auto">
                        <table class="w-full text-sm">
                            <thead>
                                <tr class="bg-gray-50 border-b border-gray-100">
                                    <th
                                        class="text-left px-5 py-3 text-xs font-bold text-gray-500 uppercase tracking-wider">
                                        Tgl / Kategori</th>
                                    <th
                                        class="text-left px-5 py-3 text-xs font-bold text-gray-500 uppercase tracking-wider">
                                        Keterangan</th>
                                    <th
                                        class="text-right px-5 py-3 text-xs font-bold text-gray-500 uppercase tracking-wider">
                                        Masuk</th>
                                    <th
                                        class="text-right px-5 py-3 text-xs font-bold text-gray-500 uppercase tracking-wider">
                                        Keluar</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-50">
                                @forelse($transaksi as $t)
                                    <tr class="hover:bg-gray-50/50 transition-colors">
                                        <td class="px-5 py-3">
                                            <p class="font-medium text-gray-800">
                                                {{ \Carbon\Carbon::parse($t->tanggal)->format('d M Y') }}
                                            </p>
                                            <p class="text-xs text-gray-500">{{ $t->kategori }}</p>
                                        </td>
                                        <td class="px-5 py-3 text-gray-600 text-xs">{{ $t->keterangan ?? '-' }}</td>
                                        <td class="px-5 py-3 text-right font-bold text-green-600">
                                            {{ $t->jenis === 'pemasukan' ? 'Rp ' . number_format($t->jumlah, 0, ',', '.') : '-' }}
                                        </td>
                                        <td class="px-5 py-3 text-right font-bold text-red-600">
                                            {{ $t->jenis === 'pengeluaran' ? 'Rp ' . number_format($t->jumlah, 0, ',', '.') : '-' }}
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="px-5 py-10 text-center text-gray-400">Belum ada riwayat transaksi
                                            bulan ini.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection