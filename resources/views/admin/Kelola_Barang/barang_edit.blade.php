@extends('admin.layout')

@section('content')
<div class="mt-16">
    <div class="max-w-2xl mx-auto">
        <div class="bg-yellow-600 text-white rounded-xl p-6 mb-6">
            <h1 class="text-xl font-bold">Edit Barang</h1>
            <p class="text-yellow-200 text-sm mt-1">{{ $barang->kode_barang }} — {{ $barang->nama }}</p>
        </div>

        @if($errors->any())
        <div class="bg-red-100 border border-red-400 text-red-800 px-4 py-3 rounded-xl mb-4">
            @foreach($errors->all() as $e)<p>• {{ $e }}</p>@endforeach
        </div>
        @endif

        <div class="bg-white rounded-xl shadow p-6">
            <form action="{{ route('admin.kelola_barang.update', $barang) }}" method="POST" class="space-y-4">
                @csrf @method('PUT')
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Kode Barang <span class="text-red-500">*</span></label>
                        <input type="text" name="kode_barang" value="{{ old('kode_barang', $barang->kode_barang) }}" required
                            class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-yellow-500">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Nama Barang <span class="text-red-500">*</span></label>
                        <input type="text" name="nama" value="{{ old('nama', $barang->nama) }}" required
                            class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-yellow-500">
                    </div>
                </div>
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Kategori <span class="text-red-500">*</span></label>
                        <select name="id_kategori" required
                            class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-yellow-500">
                            @foreach($kategori as $k)
                            <option value="{{ $k->id }}" {{ old('id_kategori', $barang->id_kategori) == $k->id ? 'selected' : '' }}>{{ $k->nama }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Satuan <span class="text-red-500">*</span></label>
                        <input type="text" name="satuan" value="{{ old('satuan', $barang->satuan) }}" required
                            class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-yellow-500">
                    </div>
                </div>
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Stok Minimum <span class="text-red-500">*</span></label>
                        <input type="number" name="stok_minimum" min="0" value="{{ old('stok_minimum', $barang->stok_minimum) }}" required
                            class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-yellow-500">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Harga Satuan <span class="text-red-500">*</span></label>
                        <input type="number" name="harga_satuan" min="0" value="{{ old('harga_satuan', $barang->harga_satuan) }}" required
                            class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-yellow-500">
                    </div>
                </div>
                <div class="bg-blue-50 border border-blue-200 rounded-lg p-3 text-sm text-blue-700">
                    <strong>Stok saat ini: {{ $barang->stok_saat_ini }} {{ $barang->satuan }}</strong><br>
                    <span class="text-xs">Untuk mengubah stok, gunakan menu Barang Masuk / Barang Keluar.</span>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Deskripsi</label>
                    <textarea name="deskripsi" rows="3"
                        class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-yellow-500">{{ old('deskripsi', $barang->deskripsi) }}</textarea>
                </div>
                <div class="flex gap-3 pt-2">
                    <button type="submit" class="bg-yellow-600 hover:bg-yellow-700 text-white font-semibold px-6 py-2.5 rounded-lg transition">
                        Update Barang
                    </button>
                    <a href="{{ route('admin.kelola_barang.index') }}" class="bg-gray-200 hover:bg-gray-300 text-gray-700 font-semibold px-6 py-2.5 rounded-lg transition">
                        Batal
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
