@extends('admin.layout')

@section('content')

    <main class="ml-55 mt-15 p-3">

        <div class="p-6">
            <div
                class="bg-red-800 text-white rounded-2xl px-8 py-6 shadow-md flex flex-col md:flex-row md:items-center md:justify-between gap-4 mb-6">
                <div>
                    <h1 class="text-2xl font-bold">Tambah Karyawan</h1>
                </div>
            </div>

            <div class="bg-white rounded-lg shadow p-6">
                <form action="{{ route('admin.store_karyawan') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <div class="grid grid-cols-2 gap-6">
                        <!-- Foto -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Foto</label>
                            <div
                                class="border-2 border-dashed border-gray-300 rounded-lg p-1 text-center hover:border-red-500 transition relative h-64">
                                <input type="file" name="foto" accept="image/*" class="hidden" id="fotoInput">

                                <label for="fotoInput"
                                    class="cursor-pointer absolute inset-0 flex flex-col items-center justify-center z-10 w-full h-full rounded-lg overflow-hidden group">
                                    <img id="fotoPreview" class="hidden w-full h-full object-cover absolute inset-0 z-0"
                                        alt="Preview Foto">
                                    <div id="uploadPlaceholder"
                                        class="w-full h-full flex flex-col items-center justify-center z-10 transition-all duration-300 opacity-100 bg-transparent">
                                        <svg class="w-12 h-12 text-gray-400 mx-auto mb-2 group-hover:text-red-500 transition-colors"
                                            fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12" />
                                        </svg>
                                        <p class="text-sm text-gray-500 group-hover:text-red-500 transition-colors"
                                            id="uploadText">Klik untuk upload foto</p>
                                    </div>
                                </label>
                            </div>
                        </div>

                        <!-- Form Lainnya -->
                        <div>
                            <div class="mb-4">
                                <label class="block text-sm font-medium text-gray-700 mb-2">Nama Lengkap</label>
                                <input type="text" name="nama" required
                                    class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-red-500">
                            </div>

                            <div class="mb-4">
                                <label class="block text-sm font-medium text-gray-700 mb-2">Email</label>
                                <input type="email" name="email" required
                                    class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-red-500">
                            </div>

                            <div class="mb-4">
                                <label class="block text-sm font-medium text-gray-700 mb-2">Password</label>
                                <input type="password" name="password" required
                                    class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-red-500">
                            </div>

                            <div class="mb-4">
                                <label class="block text-sm font-medium text-gray-700 mb-2">Jabatan</label>
                                <input type="text" name="jabatan"
                                    class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-red-500">
                            </div>

                            <div class="mb-4">
                                <label class="block text-sm font-medium text-gray-700 mb-2">Role</label>
                                <select name="role"
                                    class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-red-500">
                                    <option value="karyawan">karyawan</option>
                                    <option value="supervisor">supervisor</option>
                                    <option value="leader_shift">leader_shift</option>
                                </select>
                            </div>

                            <div class="mb-4">
                                <label class="block text-sm font-medium text-gray-700 mb-2">Nama Bank</label>
                                <select name="nama_bank"
                                    class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-red-500">
                                    <option value="">-- Pilih Bank (Opsional) --</option>
                                    <option value="bca">BCA</option>
                                    <option value="mandiri">Mandiri</option>
                                    <option value="bni">BNI</option>
                                    <option value="bri">BRI</option>
                                    <option value="cimb">CIMB Niaga</option>
                                    <option value="gopay">GoPay</option>
                                    <option value="ovo">OVO</option>
                                </select>
                            </div>

                            <div class="mb-4">
                                <label class="block text-sm font-medium text-gray-700 mb-2">Nomor Rekening /
                                    E-Wallet</label>
                                <input type="text" name="no_rekening"
                                    class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-red-500">
                            </div>

                            <div class="mb-4">
                                <label class="block text-sm font-medium text-gray-700 mb-2">Status</label>
                                <select name="status"
                                    class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-red-500">
                                    <option value="aktif">Aktif</option>
                                    <option value="tidak_aktif">Tidak Aktif</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="flex justify-end gap-3 mt-6">
                        <a href="{{ route('admin.kelola_karyawan') }}"
                            class="px-4 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 transition">Batal</a>
                        <button type="submit"
                            class="px-4 py-2 bg-green-800 text-white rounded-lg hover:bg-green-700 transition">Simpan</button>
                    </div>
                </form>
            </div>
        </div>

    </main>

    <script>
        document.getElementById('fotoInput').addEventListener('change', function (event) {
            const file = event.target.files[0];
            if (file) {
                const preview = document.getElementById('fotoPreview');
                const placeholder = document.getElementById('uploadPlaceholder');
                const uploadText = document.getElementById('uploadText');

                // Set image preview source
                preview.src = URL.createObjectURL(file);
                preview.classList.remove('hidden');

                // Make placeholder act as a hover overlay
                placeholder.classList.add('absolute', 'inset-0', 'bg-black/50', 'opacity-0', 'hover:opacity-100');
                placeholder.classList.remove('w-full', 'h-full');

                // Turn text and icons white on hover over the image
                const svgIcon = placeholder.querySelector('svg');
                svgIcon.classList.replace('text-gray-400', 'text-white/80');
                svgIcon.classList.replace('group-hover:text-red-500', 'group-hover:text-white');

                uploadText.classList.replace('text-gray-500', 'text-white/80');
                uploadText.classList.replace('group-hover:text-red-500', 'group-hover:text-white');
                uploadText.innerText = "Klik untuk mengganti foto";
            }
        });
    </script>

@endsection