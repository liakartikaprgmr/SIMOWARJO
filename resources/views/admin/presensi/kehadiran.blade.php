@extends('admin.layout')

@section('content')
    <div class="mt-10 p-6">
        <div class="bg-red-800 text-white rounded-xl p-6 mb-6 shadow-md flex items-center justify-between">
            <div>
                <h1 class="text-2xl font-bold">Daftar Kehadiran Karyawan</h1>
                <p class="text-red-200 text-sm mt-1">Pantau absensi wajah, filter berdasarkan tanggal, dan lihat statistik kehadiran harian.</p>
            </div>
            <div class="hidden md:block">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 text-red-300 opacity-75" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
            </div>
        </div>

        {{-- GRID STATISTIK --}}
        <div class="grid grid-cols-2 md:grid-cols-5 gap-4 mb-6">
            <div class="bg-white p-4 rounded-xl shadow border-l-4 border-green-500">
                <p class="text-xs text-gray-500 font-semibold uppercase">Hadir</p>
                <p class="text-2xl font-bold text-gray-800 mt-1">{{ $hadir }}</p>
            </div>
            <div class="bg-white p-4 rounded-xl shadow border-l-4 border-red-500">
                <p class="text-xs text-gray-500 font-semibold uppercase">Tidak Hadir</p>
                <p class="text-2xl font-bold text-gray-800 mt-1">{{ $tidakHadir }}</p>
            </div>
            <div class="bg-white p-4 rounded-xl shadow border-l-4 border-orange-500">
                <p class="text-xs text-gray-500 font-semibold uppercase">Telat</p>
                <p class="text-2xl font-bold text-gray-800 mt-1">{{ $telat }}</p>
            </div>
            <div class="bg-white p-4 rounded-xl shadow border-l-4 border-blue-500">
                <p class="text-xs text-gray-500 font-semibold uppercase">Sakit</p>
                <p class="text-2xl font-bold text-gray-800 mt-1">{{ $sakit }}</p>
            </div>
            <div class="bg-white p-4 rounded-xl shadow border-l-4 border-purple-500">
                <p class="text-xs text-gray-500 font-semibold uppercase">Izin</p>
                <p class="text-2xl font-bold text-gray-800 mt-1">{{ $izin }}</p>
            </div>
        </div>

        {{-- FILTER --}}
        <div class="bg-white p-5 rounded-xl shadow mb-6">
            <form action="{{ route('admin.presensi.kehadiran') }}" method="GET"
                class="flex flex-col md:flex-row gap-4 items-end">
                <div>
                    <label class="block text-xs font-semibold text-gray-600 mb-1">Tanggal Mulai</label>
                    <input type="date" name="tanggal_mulai" value="{{ $startDate }}"
                        class="border border-gray-300 rounded-lg px-3 py-2 text-sm w-full md:w-auto focus:ring-2 focus:ring-blue-500 outline-none">
                </div>
                <div>
                    <label class="block text-xs font-semibold text-gray-600 mb-1">Tanggal Akhir</label>
                    <input type="date" name="tanggal_akhir" value="{{ $endDate }}"
                        class="border border-gray-300 rounded-lg px-3 py-2 text-sm w-full md:w-auto focus:ring-2 focus:ring-blue-500 outline-none">
                </div>
                <div class="flex-grow">
                    <label class="block text-xs font-semibold text-gray-600 mb-1">Cari Karyawan</label>
                    <input type="text" name="search" value="{{ $search }}" placeholder="Masukkan nama..."
                        class="border border-gray-300 rounded-lg px-3 py-2 text-sm w-full focus:ring-2 focus:ring-blue-500 outline-none">
                </div>
                <div class="flex gap-2">
                    <button type="submit"
                        class="bg-blue-600 hover:bg-blue-700 text-white font-semibold px-4 py-2 rounded-lg text-sm transition">
                        Filter Data
                    </button>
                    <a href="{{ route('admin.presensi.kehadiran') }}"
                        class="bg-gray-200 hover:bg-gray-300 text-gray-700 font-semibold px-4 py-2 rounded-lg text-sm transition">
                        Reset
                    </a>
                </div>
            </form>
        </div>

        {{-- TABEL PRESENSI --}}
        <div class="bg-white rounded-xl shadow overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left text-sm whitespace-nowrap">
                    <thead class="bg-gray-50 border-b border-gray-200 text-gray-600">
                        <tr>
                            <th class="px-6 py-4 font-semibold">Karyawan</th>
                            <th class="px-6 py-4 font-semibold">Tanggal</th>
                            <th class="px-6 py-4 font-semibold text-center">Masuk</th>
                            <th class="px-6 py-4 font-semibold text-center">Pulang</th>
                            <th class="px-6 py-4 font-semibold text-center">Status</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @forelse($kehadiran as $row)
                            <tr class="hover:bg-gray-50 transition">
                                <td class="px-6 py-4">
                                    <div class="font-medium text-gray-800">{{ $row->karyawan->nama ?? 'Unknown' }}</div>
                                    <div class="text-xs text-gray-500">ID: {{ $row->id_karyawan }}</div>
                                </td>
                                <td class="px-6 py-4 text-gray-700">
                                    {{ \Carbon\Carbon::parse($row->tanggal)->translatedFormat('d M Y') }}
                                </td>
                                <td class="px-6 py-4 text-center">
                                    @if($row->jam_masuk)
                                        <div class="font-semibold text-gray-800">
                                            {{ \Carbon\Carbon::parse($row->jam_masuk)->format('H:i') }}</div>
                                        @if($row->foto_masuk)
                                            <img src="{{ asset('storage/' . $row->foto_masuk) }}" alt="Masuk"
                                                class="w-12 h-12 object-cover rounded-md mx-auto mt-1 border border-gray-200 shadow-sm">
                                        @endif
                                    @else
                                        <span class="text-gray-400">-</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 text-center">
                                    @if($row->jam_pulang)
                                        <div class="font-semibold text-gray-800">
                                            {{ \Carbon\Carbon::parse($row->jam_pulang)->format('H:i') }}</div>
                                        @if($row->foto_pulang)
                                            <img src="{{ asset('storage/' . $row->foto_pulang) }}" alt="Pulang"
                                                class="w-12 h-12 object-cover rounded-md mx-auto mt-1 border border-gray-200 shadow-sm">
                                        @endif
                                    @else
                                        <span class="text-gray-400">-</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 text-center">
                                    <span
                                        class="bg-green-100 text-green-700 text-xs px-2.5 py-1 rounded-full font-medium">Hadir</span>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-6 py-8 text-center text-gray-500">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 mx-auto text-gray-300 mb-2"
                                        fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                    </svg>
                                    <p>Tidak ada data kehadiran yang ditemukan.</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            @if($kehadiran->hasPages())
                <div class="px-6 py-4 border-t border-gray-100">
                    {{ $kehadiran->links() }}
                </div>
            @endif
        </div>
    </div>
@endsection