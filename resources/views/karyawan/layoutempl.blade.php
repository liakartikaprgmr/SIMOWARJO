<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Karyawan</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100">

    <!-- Mobile Header -->
    <div
        class="md:hidden fixed top-0 left-0 w-full bg-red-800 text-white z-40 px-4 py-3 flex items-center justify-between shadow-md">
        <div class="flex items-center gap-2">
            <img src="{{ asset('assets/logo.png') }}" class="w-8 h-8 bg-white rounded-full" alt="Logo">
            <h1 class="font-bold text-lg">SIMOWARJO</h1>
        </div>
        <button id="menuBtn" class="focus:outline-none p-1 bg-red-700 rounded-md">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24"
                stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
            </svg>
        </button>
    </div>

    <!-- Sidebar -->
    @include('karyawan.sidebarempl')

    <!-- Content -->
    <div class="ml-0 md:ml-64 p-4 md:p-8 pt-20 md:pt-8 transition-all duration-300">
        @yield('content')
    </div>

</body>

</html>