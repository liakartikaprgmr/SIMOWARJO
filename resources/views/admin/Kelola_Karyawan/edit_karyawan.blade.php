@extends('admin.layout')

@section('content')

<main class="ml-55 mt-15 p-3">

    <div class="p-6">
        <h1 class="text-2xl font-bold mb-6">Edit Karyawan</h1>

        <div class="bg-white rounded-lg shadow p-6">
            <form action="{{ route('admin.update_karyawan', $karyawan->id_karyawan) }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="grid grid-cols-2 gap-6">
                    <!-- Foto -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Foto</label>
                        <div class="border-2 border-dashed border-gray-300 rounded-lg p-6 text-center hover:border-red-500 transition">
                            <input type="file" name="foto" accept="image/*" class="hidden" id="fotoInput">
                            <label for="fotoInput" class="cursor-pointer">
                                <svg class="w-12 h-12 text-gray-400 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"/>
                                </svg>
                                <p class="text-sm text-gray-500">Klik untuk upload foto</p>
                            </label>
                        </div>
                    </div>

                    <!-- Form Lainnya -->
                    <div>
                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Nama Lengkap</label>
                            <input type="text" name="nama" value="{{ $karyawan->nama }}" required class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-red-500">
                        </div>

                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Email</label>
                            <input type="email" name="email" value="{{ $karyawan->email }}" required class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-red-500">
                        </div>

                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Password</label>
                            <input type="password" name="password" value="{{ $karyawan->password }}" required class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-red-500">
                        </div>

                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Jabatan</label>
                            <input type="text" name="jabatan" value="{{ $karyawan->jabatan }}" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-red-500">
                        </div>

                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Role</label>
                            <select name="role" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-red-500">
                                <option value="karyawan" {{ $karyawan->role == 'karyawan' ? 'selected' : '' }}>Karyawan</option>
                                <option value="supervisor" {{ $karyawan->role == 'supervisor' ? 'selected' : '' }}>Supervisor</option>
                                <option value="leader_shift" {{ $karyawan->role == 'leader_shift' ? 'selected' : '' }}>Leader Shift</option>
                            </select>
                        </div>

                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Nama Bank</label>
                            <select name="nama_bank" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-red-500">
                                <option value="">-- Pilih Bank (Opsional) --</option>
                                <option value="bca" {{ $karyawan->nama_bank == 'bca' ? 'selected' : '' }}>BCA</option>
                                <option value="mandiri" {{ $karyawan->nama_bank == 'mandiri' ? 'selected' : '' }}>Mandiri</option>
                                <option value="bni" {{ $karyawan->nama_bank == 'bni' ? 'selected' : '' }}>BNI</option>
                                <option value="bri" {{ $karyawan->nama_bank == 'bri' ? 'selected' : '' }}>BRI</option>
                                <option value="cimb" {{ $karyawan->nama_bank == 'cimb' ? 'selected' : '' }}>CIMB Niaga</option>
                                <option value="gopay" {{ $karyawan->nama_bank == 'gopay' ? 'selected' : '' }}>GoPay</option>
                                <option value="ovo" {{ $karyawan->nama_bank == 'ovo' ? 'selected' : '' }}>OVO</option>
                            </select>
                        </div>

                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Nomor Rekening / E-Wallet</label>
                            <input type="text" name="no_rekening" value="{{ $karyawan->no_rekening }}" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-red-500">
                        </div>

                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Status</label>
                            <select name="status" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-red-500">
                                <option value="aktif" {{ $karyawan->status == 'aktif' ? 'selected' : '' }}>Aktif</option>
                                <option value="tidak_aktif" {{ $karyawan->status == 'tidak_aktif' ? 'selected' : '' }}>Tidak Aktif</option>
                            </select>
                        </div>
                    </div>
                </div>

                <div class="flex justify-end gap-3 mt-6">
                    <a href="{{ route('admin.kelola_karyawan') }}" class="px-4 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 transition">Batal</a>
                    <button type="submit" class="px-4 py-2 bg-green-800 text-white rounded-lg hover:bg-green-700 transition">Simpan</button>
                </div>
            </form>
        </div>
    </div>  

</main>

@endsection