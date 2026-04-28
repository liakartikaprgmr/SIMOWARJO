@extends('karyawan.layoutempl')

@section('content')
    <div class="container mx-auto px-4 sm:px-6 lg:px-8 mt-15 mb-10">
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-800 mb-4 tracking-tight">Jadwal Kerja</h1>
            
            <div class="bg-blue-50/80 border border-blue-100 p-5 rounded-2xl shadow-sm flex items-start sm:items-center">
                <div class="bg-white p-2 rounded-xl shadow-sm border border-blue-50 mr-4">
                    <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                    </svg>
                </div>
                <div>
                    <h2 class="text-base font-bold text-blue-900">Periode Minggu Ini</h2>
                    <p class="text-sm text-blue-700 mt-0.5 leading-relaxed">
                        Menampilkan jadwal kerja Anda dari tanggal <span class="font-bold bg-white px-2 py-0.5 rounded text-blue-800">{{ $startOfWeek->translatedFormat('d M Y') }}</span> hingga <span class="font-bold bg-white px-2 py-0.5 rounded text-blue-800">{{ $endOfWeek->translatedFormat('d M Y') }}</span>.
                    </p>
                </div>
            </div>
        </div>

        <div class="bg-white shadow-xl rounded-2xl overflow-hidden border border-gray-100/50">
            <div class="overflow-x-auto">
                <table class="min-w-full leading-normal">
                    <thead>
                        <tr class="bg-gray-50/80 border-b border-gray-200">
                            <th class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Hari / Tanggal</th>
                            <th class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Shift</th>
                            <th class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Jam Masuk</th>
                            <th class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Jam Pulang</th>
                            <th class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Status</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @forelse($jadwal_kerja as $item)
                            @php
                                $isToday = \Carbon\Carbon::parse($item->tanggal)->isToday();
                            @endphp
                            <tr class="hover:bg-blue-50/30 transition-colors duration-200 {{ $isToday ? 'bg-blue-50/40' : '' }}">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        @if($isToday)
                                            <div class="h-2.5 w-2.5 rounded-full bg-blue-600 mr-3 animate-pulse"></div>
                                        @else
                                            <div class="h-2.5 w-2.5 rounded-full bg-gray-300 mr-3"></div>
                                        @endif
                                        <div class="flex flex-col">
                                            <span class="text-sm font-bold {{ $isToday ? 'text-blue-800' : 'text-gray-800' }}">
                                                {{ \Carbon\Carbon::parse($item->tanggal)->translatedFormat('l') }}
                                                @if($isToday) <span class="ml-2 text-[10px] font-bold bg-blue-600 text-white px-2 py-0.5 rounded-md uppercase tracking-wider">Hari Ini</span> @endif
                                            </span>
                                            <span class="text-xs text-gray-500 mt-0.5">{{ \Carbon\Carbon::parse($item->tanggal)->translatedFormat('d F Y') }}</span>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    @if($item->shift == 'Pagi')
                                        <span class="px-3 py-1 bg-yellow-100/80 text-yellow-800 rounded-lg text-xs font-bold tracking-wide border border-yellow-200/50">Pagi</span>
                                    @else
                                        <span class="px-3 py-1 bg-indigo-100/80 text-indigo-800 rounded-lg text-xs font-bold tracking-wide border border-indigo-200/50">Malam</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-mono font-medium {{ $isToday ? 'text-blue-900' : 'text-gray-700' }}">
                                    {{ \Carbon\Carbon::parse($item->jam_masuk)->format('H:i') }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-mono font-medium {{ $isToday ? 'text-blue-900' : 'text-gray-700' }}">
                                    {{ \Carbon\Carbon::parse($item->jam_pulang)->format('H:i') }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm">
                                    @php
                                        $dateObj = \Carbon\Carbon::parse($item->tanggal);
                                        if ($dateObj->isFuture()) {
                                            echo '<span class="inline-flex items-center text-gray-500 font-medium"><svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>Akan Datang</span>';
                                        } elseif ($dateObj->isPast() && !$dateObj->isToday()) {
                                            echo '<span class="inline-flex items-center text-gray-400 font-medium"><svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>Berlalu</span>';
                                        } else {
                                            echo '<span class="inline-flex items-center text-green-600 font-bold"><svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>Berjalan</span>';
                                        }
                                    @endphp
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-6 py-12 text-center text-gray-500 bg-gray-50/50">
                                    <div class="flex flex-col items-center">
                                        <div class="p-3 bg-white rounded-full shadow-sm mb-4 border border-gray-100">
                                            <svg class="w-10 h-10 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                            </svg>
                                        </div>
                                        <span class="text-lg font-medium text-gray-700">Tidak ada jadwal untuk minggu ini</span>
                                        <span class="text-sm text-gray-400 mt-1">Jadwal shift Anda kosong atau belum ditentukan oleh Admin.</span>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection