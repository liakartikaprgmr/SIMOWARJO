<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Slip Gaji Karyawan</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100">
    <!-- Sidebar -->
    @include('karyawan.sidebarempl')

    <!-- Content -->
    <div class="ml-64 p-6">
        <div class="max-w-6xl mx-auto mt-15 mb-10">
            <!-- Header and Filter Form -->
            <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-6 gap-2">
                <h1 class="text-3xl font-bold text-gray-800 tracking-tight">Arsip Slip Gaji</h1>

                <form action="{{ route('karyawan.slip_gaji') }}" method="GET"
                    class="flex items-center gap-3 bg-white p-2 rounded-xl shadow-sm border border-gray-100">
                    <input type="month" name="periode" value="{{ $bulanTerpilih }}"
                        class="rounded-lg border-gray-200 border px-3 py-2.5 focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 outline-none text-sm font-medium text-gray-700 transition-all duration-200">
                    <button type="submit"
                        class="bg-blue-600 hover:bg-blue-700 text-white px-5 py-2.5 rounded-lg text-sm font-medium transition-all shadow-sm hover:shadow focus:ring-2 focus:ring-blue-500/50 cursor-pointer flex items-center gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                            xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z">
                            </path>
                        </svg>
                        Filter Arsip
                    </button>
                </form>
            </div>

            <!-- Note Box -->
            <div
                class="bg-blue-50/80 border border-blue-100 p-4 rounded-2xl shadow-sm flex items-start sm:items-center mb-10">
                <div class="bg-white p-2 rounded-xl shadow-sm border border-blue-50 mr-4">
                    <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                        xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                        </path>
                    </svg>
                </div>
                <div>
                    <h2 class="text-base font-bold text-blue-900">Informasi Arsip</h2>
                    <p class="text-sm text-blue-700 mt-0.5 leading-relaxed">
                        Lihat dan cetak slip gaji karyawan untuk periode bulan tertentu.
                    </p>
                </div>
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
                                    <span class="font-medium">- Rp
                                        {{ number_format($gaji->total_potongan, 0, ',', '.') }}</span>
                                </div>
                            @endif
                        </div>

                        <div class="bg-gray-50 rounded-lg p-3 flex justify-between items-center mb-4">
                            <span class="text-xs font-bold text-gray-600 uppercase">Gaji Bersih</span>
                            <span class="text-lg font-bold text-gray-900">Rp
                                {{ number_format(($gaji->gaji_pokok - $gaji->total_potongan) + optional($gaji->karyawan->komponenGaji)->tunjangan_jabatan + optional($gaji->karyawan->komponenGaji)->insentif_skill, 0, ',', '.') }}</span>
                        </div>

                        <div class="mt-auto pt-2 flex gap-3">
                            <a href="{{ route('karyawan.cetak_slip', $gaji->id_penggajian) }}" target="_blank"
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
                            '{{ $bulanTerpilih }}'.</p>
                    </div>
                @endforelse
            </div>
        </div>
    </div>
</body>

</html>