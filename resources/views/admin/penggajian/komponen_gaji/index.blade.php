@extends('admin.layout')

@section('content')
    <div class="px-6 py-8">
        <div class="max-w-7xl mx-auto">
            <div class="mb-8">
                <h1 class="text-3xl font-bold text-gray-800 mb-4 tracking-tight">Komponen Gaji Karyawan</h1>
                
                <div class="bg-blue-50/80 border border-blue-100 p-5 rounded-2xl shadow-sm flex items-start sm:items-center">
                    <div class="bg-white p-2 rounded-xl shadow-sm border border-blue-50 mr-4">
                        <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <div>
                        <h2 class="text-base font-bold text-blue-900">Informasi Komponen</h2>
                        <p class="text-sm text-blue-700 mt-0.5 leading-relaxed">
                            Kelola gaji pokok, tunjangan jabatan, dan insentif skill per karyawan.
                        </p>
                    </div>
                </div>
            </div>

            @if(session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4">
                    <span class="block sm:inline">{{ session('success') }}</span>
                </div>
            @endif

            <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Karyawan</th>
                                <th class="px-4 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Gaji Pokok</th>
                                <th class="px-4 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Tunjangan Jabatan</th>
                                <th class="px-4 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Insentif Skill</th>
                                <th class="px-4 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Total Penerimaan Kotor</th>
                                <th
                                    class="px-4 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach($dataKomponen as $item)
                                <tr class="hover:bg-gray-50">
                                    <td class="px-4 py-4 whitespace-nowrap">
                                        <div class="text-sm font-bold text-gray-900">{{ $item['karyawan']->nama }}</div>
                                        <div class="text-xs text-gray-500">{{ $item['karyawan']->jabatan }}</div>
                                    </td>
                                    <td class="px-4 py-4 whitespace-nowrap text-right text-sm text-gray-900 font-medium">
                                        Rp {{ number_format($item['gaji_pokok'], 0, ',', '.') }}
                                    </td>
                                    <td class="px-4 py-4 whitespace-nowrap text-right text-sm text-green-600 font-medium">
                                        Rp {{ number_format($item['tunjangan_jabatan'], 0, ',', '.') }}
                                    </td>
                                    <td class="px-4 py-4 whitespace-nowrap text-right text-sm text-blue-600 font-medium">
                                        Rp {{ number_format($item['insentif_skill'], 0, ',', '.') }}
                                    </td>
                                    <td
                                        class="px-4 py-4 whitespace-nowrap text-right text-sm text-gray-900 font-bold bg-gray-50/50">
                                        Rp
                                        {{ number_format($item['gaji_pokok'] + $item['tunjangan_jabatan'] + $item['insentif_skill'], 0, ',', '.') }}
                                    </td>
                                    <td class="px-4 py-4 whitespace-nowrap text-center">
                                        <button
                                            onclick="openModal({{ $item['karyawan']->id_karyawan }}, '{{ $item['karyawan']->nama }}', {{ $item['gaji_pokok'] }}, {{ $item['tunjangan_jabatan'] }}, {{ $item['insentif_skill'] }})"
                                            class="bg-red-600 hover:bg-red-700 text-white px-3 py-1.5 rounded-md text-xs font-medium transition flex items-center gap-1 mx-auto">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="w-3 h-3" viewBox="0 0 24 24">
                                                <path fill="currentColor"
                                                    d="M3 17.25V21h3.75L17.81 9.94l-3.75-3.75L3 17.25zM20.71 7.04a.996.996 0 0 0 0-1.41l-2.34-2.34a.996.996 0 0 0-1.41 0l-1.83 1.83l3.75 3.75l1.83-1.83z" />
                                            </svg>
                                            Edit
                                        </button>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                @if(count($dataKomponen) == 0)
                    <div class="p-8 text-center text-gray-500">Tidak ada data karyawan.</div>
                @endif
            </div>
        </div>
    </div>

    <!-- Modal Edit -->
    <div id="editModal" class="fixed inset-0 bg-gray-900 bg-opacity-50 hidden items-center justify-center z-50">
        <div class="bg-white rounded-xl shadow-xl max-w-md w-full mx-4 transform transition-all">
            <div class="px-6 py-4 border-b border-gray-100 flex justify-between items-center bg-gray-50 rounded-t-xl">
                <h3 class="font-bold text-gray-800 text-lg">Edit Komponen Gaji</h3>
                <button onclick="closeModal()" class="text-gray-400 hover:text-gray-600 transition">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>

            <form action="{{ route('admin.penggajian.komponen_gaji.update') }}" method="POST">
                @csrf
                <div class="px-6 py-5 space-y-4">
                    <input type="hidden" id="id_karyawan" name="id_karyawan">

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Nama Karyawan</label>
                        <input type="text" id="nama_karyawan" readonly
                            class="w-full bg-gray-100 border border-gray-300 rounded-lg px-4 py-2 text-gray-600 cursor-not-allowed text-sm">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Gaji Pokok (Rp)</label>
                        <input type="number" id="gaji_pokok" name="gaji_pokok" required
                            class="w-full border border-gray-300 rounded-lg px-4 py-2 text-sm focus:ring-red-500 focus:border-red-500 bg-white">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Tunjangan Jabatan (Rp)</label>
                        <input type="number" id="tunjangan_jabatan" name="tunjangan_jabatan" required
                            class="w-full border border-gray-300 rounded-lg px-4 py-2 text-sm focus:ring-red-500 focus:border-red-500 bg-white">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Insentif Skill (Rp)</label>
                        <input type="number" id="insentif_skill" name="insentif_skill" required
                            class="w-full border border-gray-300 rounded-lg px-4 py-2 text-sm focus:ring-red-500 focus:border-red-500 bg-white">
                    </div>
                </div>

                <div class="px-6 py-4 bg-gray-50 border-t border-gray-100 rounded-b-xl flex justify-end gap-3">
                    <button type="button" onclick="closeModal()"
                        class="px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 transition">Batal</button>
                    <button type="submit"
                        class="px-4 py-2 text-sm font-medium text-white bg-green-600 rounded-lg hover:bg-green-700 transition shadow-sm">Simpan
                        Perubahan</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        function openModal(id, nama, gaji, tunjangan, insentif) {
            document.getElementById('id_karyawan').value = id;
            document.getElementById('nama_karyawan').value = nama;
            document.getElementById('gaji_pokok').value = gaji;
            document.getElementById('tunjangan_jabatan').value = tunjangan;
            document.getElementById('insentif_skill').value = insentif;

            document.getElementById('editModal').classList.remove('hidden');
            document.getElementById('editModal').classList.add('flex');
        }

        function closeModal() {
            document.getElementById('editModal').classList.add('hidden');
            document.getElementById('editModal').classList.remove('flex');
        }
    </script>
@endsection