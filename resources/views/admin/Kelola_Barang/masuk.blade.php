@extends('admin.layout')

@section('content')
<div class="mt-16">

    {{-- HEADER --}}
    <div class="bg-green-700 text-white rounded-xl p-6 mb-6 flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-bold">Barang Masuk</h1>
            <p class="text-green-200 text-sm mt-1">Catat penerimaan barang dari supplier</p>
        </div>
        <a href="{{ route('admin.kelola_barang.index') }}" class="bg-white text-green-700 font-semibold px-4 py-2 rounded-lg hover:bg-green-50 text-sm">
            ← Kembali ke Stok
        </a>
    </div>

    {{-- NOTIF --}}
    @if(session('success'))
    <div class="bg-green-100 border border-green-400 text-green-800 px-4 py-3 rounded-xl mb-4 flex items-center gap-2">
        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24"><path fill="currentColor" d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10s10-4.48 10-10S17.52 2 12 2m-2 15l-5-5l1.41-1.41L10 14.17l7.59-7.59L19 8z"/></svg>
        {{ session('success') }}
    </div>
    @endif
    @if($errors->any())
    <div class="bg-red-100 border border-red-400 text-red-800 px-4 py-3 rounded-xl mb-4">
        @foreach($errors->all() as $e)<p>• {{ $e }}</p>@endforeach
    </div>
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

        {{-- FORM --}}
        <div class="lg:col-span-1">
            <div class="bg-white rounded-xl shadow p-6">
                <h2 class="font-bold text-gray-800 mb-4 flex items-center gap-2">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" class="text-green-600"><path fill="currentColor" d="M19 3H5c-1.11 0-2 .9-2 2v14c0 1.1.89 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2m-2 10h-4v4h-2v-4H7l5-5z"/></svg>
                    Form Barang Masuk
                </h2>
                <form action="{{ route('admin.kelola_barang.masuk.store') }}" method="POST" class="space-y-4">
                    @csrf
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Barang <span class="text-red-500">*</span></label>
                        <select name="id_barang" required
                            class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-green-500">
                            <option value="">-- Pilih Barang --</option>
                            @foreach($barang as $b)
                            <option value="{{ $b->id }}" {{ old('id_barang') == $b->id ? 'selected' : '' }}>
                                {{ $b->nama }} (Stok: {{ $b->stok_saat_ini }} {{ $b->satuan }})
                            </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="grid grid-cols-2 gap-3">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Jumlah <span class="text-red-500">*</span></label>
                            <input type="number" name="jumlah" min="1" value="{{ old('jumlah') }}" required
                                class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-green-500">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Harga Satuan <span class="text-red-500">*</span></label>
                            <input type="number" name="harga_satuan" min="0" value="{{ old('harga_satuan', 0) }}" required
                                class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-green-500">
                        </div>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Supplier <span class="text-red-500">*</span></label>
                        <input type="text" name="supplier" value="{{ old('supplier') }}" required
                            class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-green-500"
                            placeholder="Nama supplier / toko">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">No. Faktur</label>
                        <input type="text" name="no_faktur" value="{{ old('no_faktur') }}"
                            class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-green-500"
                            placeholder="Opsional">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Tanggal <span class="text-red-500">*</span></label>
                        <input type="date" name="tanggal" value="{{ old('tanggal', date('Y-m-d')) }}" required
                            class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-green-500">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Catatan</label>
                        <textarea name="catatan" rows="2"
                            class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-green-500"
                            placeholder="Opsional">{{ old('catatan') }}</textarea>
                    </div>
                    <button type="submit"
                        class="w-full bg-green-600 hover:bg-green-700 text-white font-semibold py-2.5 rounded-lg transition">
                        Simpan Barang Masuk
                    </button>
                </form>
            </div>
        </div>

        {{-- RIWAYAT --}}
        <div class="lg:col-span-2">
            <div class="bg-white rounded-xl shadow overflow-hidden">
                <div class="p-4 border-b flex items-center justify-between flex-wrap gap-3">
                    <h2 class="font-bold text-gray-800">Riwayat Barang Masuk</h2>
                    {{-- FILTER --}}
                    <form method="GET" class="flex flex-wrap gap-2 items-end">
                        <div>
                            <label class="block text-xs text-gray-500 mb-1">Dari</label>
                            <input type="date" name="tanggal_dari" value="{{ request('tanggal_dari') }}"
                                class="border border-gray-300 rounded px-2 py-1 text-xs">
                        </div>
                        <div>
                            <label class="block text-xs text-gray-500 mb-1">Sampai</label>
                            <input type="date" name="tanggal_sampai" value="{{ request('tanggal_sampai') }}"
                                class="border border-gray-300 rounded px-2 py-1 text-xs">
                        </div>
                        <div>
                            <label class="block text-xs text-gray-500 mb-1">Supplier</label>
                            <input type="text" name="supplier" value="{{ request('supplier') }}" placeholder="Cari..."
                                class="border border-gray-300 rounded px-2 py-1 text-xs w-28">
                        </div>
                        <button class="bg-gray-800 text-white px-3 py-1 rounded text-xs">Filter</button>
                        <a href="{{ route('admin.kelola_barang.masuk') }}" class="bg-gray-200 text-gray-700 px-3 py-1 rounded text-xs">Reset</a>
                    </form>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full text-sm">
                        <thead class="bg-gray-50 text-gray-600 uppercase text-xs">
                            <tr>
                                <th class="px-4 py-3 text-left">Tanggal</th>
                                <th class="px-4 py-3 text-left">Barang</th>
                                <th class="px-4 py-3 text-center">Jumlah</th>
                                <th class="px-4 py-3 text-left">Supplier</th>
                                <th class="px-4 py-3 text-left">No. Faktur</th>
                                <th class="px-4 py-3 text-right">Total</th>
                                <th class="px-4 py-3 text-left">Dicatat oleh</th>
                                <th class="px-4 py-3 text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @forelse($riwayat as $r)
                            <tr class="hover:bg-gray-50">
                                <td class="px-4 py-3 text-gray-600 whitespace-nowrap">{{ $r->tanggal->format('d/m/Y') }}</td>
                                <td class="px-4 py-3">
                                    <p class="font-medium text-gray-800">{{ $r->barang->nama ?? '-' }}</p>
                                    <p class="text-xs text-gray-400">{{ $r->barang->kategori->nama ?? '' }}</p>
                                </td>
                                <td class="px-4 py-3 text-center font-bold text-green-600">+{{ number_format($r->jumlah) }} {{ $r->barang->satuan ?? '' }}</td>
                                <td class="px-4 py-3 text-gray-600">{{ $r->supplier }}</td>
                                <td class="px-4 py-3 text-gray-400 text-xs">{{ $r->no_faktur ?? '-' }}</td>
                                <td class="px-4 py-3 text-right text-gray-700 whitespace-nowrap">Rp {{ number_format($r->total_harga, 0, ',', '.') }}</td>
                                <td class="px-4 py-3 text-gray-500 text-xs">{{ $r->karyawan->nama ?? '-' }}</td>
                                <td class="px-4 py-3 text-center">
                                    <form action="{{ route('admin.kelola_barang.masuk.destroy', $r) }}" method="POST"
                                        onsubmit="return confirm('Hapus data ini? Stok akan dikurangi kembali.')">
                                        @csrf @method('DELETE')
                                        <button class="bg-red-100 text-red-600 hover:bg-red-200 px-2 py-1 rounded text-xs">Hapus</button>
                                    </form>
                                </td>
                            </tr>
                            @empty
                            <tr><td colspan="8" class="px-4 py-10 text-center text-gray-400">Belum ada data.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <div class="p-4 border-t">{{ $riwayat->links() }}</div>
            </div>
        </div>
    </div>
</div>
@endsection
