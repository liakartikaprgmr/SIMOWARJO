@extends('admin.layout')

@section('content')
    <div class="mt-16">
        <div class="max-w-2xl mx-auto">
            <div class="bg-red-800 text-white rounded-xl p-6 mb-6">
                <h1 class="text-xl font-bold">Tambah Barang Baru</h1>
                <p class="text-red-200 text-sm mt-1">Daftarkan item baru ke dalam inventaris</p>
            </div>

            @if($errors->any())
                <div class="bg-red-100 border border-red-400 text-red-800 px-4 py-3 rounded-xl mb-4">
                    @foreach($errors->all() as $e)<p>• {{ $e }}</p>@endforeach
                </div>
            @endif

            <div class="bg-white rounded-xl shadow p-6">
                <form action="{{ route('admin.kelola_barang.store') }}" method="POST" class="space-y-4">
                    @csrf
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Kode Barang <span
                                    class="text-red-500">*</span></label>
                            <input type="text" name="kode_barang" value="{{ old('kode_barang') }}" required
                                class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-red-500"
                                placeholder="Cth: BRG-001">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Nama Barang <span
                                    class="text-red-500">*</span></label>
                            <input type="text" name="nama" value="{{ old('nama') }}" required
                                class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-red-500">
                        </div>
                    </div>
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Kategori <span
                                    class="text-red-500">*</span></label>
                            <select name="id_kategori" required
                                class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-red-500">
                                <option value="">-- Pilih Kategori --</option>
                                @foreach($kategori as $k)
                                    <option value="{{ $k->id }}" {{ old('id_kategori') == $k->id ? 'selected' : '' }}>
                                        {{ $k->nama }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Satuan <span
                                    class="text-red-500">*</span></label>
                            <input type="text" name="satuan" value="{{ old('satuan') }}" required
                                class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-red-500"
                                placeholder="pcs, kg, liter, box...">
                        </div>
                    </div>
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Stok Minimum <span
                                    class="text-red-500">*</span></label>
                            <input type="number" name="stok_minimum" min="0" value="{{ old('stok_minimum', 5) }}" required
                                class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-red-500">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Harga Satuan <span
                                    class="text-red-500">*</span></label>
                            <input type="number" name="harga_satuan" min="0" value="{{ old('harga_satuan', 0) }}" required
                                class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-red-500">
                        </div>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Deskripsi</label>
                        <textarea name="deskripsi" rows="3"
                            class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-red-500"
                            placeholder="Deskripsi barang (opsional)">{{ old('deskripsi') }}</textarea>
                    </div>
                    <div class="flex gap-3 pt-2">
                        <button type="submit"
                            class="bg-green-800 hover:bg-green-900 text-white font-semibold px-6 py-2.5 rounded-lg transition">
                            Simpan Barang
                        </button>
                        <a href="{{ route('admin.kelola_barang.index') }}"
                            class="bg-gray-200 hover:bg-gray-300 text-gray-700 font-semibold px-6 py-2.5 rounded-lg transition">
                            Batal
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection