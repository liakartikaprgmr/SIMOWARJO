@extends('admin.layout')

@section('title', 'Input Sales Harian')
@section('breadcrumb', 'Keuangan / Input Sales')

@section('content')
    <div class="max-w-4xl mx-auto space-y-5 mt-16">

        <div class="bg-red-800 text-white rounded-xl p-6 mb-6 shadow-md flex items-center justify-between">
            <div class="flex items-center gap-3">
                <a href="{{ route('admin.kelola_keuangan.sales.index') }}"
                    class="w-9 h-9 rounded-xl bg-white border border-gray-200 flex items-center justify-center text-gray-500 hover:bg-gray-50 shadow-sm">
                    <svg class="w-5 h-5" viewBox="0 0 24 24" fill="currentColor">
                        <path d="M20 11H7.83l5.59-5.59L12 4l-8 8 8 8 1.41-1.41L7.83 13H20z" />
                    </svg>
                </a>
                <div>
                    <h1 class="text-2xl font-bold">Input Sales Harian</h1>
                    <p class="text-red-200 text-sm mt-1">Catat total penjualan per shift</p>
                </div>
            </div>

            <div class="hidden md:block">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 text-red-300 opacity-75" fill="none"
                    viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M3 10h11M9 21V3m7 18l4-4m0 0l-4-4m4 4H13" />
                </svg>
            </div>
        </div>

        <div>
            <form action="{{ route('admin.kelola_keuangan.sales.store') }}" method="POST">
                @csrf

                {{-- Info Umum --}}
                <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-5 space-y-4 mb-4">
                    <h2 class="text-sm font-bold text-gray-700 border-b border-gray-50 pb-3">Informasi Penjualan</h2>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs font-semibold text-gray-600 mb-1.5">Tanggal <span
                                    class="text-red-500">*</span></label>
                            <input type="date" name="tanggal" value="{{ old('tanggal', date('Y-m-d')) }}" required
                                class="w-full text-sm border border-gray-200 rounded-xl px-3 py-2.5 focus:outline-none focus:ring-2 focus:ring-red-300">
                            @error('tanggal')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                        </div>
                        <div>
                            <label class="block text-xs font-semibold text-gray-600 mb-1.5">Shift <span
                                    class="text-red-500">*</span></label>
                            <select name="shift" required
                                class="w-full text-sm border border-gray-200 rounded-xl px-3 py-2.5 focus:outline-none focus:ring-2 focus:ring-red-300">
                                <option value="pagi" {{ old('shift', 'pagi') == 'pagi' ? 'selected' : '' }}>Pagi</option>
                                <option value="malam" {{ old('shift') == 'malam' ? 'selected' : '' }}>Malam</option>
                            </select>
                            @error('shift')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                        </div>
                    </div>

                    <div>
                        <label class="block text-xs font-semibold text-gray-600 mb-1.5">Total Penjualan (Rp) <span
                                class="text-red-500">*</span></label>
                        <input type="number" name="total_penjualan" value="{{ old('total_penjualan', 0) }}" required min="0"
                            class="w-full text-lg font-bold text-green-700 border border-gray-200 rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-red-300">
                        @error('total_penjualan')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                    </div>

                    <div>
                        <label class="block text-xs font-semibold text-gray-600 mb-1.5">Keterangan / Catatan Shift</label>
                        <textarea name="keterangan" rows="3" placeholder="Catatan tambahan (opsional)..."
                            class="w-full text-sm border border-gray-200 rounded-xl px-3 py-2.5 focus:outline-none focus:ring-2 focus:ring-red-300 resize-none">{{ old('keterangan') }}</textarea>
                        @error('keterangan')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                    </div>
                </div>

                <div class="flex items-center justify-end gap-3 mt-6">
                    <a href="{{ route('admin.kelola_keuangan.sales.index') }}"
                        class="px-6 py-2.5 text-sm font-semibold text-gray-600 bg-white border border-gray-200 rounded-xl hover:bg-gray-50 transition-colors">
                        Batal
                    </a>
                    <button type="submit"
                        class="px-8 py-2.5 bg-green-600 hover:bg-green-700 text-white text-sm font-bold rounded-xl transition-all shadow-md shadow-green-100">
                        Simpan Penjualan
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection