<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Dashboard</title>

    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">
    <!-- NAVBAR -->
    <header class="fixed top-0 left-0 right-0 h-16 bg-white shadow flex items-center justify-between px-6">
        <!-- LOGO -->
        <div class="flex items-center gap-3">
        <!-- HAMBURGER (mobile) -->
            <button id="menuBtn" class="md:hidden text-2xl">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path fill="currentColor" d="M4 18h16c.55 0 1-.45 1-1s-.45-1-1-1H4c-.55 0-1 .45-1 1s.45 1 1 1m0-5h16c.55 0 1-.45 1-1s-.45-1-1-1H4c-.55 0-1 .45-1 1s.45 1 1 1M3 7c0 .55.45 1 1 1h16c.55 0 1-.45 1-1s-.45-1-1-1H4c-.55 0-1 .45-1 1"/></svg>
            </button>

            <img src="{{ asset('assets/logo.png') }}" class="w-10 h-10" alt="">
            <h1 class="font-bold text-lg text-red-800">SIMOWARJO</h1>
        </div>

        <!-- PROFILE -->
        <div class="flex items-center gap-3">
            <img src="https://i.pravatar.cc/40" class="w-10 h-10 rounded-full" alt="">
            <div class="text-sm">
                <p class="font-semibold">Admin Warjo</p>
                <p class="text-gray-500 text-xs">Administrator</p>
            </div>
        </div>
    </header>

    <!-- SIDEBAR -->
    <aside id="sidebar"
    class="fixed top-16 left-0 w-64 h-screen bg-red-800 text-white pt-6 transform -translate-x-full md:translate-x-0 transition-transform duration-300">
        <nav class="px-4 space-y-6">
            <!-- UTAMA -->
            <div>
                <p class="text-xs text-red-200 mb-2">UTAMA</p>
                <a href="#" class="flex items-center gap-2 p-2 rounded-lg hover:bg-red-700">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path fill="currentColor" d="M4 13h6c.55 0 1-.45 1-1V4c0-.55-.45-1-1-1H4c-.55 0-1 .45-1 1v8c0 .55.45 1 1 1m0 8h6c.55 0 1-.45 1-1v-4c0-.55-.45-1-1-1H4c-.55 0-1 .45-1 1v4c0 .55.45 1 1 1m10 0h6c.55 0 1-.45 1-1v-8c0-.55-.45-1-1-1h-6c-.55 0-1 .45-1 1v8c0 .55.45 1 1 1M13 4v4c0 .55.45 1 1 1h6c.55 0 1-.45 1-1V4c0-.55-.45-1-1-1h-6c-.55 0-1 .45-1 1"/></svg>
                    Dashboard
                </a>
                <a href="#" class="flex items-center gap-2 p-2 rounded-lg hover:bg-red-700">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path fill="currentColor" d="M11.99 2C6.47 2 2 6.48 2 12s4.47 10 9.99 10C17.52 22 22 17.52 22 12S17.52 2 11.99 2M12 20c-4.42 0-8-3.58-8-8s3.58-8 8-8s8 3.58 8 8s-3.58 8-8 8"/><path fill="currentColor" d="M12.5 7H11v6l5.25 3.15l.75-1.23l-4.5-2.67z"/></svg>
                    Kehadiran
                </a>
                <a href="#" class="flex items-center gap-2 p-2 rounded-lg hover:bg-red-700">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><circle cx="12" cy="12" r="3.2" fill="currentColor"/><path fill="currentColor" d="M9 2L7.17 4H4c-1.1 0-2 .9-2 2v12c0 1.1.9 2 2 2h16c1.1 0 2-.9 2-2V6c0-1.1-.9-2-2-2h-3.17L15 2zm3 15c-2.76 0-5-2.24-5-5s2.24-5 5-5s5 2.24 5 5s-2.24 5-5 5"/></svg>
                    Absen Wajah
                </a>
            </div>

            <!-- MANAJEMEN -->
            <div>
                <p class="text-xs text-red-200 mb-2">MANAJEMEN</p>
                <a href="#" class="flex items-center gap-2 p-2 rounded-lg hover:bg-red-700">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path fill="currentColor" d="M9 13.75c-2.34 0-7 1.17-7 3.5V19h14v-1.75c0-2.33-4.66-3.5-7-3.5M4.34 17c.84-.58 2.87-1.25 4.66-1.25s3.82.67 4.66 1.25zM9 12c1.93 0 3.5-1.57 3.5-3.5S10.93 5 9 5S5.5 6.57 5.5 8.5S7.07 12 9 12m0-5c.83 0 1.5.67 1.5 1.5S9.83 10 9 10s-1.5-.67-1.5-1.5S8.17 7 9 7m7.04 6.81c1.16.84 1.96 1.96 1.96 3.44V19h4v-1.75c0-2.02-3.5-3.17-5.96-3.44M15 12c1.93 0 3.5-1.57 3.5-3.5S16.93 5 15 5c-.54 0-1.04.13-1.5.35c.63.89 1 1.98 1 3.15s-.37 2.26-1 3.15c.46.22.96.35 1.5.35"/></svg>
                    Karyawan
                </a>
                <a href="#" class="flex items-center gap-2 p-2 rounded-lg hover:bg-red-700">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path fill="currentColor" d="M21 3H3c-1.1 0-2 .9-2 2v8h2V5h18v16c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2"/><circle cx="9" cy="10" r="4" fill="currentColor"/><path fill="currentColor" d="M15.39 16.56C13.71 15.7 11.53 15 9 15s-4.71.7-6.39 1.56A2.97 2.97 0 0 0 1 19.22V22h16v-2.78c0-1.12-.61-2.15-1.61-2.66"/></svg>
                    Manajemen User
                </a>
                <a href="#" class="flex items-center gap-2 p-2 rounded-lg hover:bg-red-700">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path fill="currentColor" d="M20 3h-1V1h-2v2H7V1H5v2H4c-1.1 0-2 .9-2 2v16c0 1.1.9 2 2 2h16c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2m0 18H4V8h16z"/></svg>
                    Jadwal Shift
                </a>
                <a href="#" class="flex items-center gap-2 p-2 rounded-lg hover:bg-red-700">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path fill="currentColor" d="M4 9h4v11H4zm12 4h4v7h-4zm-6-9h4v16h-4z"/></svg>
                    Laporan Keuangan
                </a>
            </div>


            <!-- OPERASIONAL -->
            <div>
                <p class="text-xs text-red-200 mb-2">OPERASIONAL</p>
                <a href="#" class="flex items-center gap-2 p-2 rounded-lg hover:bg-red-700">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path fill="currentColor" d="M11.8 10.9c-2.27-.59-3-1.2-3-2.15c0-1.09 1.01-1.85 2.7-1.85c1.78 0 2.44.85 2.5 2.1h2.21c-.07-1.72-1.12-3.3-3.21-3.81V3h-3v2.16c-1.94.42-3.5 1.68-3.5 3.61c0 2.31 1.91 3.46 4.7 4.13c2.5.6 3 1.48 3 2.41c0 .69-.49 1.79-2.7 1.79c-2.06 0-2.87-.92-2.98-2.1h-2.2c.12 2.19 1.76 3.42 3.68 3.83V21h3v-2.15c1.95-.37 3.5-1.5 3.5-3.55c0-2.84-2.43-3.81-4.7-4.4"/></svg>
                    Penggajian
                </a>
                <a href="#" class="flex items-center gap-2 p-2 rounded-lg hover:bg-red-700">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path fill="currentColor" d="M20 4H4v2h16zm1 10v-2l-1-5H4l-1 5v2h1v6h10v-6h4v6h2v-6zm-9 4H6v-4h6z"/></svg>
                    Stok Barang
                </a>
                <a href="#" class="flex items-center gap-2 p-2 rounded-lg hover:bg-red-700">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path fill="currentColor" d="M7 18c-1.1 0-1.99.9-1.99 2S5.9 22 7 22s2-.9 2-2s-.9-2-2-2M1 2v2h2l3.6 7.59l-1.35 2.45c-.16.28-.25.61-.25.96c0 1.1.9 2 2 2h12v-2H7.42c-.14 0-.25-.11-.25-.25l.03-.12l.9-1.63h7.45c.75 0 1.41-.41 1.75-1.03l3.58-6.49A1.003 1.003 0 0 0 20 4H5.21l-.94-2zm16 16c-1.1 0-1.99.9-1.99 2s.89 2 1.99 2s2-.9 2-2s-.9-2-2-2"/></svg>
                    Pengadaan Barang
                </a>
            </div>
        </nav>
    </aside>

    <!-- SCRIPT SIDEBAR -->
    <script>
        const menuBtn = document.getElementById('menuBtn');
        const sidebar = document.getElementById('sidebar');
        menuBtn.addEventListener('click', () => {
        sidebar.classList.toggle('-translate-x-full');
        });
    </script>
</body>
</html>