@extends('admin.layout')

@section('content')
    <div class="mt-16">

        {{-- HEADER --}}
        <div class="bg-red-800 text-white rounded-xl p-6 mb-6 flex items-center justify-between">
            <div>
                <h1 class="text-2xl font-bold">Dashboard Stok Barang</h1>
                <p class="text-red-200 text-sm mt-1">Pantau inventaris secara real-time</p>
            </div>
            <a href="{{ route('admin.kelola_barang.create') }}"
                class="bg-white text-red-800 font-semibold px-4 py-2 rounded-lg hover:bg-red-50 flex items-center gap-2">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24">
                    <path fill="currentColor"
                        d="M19 3H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2m-2 10h-4v4h-2v-4H7l5-5z" />
                </svg>
                Tambah Barang
            </a>
        </div>

        {{-- ALERT STOK RENDAH --}}
        @if($alertBarang->count() > 0)
            <div class="bg-red-50 border-l-4 border-red-500 rounded-xl p-4 mb-6">
                <div class="flex items-center gap-2 mb-2">
                    <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 24 24" class="text-red-600">
                        <path fill="currentColor"
                            d="M1 21L12 2l11 19zm11-3q.425 0 .713-.288T13 17t-.288-.712T12 16t-.712.288T11 17t.288.713T12 18m-1-3h2v-4h-2z" />
                    </svg>
                    <span class="font-bold text-red-700">{{ $alertBarang->count() }} Barang Stok Rendah!</span>
                </div>
                <div class="flex flex-wrap gap-2">
                    @foreach($alertBarang as $a)
                        <span class="bg-red-100 text-red-800 text-xs font-medium px-2.5 py-1 rounded-full">
                            {{ $a->nama }} ({{ $a->stok_saat_ini }}/{{ $a->stok_minimum }} {{ $a->satuan }})
                        </span>
                    @endforeach
                </div>
            </div>
        @endif

        {{-- NOTIF --}}
        @if(session('success'))
            <div class="bg-green-100 border border-green-400 text-green-800 px-4 py-3 rounded-xl mb-4 flex items-center gap-2">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24">
                    <path fill="currentColor"
                        d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10s10-4.48 10-10S17.52 2 12 2m-2 15l-5-5l1.41-1.41L10 14.17l7.59-7.59L19 8z" />
                </svg>
                {{ session('success') }}
            </div>
        @endif
        @if(session('error'))
            <div class="bg-red-100 border border-red-400 text-red-800 px-4 py-3 rounded-xl mb-4">{{ session('error') }}</div>
        @endif

        {{-- STAT CARDS --}}
        <div class="grid grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
            <div class="bg-white rounded-xl shadow p-5">
                <p class="text-gray-500 text-sm">Total Jenis Barang</p>
                <p class="text-3xl font-bold text-gray-800 mt-1">{{ $totalBarang }}</p>
            </div>
            <div class="bg-white rounded-xl shadow p-5">
                <p class="text-gray-500 text-sm">Stok Rendah</p>
                <p class="text-3xl font-bold text-red-600 mt-1">{{ $stokRendah }}</p>
            </div>
            <div class="bg-white rounded-xl shadow p-5">
                <p class="text-gray-500 text-sm">Total Masuk Bulan Ini</p>
                <p class="text-3xl font-bold text-green-600 mt-1">{{ number_format($totalMasukBulan) }}</p>
            </div>
            <div class="bg-white rounded-xl shadow p-5">
                <p class="text-gray-500 text-sm">Total Keluar Bulan Ini</p>
                <p class="text-3xl font-bold text-orange-500 mt-1">{{ number_format($totalKeluarBulan) }}</p>
            </div>
        </div>

        {{-- QUICK ACTIONS --}}
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-6 mb-6">
            <a href="{{ route('admin.kelola_barang.masuk') }}"
                class="bg-green-500 hover:bg-green-600 text-white rounded-xl p-4 flex items-center gap-3 shadow transition">
                <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 24 24">
                    <path fill="currentColor"
                        d="M19 3H5c-1.11 0-2 .9-2 2v14c0 1.1.89 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2m-2 10h-4v4h-2v-4H7l5-5z" />
                </svg>
                <div>
                    <p class="font-bold">Barang Masuk</p>
                    <p class="text-green-100 text-xs">Catat penerimaan barang</p>
                </div>
            </a>
            <a href="{{ route('admin.kelola_barang.keluar') }}"
                class="bg-orange-500 hover:bg-orange-600 text-white rounded-xl p-4 flex items-center gap-3 shadow transition">
                <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 24 24">
                    <path fill="currentColor"
                        d="M19 3H5c-1.11 0-2 .9-2 2v14c0 1.1.89 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2m-7 14l-5-5h4V8h2v4h4z" />
                </svg>
                <div>
                    <p class="font-bold">Barang Keluar</p>
                    <p class="text-orange-100 text-xs">Catat pengeluaran barang</p>
                </div>
            </a>
        </div>

        {{-- TABEL INVENTARIS --}}
        <div class="bg-white rounded-xl shadow overflow-hidden">
            <div class="p-4 border-b flex items-center justify-between">
                <h2 class="font-bold text-gray-800">Daftar Inventaris Barang</h2>
                <span class="text-gray-500 text-sm">{{ $barang->total() }} barang</span>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-sm">
                    <thead class="bg-gray-50 text-gray-600 uppercase text-xs">
                        <tr>
                            <th class="px-4 py-3 text-left">Kode</th>
                            <th class="px-4 py-3 text-left">Nama Barang</th>
                            <th class="px-4 py-3 text-left">Kategori</th>
                            <th class="px-4 py-3 text-center">Stok</th>
                            <th class="px-4 py-3 text-center">Min</th>
                            <th class="px-4 py-3 text-left">Satuan</th>
                            <th class="px-4 py-3 text-right">Harga Satuan</th>
                            <th class="px-4 py-3 text-center">Status</th>
                            <th class="px-4 py-3 text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @forelse($barang as $b)
                            <tr class="hover:bg-gray-50 {{ $b->isStokRendah() ? 'bg-red-50' : '' }}">
                                <td class="px-4 py-3 font-mono text-xs text-gray-500">{{ $b->kode_barang }}</td>
                                <td class="px-4 py-3 font-medium text-gray-800">{{ $b->nama }}</td>
                                <td class="px-4 py-3 text-gray-500">{{ $b->kategori->nama ?? '-' }}</td>
                                <td
                                    class="px-4 py-3 text-center font-bold {{ $b->isStokRendah() ? 'text-red-600' : 'text-gray-800' }}">
                                    {{ number_format($b->stok_saat_ini) }}
                                </td>
                                <td class="px-4 py-3 text-center text-gray-500">{{ $b->stok_minimum }}</td>
                                <td class="px-4 py-3 text-gray-500">{{ $b->satuan }}</td>
                                <td class="px-4 py-3 text-right text-gray-700">Rp
                                    {{ number_format($b->harga_satuan, 0, ',', '.') }}</td>
                                <td class="px-4 py-3 text-center">
                                    @if($b->isStokRendah())
                                        <span class="bg-red-100 text-red-700 text-xs px-2 py-1 rounded-full font-medium">⚠
                                            Rendah</span>
                                    @else
                                        <span class="bg-green-100 text-green-700 text-xs px-2 py-1 rounded-full font-medium">✓
                                            Aman</span>
                                    @endif
                                </td>
                                <td class="px-4 py-3 text-center">
                                    <div class="flex justify-center gap-1">
                                        <a href="{{ route('admin.kelola_barang.edit', $b) }}"
                                            class="bg-yellow-100 text-yellow-700 hover:bg-yellow-200 px-2 py-1 rounded text-xs font-medium">Edit</a>
                                        <form action="{{ route('admin.kelola_barang.destroy', $b) }}" method="POST"
                                            onsubmit="return confirm('Hapus barang ini?')">
                                            @csrf @method('DELETE')
                                            <button
                                                class="bg-red-100 text-red-700 hover:bg-red-200 px-2 py-1 rounded text-xs font-medium">Hapus</button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="9" class="px-4 py-10 text-center text-gray-400">Belum ada data barang.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="p-4 border-t">{{ $barang->links() }}</div>
        </div>
    </div>
@endsection