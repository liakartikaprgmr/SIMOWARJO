@extends('karyawan.layoutempl')

@section('content')
    <div class="flex justify-between items-center mb-6">
        <div class="max-w-4xl mx-auto">
            <h1 class="text-3xl font-bold text-gray-800 mb-6 flex items-center gap-3">
                <svg class="text-blue-600 w-8 h-8 flex-shrink-0" xmlns="http://www.w3.org/2000/svg" fill="currentColor"
                    viewBox="0 0 24 24">
                    <path
                        d="M22 5v2h-3v3h-2V7h-3V5h3V2h2v3zm-3 14H5V5h6V3H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2v-6h-2zm-4-6v4h2v-4zm-4 4h2V9h-2zm-2 0v-6H7v6z" />
                </svg>

                <span class="leading-none">
                    Form <span class="text-blue-600">{{ ucfirst($kategoriFilter) }}</span>
                </span>
            </h1>

            @if(session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
                    <span class="block sm:inline">{{ session('success') }}</span>
                </div>
            @endif

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <!-- Form Card -->
                <div class="md:col-span-1 bg-white p-6 rounded-xl shadow-sm border border-gray-100">
                    <h2 class="text-xl font-semibold mb-4 text-gray-700">Buat Pengajuan</h2>
                    <form action="{{ route('karyawan.izin.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700 mb-1">Tanggal Mulai</label>
                            <input type="date" name="tanggal_mulai" required
                                class="w-full rounded-lg border-gray-300 border p-2 focus:ring-red-500 focus:border-red-500">
                        </div>
                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700 mb-1">Tanggal Selesai</label>
                            <input type="date" name="tanggal_selesai" required
                                class="w-full rounded-lg border-gray-300 border p-2 focus:ring-red-500 focus:border-red-500">
                        </div>
                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700 mb-1">Jenis Ketidakhadiran</label>
                            <input type="hidden" name="jenis" value="{{ $kategoriFilter }}">
                            <select disabled
                                class="w-full rounded-lg border-gray-300 border p-2 focus:ring-red-500 focus:border-red-500 bg-gray-100 text-gray-500">
                                <option value="izin" {{ $kategoriFilter == 'izin' ? 'selected' : '' }}>Izin Pribadi</option>
                                <option value="sakit" {{ $kategoriFilter == 'sakit' ? 'selected' : '' }}>Sakit (Dilengkapi
                                    Surat/Bukti)</option>
                            </select>
                        </div>
                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700 mb-1">Keterangan / Alasan</label>
                            <textarea name="keterangan" rows="3" required
                                class="w-full rounded-lg border-gray-300 border p-2 focus:ring-red-500 focus:border-red-500"></textarea>
                        </div>
                        <div class="mb-6">
                            <label class="block text-sm font-medium text-gray-700 mb-1">Bukti Foto (Opsional)</label>
                            <input type="file" name="bukti_foto" accept="image/*"
                                class="w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-grey-50 file:text-grey-700 hover:file:bg-grey-100">
                        </div>
                        <button type="submit"
                            class="w-full bg-green-700 hover:bg-green-800 text-white font-bold py-2 px-4 rounded-lg transition duration-200">Kirim
                            Pengajuan</button>
                    </form>
                </div>

                <!-- Riwayat Card -->
                <div class="md:col-span-2 bg-white p-6 rounded-xl shadow-sm border border-gray-100">
                    <h2 class="text-xl font-semibold mb-4 text-gray-700">Riwayat Pengajuan Anda</h2>
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th
                                        class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Tanggal</th>
                                    <th
                                        class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Jenis</th>
                                    <th
                                        class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Status</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @forelse($riwayatIzin as $izin)
                                    <tr>
                                        <td class="px-4 py-3 text-sm text-gray-900">
                                            {{ \Carbon\Carbon::parse($izin->tanggal_mulai)->format('d M Y') }}
                                            @if($izin->tanggal_mulai != $izin->tanggal_selesai)
                                                - {{ \Carbon\Carbon::parse($izin->tanggal_selesai)->format('d M Y') }}
                                            @endif
                                        </td>
                                        <td class="px-4 py-3 text-sm">
                                            <span
                                                class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full {{ $izin->jenis == 'sakit' ? 'bg-orange-100 text-orange-800' : 'bg-blue-100 text-blue-800' }}">
                                                {{ ucfirst($izin->jenis) }}
                                            </span>
                                        </td>
                                        <td class="px-4 py-3 text-sm">
                                            @if($izin->status == 'pending')
                                                <span
                                                    class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">Pending</span>
                                            @elseif($izin->status == 'disetujui')
                                                <span
                                                    class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">Disetujui</span>
                                            @else
                                                <span
                                                    class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">Ditolak</span>
                                            @endif
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="3" class="px-4 py-8 text-center text-gray-500 text-sm">Belum ada riwayat
                                            pengajuan.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection