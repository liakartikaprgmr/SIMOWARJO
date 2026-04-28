@extends('admin.layout')

@section('content')
    <div class="px-6 py-8">
        <div class="max-w-6xl mx-auto">
            <h1 class="text-3xl font-bold text-gray-800 mb-6">Persetujuan Kehadiran (Izin & Sakit)</h1>

            @if(session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4">
                    <span class="block sm:inline">{{ session('success') }}</span>
                </div>
            @endif

            <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100">
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Karyawan</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Tanggal Mulai - Selesai</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Jenis</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Keterangan</th>
                                <th
                                    class="px-4 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Bukti</th>
                                <th
                                    class="px-4 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @forelse($pengajuan as $p)
                                <tr>
                                    <td class="px-4 py-4 whitespace-nowrap">
                                        <div class="flex items-center">
                                            <div class="flex-shrink-0 h-10 w-10">
                                                <div
                                                    class="h-10 w-10 rounded-full bg-red-100 text-red-600 flex items-center justify-center font-bold">
                                                    {{ substr($p->karyawan->nama ?? 'Unknown', 0, 1) }}
                                                </div>
                                            </div>
                                            <div class="ml-4">
                                                <div class="text-sm font-medium text-gray-900">{{ $p->karyawan->nama ?? 'Unknown' }}
                                                </div>
                                                <div class="text-sm text-gray-500">{{ $p->karyawan->jabatan }}</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-4 py-4 text-sm text-gray-700">
                                        {{ \Carbon\Carbon::parse($p->tanggal_mulai)->format('d M') }}
                                        @if($p->tanggal_mulai != $p->tanggal_selesai)
                                            - {{ \Carbon\Carbon::parse($p->tanggal_selesai)->format('d M Y') }}
                                        @else
                                            {{ \Carbon\Carbon::parse($p->tanggal_mulai)->format('Y') }}
                                        @endif
                                        <br>
                                        <span
                                            class="text-xs text-gray-500">{{ \Carbon\Carbon::parse($p->tanggal_mulai)->diffInDays(\Carbon\Carbon::parse($p->tanggal_selesai)) + 1 }}
                                            Hari</span>
                                    </td>
                                    <td class="px-4 py-4 whitespace-nowrap">
                                        <span
                                            class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $p->jenis == 'sakit' ? 'bg-orange-100 text-orange-800' : 'bg-blue-100 text-blue-800' }}">
                                            {{ ucfirst($p->jenis) }}
                                        </span>
                                    </td>
                                    <td class="px-4 py-4 text-sm text-gray-500 max-w-xs truncate" title="{{ $p->keterangan }}">
                                        {{ Str::limit($p->keterangan, 50) }}
                                    </td>
                                    <td class="px-4 py-4 text-center text-sm">
                                        @if($p->bukti_foto)
                                            <a href="{{ asset('storage/' . $p->bukti_foto) }}" target="_blank"
                                                class="text-red-600 hover:text-red-900 underline">Lihat</a>
                                        @else
                                            <span class="text-gray-400">-</span>
                                        @endif
                                    </td>
                                    <td
                                        class="px-4 py-4 whitespace-nowrap text-center text-sm font-medium border-l border-gray-100">
                                        @if($p->status == 'pending')
                                            <div class="flex gap-2 justify-center">
                                                <form action="{{ route('admin.perizinan.update_status', $p->id_pengajuan) }}"
                                                    method="POST">
                                                    @csrf
                                                    <input type="hidden" name="status" value="disetujui">
                                                    <button type="submit"
                                                        class="bg-green-500 hover:bg-green-600 text-white px-3 py-1 rounded-md transition text-xs font-medium">Setuju</button>
                                                </form>
                                                <form action="{{ route('admin.perizinan.update_status', $p->id_pengajuan) }}"
                                                    method="POST">
                                                    @csrf
                                                    <input type="hidden" name="status" value="ditolak">
                                                    <button type="submit"
                                                        class="bg-red-500 hover:bg-red-600 text-white px-3 py-1 rounded-md transition text-xs font-medium">Tolak</button>
                                                </form>
                                            </div>
                                        @else
                                            <span
                                                class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full {{ $p->status == 'disetujui' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                                {{ ucfirst($p->status) }}
                                            </span>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="px-4 py-10 text-center text-gray-500 text-sm">Belum ada data
                                        pengajuan.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection