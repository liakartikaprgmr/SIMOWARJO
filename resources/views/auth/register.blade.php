<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>REGISTER PENGGUNA</title>

    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-red-800 min-h-screen flex items-center justify-center py-10">
    <div class="bg-white shadow-2xl rounded-2xl p-8 w-full max-w-md">
        <!-- Logo / Title -->
        <div class="text-center mb-6">
            <h1 class="text-3xl font-bold text-red-800">SIMOWARJO</h1>
            <p class="text-gray-500 text-sm">E-HR Simowarjo</p>
        </div>
        <!-- Form -->
        <form method="POST" action="/register">
        @csrf    

        @if(session('success'))
            <div class="bg-green-500 text-white p-3 rounded mb-3">
                {{ session('success') }}
            </div>
        @endif

        @if ($errors->any())
            <div class="bg-red-500 text-white p-3 rounded mb-3">
                <ul class="text-sm">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
            <!-- Nama -->
            <div class="mb-4">
                <label class="block text-sm font-semibold mb-1">Nama Lengkap</label>
                <input type="text" name="nama" required
                    class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-green-400">
            </div>
            <!-- Email -->
            <div class="mb-4">
                <label class="block text-sm font-semibold mb-1">Email</label>
                <input type="email" name="email" required
                    class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-green-400">
            </div>
            <!-- No HP -->
            <div class="mb-4">
                <label class="block text-sm font-semibold mb-1">No HP</label>
                <input type="text" name="no_hp"
                    class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-green-400">
            </div>
            <!-- Jabatan -->
            <div class="mb-4">
                <label class="block text-sm font-semibold mb-1">Jabatan</label>
                <input type="text" name="jabatan"
                    class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-green-400">
            </div>
            <!-- Password -->
            <div class="mb-4">
                <label class="block text-sm font-semibold mb-1">Password</label>
                <input type="password" name="password" required
                    class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-green-400">
            </div>
            <!-- Upload Foto -->
            <div class="mb-4">
                <label class="block text-sm font-semibold mb-1">Upload Foto</label>
                <input type="file" name="foto"
                    class="w-full text-sm">
            </div>

            <!-- Button -->
            <button type="submit"
                class="w-full bg-green-500 hover:bg-green-600 text-white py-2 rounded-lg font-semibold transition">
                Daftar
            </button>
        </form>

        <!-- Login Link -->
        <p class="text-center text-sm text-gray-500 mt-4">
            Sudah punya akun?
            <a href="/login" class="text-green-600 font-semibold">Login</a>
        </p>
    </div>

</body>
</html>