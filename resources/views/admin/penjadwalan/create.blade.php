@extends('admin.layout')

@section('content')
    <div class="container mx-auto max-w-4xl mt-10 px-4 sm:px-6 lg:px-8">
        <div
            class="bg-red-800 text-white rounded-2xl px-8 py-6 shadow-md flex flex-col md:flex-row md:items-center md:justify-between gap-4 mb-8">
            <div>
                <h1 class="text-2xl md:text-3xl font-bold tracking-tight">
                    Buat Jadwal Shift
                </h1>

                <p class="text-red-100 text-sm mt-1">
                    Atur dan kelola jadwal kerja karyawan
                </p>
            </div>

            <a href="{{ route('admin.penjadwalan.index') }}"
                class="inline-flex items-center gap-2 bg-white hover:bg-red-50 text-red-800 text-sm font-semibold px-5 py-3 rounded-2xl transition-all shadow-md border border-red-700">

                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="none" stroke="currentColor"
                    viewBox="0 0 24 24" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">

                    <path d="M19 12H5M12 19l-7-7 7-7" />
                </svg>

                Kembali
            </a>
        </div>

        @if(session('error'))
            <div class="bg-red-50 border-l-4 border-red-500 text-red-700 p-4 rounded-r-lg mb-6 shadow-sm" role="alert">
                <div class="flex items-center">
                    <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd"
                            d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z"
                            clip-rule="evenodd"></path>
                    </svg>
                    <strong class="font-bold mr-1">Gagal!</strong>
                    <span class="block sm:inline">{{ session('error') }}</span>
                </div>
            </div>
        @endif

        @if ($errors->any())
            <div class="bg-red-50 border-l-4 border-red-500 text-red-700 p-4 rounded-r-lg mb-6 shadow-sm" role="alert">
                <div class="flex items-center mb-2">
                    <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd"
                            d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z"
                            clip-rule="evenodd"></path>
                    </svg>
                    <strong class="font-bold">Periksa kembali input Anda:</strong>
                </div>
                <ul class="list-disc pl-9 text-sm space-y-1">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="bg-white p-6 md:p-10 rounded-2xl shadow-xl border border-gray-100/50 relative overflow-hidden">
            <!-- Decorative background element -->
            <div class="absolute top-0 right-0 -mr-16 -mt-16 w-32 h-32 rounded-full bg-red-50 opacity-50 blur-2xl"></div>

            <form action="{{ route('admin.penjadwalan.store') }}" method="POST" class="relative z-10">
                @csrf

                <!-- Karyawan Input (Datalist for searchable) -->
                <div class="mb-6">
                    <label for="karyawan_input" class="block text-sm font-semibold text-gray-700 mb-2">Pilih
                        Karyawan</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                            </svg>
                        </div>
                        <input list="karyawans" id="karyawan_input"
                            class="w-full pl-10 pr-4 py-2.5 bg-gray-50 border border-gray-300 rounded-xl focus:bg-white focus:ring-2 focus:ring-red-500/20 focus:border-red-500 transition-all duration-200"
                            placeholder="Ketik nama karyawan..." oninput="updateKaryawanId()" required>
                    </div>
                    <datalist id="karyawans">
                        @foreach($karyawans as $k)
                            <option value="{{ $k->nama }}" data-id="{{ $k->id_karyawan }}"></option>
                        @endforeach
                    </datalist>
                    <input type="hidden" name="id_karyawan" id="id_karyawan" value="{{ old('id_karyawan') }}">
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                    <!-- Shift -->
                    <div>
                        <label for="shift" class="block text-sm font-semibold text-gray-700 mb-2">Pilih Shift</label>
                        <select name="shift" id="shift"
                            class="w-full px-4 py-2.5 bg-gray-50 border border-gray-300 rounded-xl focus:bg-white focus:ring-2 focus:ring-red-500/20 focus:border-red-500 transition-all duration-200"
                            required>
                            <option value="" disabled selected>-- Pilih Shift --</option>
                            <option value="Pagi" {{ old('shift') == 'Pagi' ? 'selected' : '' }}>Pagi (08:00 - 16:00)</option>
                            <option value="Malam" {{ old('shift') == 'Malam' ? 'selected' : '' }}>Malam (20:00 - 04:00)
                            </option>
                        </select>
                    </div>

                    <!-- Tanggal -->
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Periode Tanggal</label>
                        <div class="flex items-center gap-2">
                            <input type="date" name="tanggal_mulai"
                                value="{{ old('tanggal_mulai', \Carbon\Carbon::now()->startOfWeek()->format('Y-m-d')) }}"
                                class="w-full px-3 py-2.5 bg-gray-50 border border-gray-300 rounded-xl focus:bg-white focus:ring-2 focus:ring-red-500/20 focus:border-red-500 transition-all duration-200"
                                required>
                            <span class="text-gray-400 font-medium px-1">-</span>
                            <input type="date" name="tanggal_selesai"
                                value="{{ old('tanggal_selesai', \Carbon\Carbon::now()->endOfWeek()->format('Y-m-d')) }}"
                                class="w-full px-3 py-2.5 bg-gray-50 border border-gray-300 rounded-xl focus:bg-white focus:ring-2 focus:ring-red-500/20 focus:border-red-500 transition-all duration-200"
                                required>
                        </div>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-10">
                    <!-- Jam Masuk -->
                    <div>
                        <label for="jam_masuk" class="block text-sm font-semibold text-gray-700 mb-2">Jam Masuk</label>
                        <input type="time" name="jam_masuk" id="jam_masuk" value="{{ old('jam_masuk') }}"
                            class="w-full px-4 py-2.5 bg-gray-50 border border-gray-300 rounded-xl focus:bg-white focus:ring-2 focus:ring-red-500/20 focus:border-red-500 transition-all duration-200"
                            required>
                    </div>

                    <!-- Jam Pulang -->
                    <div>
                        <label for="jam_pulang" class="block text-sm font-semibold text-gray-700 mb-2">Jam Pulang</label>
                        <input type="time" name="jam_pulang" id="jam_pulang" value="{{ old('jam_pulang') }}"
                            class="w-full px-4 py-2.5 bg-gray-50 border border-gray-300 rounded-xl focus:bg-white focus:ring-2 focus:ring-red-500/20 focus:border-red-500 transition-all duration-200"
                            required>
                    </div>
                </div>

                <div class="flex items-center justify-end gap-3 pt-4 border-t border-gray-100">
                    <a href="{{ route('admin.penjadwalan.index') }}"
                        class="px-5 py-2 bg-white border border-gray-300 text-gray-700 rounded-xl font-medium hover:bg-gray-50 hover:text-gray-900 transition-colors focus:ring-2 focus:ring-gray-200">
                        Batal
                    </a>
                    <button type="submit"
                        class="flex items-center px-6 py-2 bg-green-700 text-white rounded-xl font-medium hover:bg-green-700 shadow-sm hover:shadow transition-all focus:ring-2 focus:ring-green-500/50">
                        Simpan Jadwal
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        function updateKaryawanId() {
            var input = document.getElementById('karyawan_input');
            var hiddenInput = document.getElementById('id_karyawan');
            var datalist = document.getElementById('karyawans');
            var options = datalist.options;

            hiddenInput.value = ''; // Reset

            for (var i = 0; i < options.length; i++) {
                if (options[i].value === input.value) {
                    hiddenInput.value = options[i].getAttribute('data-id');
                    break;
                }
            }
        }

        // Auto-fill jam berdasarkan pilihan shift
        document.getElementById('shift').addEventListener('change', function () {
            const jamMasuk = document.getElementById('jam_masuk');
            const jamPulang = document.getElementById('jam_pulang');

            if (this.value === 'Pagi') {
                jamMasuk.value = '08:00';
                jamPulang.value = '16:00';
            } else if (this.value === 'Malam') {
                jamMasuk.value = '20:00';
                jamPulang.value = '04:00';
            }
        });
    </script>
@endsection