@extends('admin.layout')

@section('title', 'Detail Penjualan')
@section('breadcrumb', 'Keuangan / Detail Penjualan')

@section('content')
<div class="max-w-2xl mx-auto space-y-5">

    <div class="flex items-center gap-3">
        <a href="{{ route('admin.kelola_keuangan.sales.index') }}"
           class="w-9 h-9 rounded-xl bg-white border border-gray-200 flex items-center justify-center text-gray-500 hover:bg-gray-50 transition-colors shadow-sm">
            <svg class="w-5 h-5" viewBox="0 0 24 24" fill="currentColor"><path d="M20 11H7.83l5.59-5.59L12 4l-8 8 8 8 1.41-1.41L7.83 13H20z"/></svg>
        </a>
        <div>
            <h1 class="text-xl font-bold text-gray-800">Detail Penjualan</h1>
            <p class="text-sm text-gray-500">{{ \Carbon\Carbon::parse($sales->tanggal)->isoFormat('dddd, D MMMM Y') }} — Shift {{ ucfirst($sales->shift) }}</p>
        </div>
    </div>

    {{-- Info Card --}}
    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-5 space-y-4">
        <div class="grid grid-cols-2 sm:grid-cols-3 gap-4">
            <div>
                <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider">Tanggal</p>
                <p class="text-sm font-bold text-gray-800 mt-0.5">{{ \Carbon\Carbon::parse($sales->tanggal)->format('d M Y') }}</p>
            </div>
            <div>
                <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider">Shift</p>
                <span class="inline-block mt-0.5 px-2 py-0.5 rounded text-xs font-semibold
                    {{ $sales->shift === 'pagi' ? 'bg-yellow-100 text-yellow-700' : ($sales->shift === 'siang' ? 'bg-orange-100 text-orange-700' : 'bg-indigo-100 text-indigo-700') }}">
                    {{ ucfirst($sales->shift) }}
                </span>
            </div>
            <div>
                <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider">Diinput oleh</p>
                <p class="text-sm font-bold text-gray-800 mt-0.5">{{ $sales->pembuat?->nama ?? '-' }}</p>
            </div>
        </div>
        @if($sales->keterangan)
        <div class="pt-3 border-t border-gray-50">
            <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider mb-1">Keterangan</p>
            <p class="text-sm text-gray-700">{{ $sales->keterangan }}</p>
        </div>
        @endif
    </div>

    {{-- Tabel Produk --}}
    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
        <div class="px-5 py-4 border-b border-gray-50">
            <h2 class="text-sm font-bold text-gray-700">Detail Produk Terjual</h2>
        </div>
        <table class="w-full text-sm">
            <thead>
                <tr class="bg-gray-50">
                    <th class="text-left px-5 py-3 text-xs font-bold text-gray-500 uppercase tracking-wider">Produk</th>
                    <th class="text-center px-4 py-3 text-xs font-bold text-gray-500 uppercase tracking-wider">Qty</th>
                    <th class="text-right px-4 py-3 text-xs font-bold text-gray-500 uppercase tracking-wider">Harga Satuan</th>
                    <th class="text-right px-5 py-3 text-xs font-bold text-gray-500 uppercase tracking-wider">Subtotal</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-50">
                @foreach($sales->details as $d)
                <tr>
                    <td class="px-5 py-3 font-medium text-gray-800">
                        {{ $d->nama_produk }}
                        @if($d->barang)
                            <span class="text-[10px] text-gray-400 font-normal ml-1">({{ $d->barang->satuan }})</span>
                        @endif
                    </td>
                    <td class="px-4 py-3 text-center text-gray-600">{{ $d->qty }}</td>
                    <td class="px-4 py-3 text-right text-gray-600">Rp {{ number_format($d->harga_satuan, 0, ',', '.') }}</td>
                    <td class="px-5 py-3 text-right font-semibold text-gray-800">Rp {{ number_format($d->subtotal, 0, ',', '.') }}</td>
                </tr>
                @endforeach
            </tbody>
            <tfoot>
                <tr class="bg-green-50">
                    <td colspan="3" class="px-5 py-3 text-sm font-bold text-gray-700 text-right">Total Penjualan</td>
                    <td class="px-5 py-3 text-right text-lg font-bold text-green-700">
                        Rp {{ number_format($sales->total_penjualan, 0, ',', '.') }}
                    </td>
                </tr>
            </tfoot>
        </table>
    </div>

    <div class="flex justify-end">
        <form action="{{ route('admin.kelola_keuangan.sales.destroy', $sales) }}" method="POST"
              onsubmit="return confirm('Hapus data penjualan ini?')">
            @csrf @method('DELETE')
            <button type="submit"
                class="inline-flex items-center gap-2 px-4 py-2.5 bg-red-50 hover:bg-red-100 text-red-700 text-sm font-semibold rounded-xl transition-colors">
                <svg class="w-4 h-4" viewBox="0 0 24 24" fill="currentColor"><path d="M6 19c0 1.1.9 2 2 2h8c1.1 0 2-.9 2-2V7H6zM19 4h-3.5l-1-1h-5l-1 1H5v2h14z"/></svg>
                Hapus Data
            </button>
        </form>
    </div>
</div>
@endsection
