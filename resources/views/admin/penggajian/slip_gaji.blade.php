@extends('admin.layout')

@section('content')
    <div class="px-6 py-8">
        <div class="max-w-6xl mx-auto mt-5">
            <div
                class="bg-red-800 text-white rounded-2xl px-8 py-6 shadow-md flex flex-col lg:flex-row lg:items-center lg:justify-between gap-5 mb-2">
                <div>
                    <h1 class="text-2xl md:text-3xl font-bold tracking-tight">
                        Arsip Slip Gaji
                    </h1>
                </div>
                <form action="{{ route('admin.penggajian.slip_gaji') }}" method="GET"
                    class="flex flex-col sm:flex-row items-stretch sm:items-center gap-3">
                    <input type="month" name="periode" value="{{ $bulanTerpilih }}"
                        class="bg-white/95 text-gray-700 rounded-xl border border-red-200 px-4 py-3 text-sm shadow-sm focus:ring-2 focus:ring-white focus:border-white outline-none">

                    <button type="submit"
                        class="inline-flex items-center justify-center gap-2 bg-white hover:bg-red-50 text-red-800 font-semibold px-5 py-3 rounded-xl transition-all shadow-md border border-red-700 cursor-pointer">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M3 4a1 1 0 011-1h3.586a1 1 0 01.707.293l1.414 1.414A1 1 0 0010.414 4H20a1 1 0 011 1v2H3V4zm0 5h18v10a1 1 0 01-1 1H4a1 1 0 01-1-1V9z" />
                        </svg>
                        Filter Arsip
                    </button>
                </form>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @forelse($penggajians as $gaji)
                    <div
                        class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 flex flex-col hover:shadow-md transition">
                        <div class="flex items-center justify-between mb-4 border-b pb-4">
                            <div class="flex items-center gap-3">
                                <div
                                    class="w-12 h-12 rounded-full bg-red-100 flex items-center justify-center font-bold text-red-700 text-lg">
                                    {{ substr($gaji->karyawan->nama ?? '?', 0, 1) }}
                                </div>
                                <div>
                                    <h3 class="font-bold text-gray-800">{{ $gaji->karyawan->nama }}</h3>
                                    <p class="text-xs text-gray-500">{{ mb_strtoupper($gaji->karyawan->jabatan) }}</p>
                                </div>
                            </div>
                        </div>

                        <div class="flex flex-col gap-2 mb-4 text-sm flex-grow">
                            <div class="flex flex-col gap-1 py-2 px-3 bg-gray-50 rounded-lg mb-2">
                                <span class="text-[10px] text-gray-400 font-bold uppercase">Rincian Kehadiran</span>
                                <div class="flex justify-between text-xs">
                                    <div class="flex gap-2">
                                        <span class="text-green-600 font-bold">H:{{ $gaji->jumlah_hadir }}</span>
                                        <span class="text-blue-600 font-bold">I:{{ $gaji->jumlah_izin }}</span>
                                        <span class="text-orange-500 font-bold">S:{{ $gaji->jumlah_sakit }}</span>
                                        <span class="text-red-600 font-bold">A:{{ $gaji->jumlah_alpa }}</span>
                                    </div>
                                    <span class="text-gray-400 italic">Target: 26 Hr</span>
                                </div>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-500">Gaji Pokok</span>
                                <span class="font-medium">Rp {{ number_format($gaji->gaji_pokok, 0, ',', '.') }}</span>
                            </div>
                            @if(optional($gaji->karyawan->komponenGaji)->tunjangan_jabatan > 0)
                                <div class="flex justify-between">
                                    <span class="text-gray-500">Tunjangan Jabatan</span>
                                    <span class="font-medium">Rp
                                        {{ number_format(optional($gaji->karyawan->komponenGaji)->tunjangan_jabatan, 0, ',', '.') }}</span>
                                </div>
                            @endif
                            @if(optional($gaji->karyawan->komponenGaji)->insentif_skill > 0)
                                <div class="flex justify-between">
                                    <span class="text-gray-500">Insentif Skill</span>
                                    <span class="font-medium">Rp
                                        {{ number_format(optional($gaji->karyawan->komponenGaji)->insentif_skill, 0, ',', '.') }}</span>
                                </div>
                            @endif
                            @if($gaji->total_potongan > 0)
                                <div class="flex justify-between text-red-500">
                                    <span>Total Potongan</span>
                                    <span class="font-medium">- Rp {{ number_format($gaji->total_potongan, 0, ',', '.') }}</span>
                                </div>
                            @endif
                        </div>

                        <div class="bg-gray-50 rounded-lg p-3 flex justify-between items-center mb-4">
                            <span class="text-xs font-bold text-gray-600 uppercase">Gaji Bersih</span>
                            <span class="text-lg font-bold text-gray-900">Rp
                                {{ number_format(($gaji->gaji_pokok - $gaji->total_potongan) + optional($gaji->karyawan->komponenGaji)->tunjangan_jabatan + optional($gaji->karyawan->komponenGaji)->insentif_skill, 0, ',', '.') }}</span>
                        </div>

                        <div class="mt-auto pt-2 flex gap-3">
                            <a href="{{ route('admin.penggajian.cetak', $gaji->id_penggajian) }}" target="_blank"
                                class="w-full flex justify-center items-center gap-2 bg-white border-2 border-red-700 text-red-700 hover:bg-red-50 font-bold py-2 px-4 rounded-lg transition duration-200 text-sm">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" viewBox="0 0 24 24">
                                    <path fill="currentColor"
                                        d="M18 3H6v4h12m1 5a1 1 0 0 1-1-1a1 1 0 0 1 1-1a1 1 0 0 1 1 1a1 1 0 0 1-1 1m-1 7H6v-5h12m3-3v6h-4v4H4v-4H0v-6a3 3 0 0 1 3-3h18a3 3 0 0 1 3 3" />
                                </svg>
                                Cetak Struk
                            </a>
                        </div>
                    </div>
                @empty
                    <div class="col-span-full bg-white rounded-xl shadow-sm border border-gray-100 p-10 text-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-16 h-16 text-gray-300 mx-auto mb-4"
                            viewBox="0 0 24 24">
                            <path fill="currentColor"
                                d="M14 2H6c-1.1 0-1.99.9-1.99 2L4 20c0 1.1.89 2 1.99 2H18c1.1 0 2-.9 2-2V8l-6-6zm2 16H8v-2h8v2zm0-4H8v-2h8v2zm-3-5V3.5L18.5 9H13z" />
                        </svg>
                        <h3 class="text-xl font-bold text-gray-700 mb-2">Arsip Tidak Ditemukan</h3>
                        <p class="text-gray-500 max-w-md mx-auto">Kami tidak menemukan data slip gaji untuk bulan
                            '{{ $bulanTerpilih }}'. Pastikan Anda sudah meng-generate gaji di menu Payroll terlebih dahulu.</p>
                        <a href="{{ route('admin.penggajian.payroll') }}"
                            class="inline-block mt-4 text-red-600 font-semibold hover:underline">Ke Menu Payroll &rarr;</a>
                    </div>
                @endforelse
            </div>
        </div>
    </div>
@endsection