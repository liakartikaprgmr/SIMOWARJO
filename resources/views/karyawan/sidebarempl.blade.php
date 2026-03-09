<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Karyawan Dashboard</title>

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
                <p class="font-semibold">Amar</p>
                <p class="text-gray-500 text-xs">Karyawan</p>
            </div>
        </div>
    </header>

    <!-- SIDEBAR -->
    <aside id="sidebar"
    class="fixed top-16 left-0 w-64 h-screen bg-red-800 text-white pt-6 transform -translate-x-full md:translate-x-0 transition-transform duration-300">
        <nav class="px-4 space-y-6">
            <!-- UTAMA -->
            <div>
                <p class="text-xs text-red-200 mb-2">SELF SERVICE</p>
                <a href="#" class="flex items-center gap-2 p-2 rounded-lg hover:bg-red-700">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path fill="currentColor" d="M4 13h6c.55 0 1-.45 1-1V4c0-.55-.45-1-1-1H4c-.55 0-1 .45-1 1v8c0 .55.45 1 1 1m0 8h6c.55 0 1-.45 1-1v-4c0-.55-.45-1-1-1H4c-.55 0-1 .45-1 1v4c0 .55.45 1 1 1m10 0h6c.55 0 1-.45 1-1v-8c0-.55-.45-1-1-1h-6c-.55 0-1 .45-1 1v8c0 .55.45 1 1 1M13 4v4c0 .55.45 1 1 1h6c.55 0 1-.45 1-1V4c0-.55-.45-1-1-1h-6c-.55 0-1 .45-1 1"/></svg>
                    Dashboard
                </a>
                <a href="#" class="flex items-center gap-2 p-2 rounded-lg hover:bg-red-700">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><circle cx="12" cy="12" r="3.2" fill="currentColor"/><path fill="currentColor" d="M9 2L7.17 4H4c-1.1 0-2 .9-2 2v12c0 1.1.9 2 2 2h16c1.1 0 2-.9 2-2V6c0-1.1-.9-2-2-2h-3.17L15 2zm3 15c-2.76 0-5-2.24-5-5s2.24-5 5-5s5 2.24 5 5s-2.24 5-5 5"/></svg>
                    Absen Wajah
                </a>
                <a href="#" class="flex items-center gap-2 p-2 rounded-lg hover:bg-red-700">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path fill="currentColor" d="M19 4h-1V2h-2v2H8V2H6v2H5c-1.11 0-1.99.9-1.99 2L3 20a2 2 0 0 0 2 2h14c1.1 0 2-.9 2-2V6c0-1.1-.9-2-2-2m0 16H5V10h14zM9 14H7v-2h2zm4 0h-2v-2h2zm4 0h-2v-2h2zm-8 4H7v-2h2zm4 0h-2v-2h2zm4 0h-2v-2h2z"/></svg>
                    Presensi
                </a>
                <a href="#" class="flex items-center gap-2 p-2 rounded-lg hover:bg-red-700">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path fill="currentColor" d="M19 14V6c0-1.1-.9-2-2-2H3c-1.1 0-2 .9-2 2v8c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2m-9-1c-1.66 0-3-1.34-3-3s1.34-3 3-3s3 1.34 3 3s-1.34 3-3 3m13-6v11c0 1.1-.9 2-2 2H4v-2h17V7z"/></svg>
                    Slip Gaji
                </a>
                <a href="#" class="flex items-center gap-2 p-2 rounded-lg hover:bg-red-700">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path fill="currentColor" d="M21 5c-1.11-.35-2.33-.5-3.5-.5c-1.95 0-4.05.4-5.5 1.5c-1.45-1.1-3.55-1.5-5.5-1.5S2.45 4.9 1 6v14.65c0 .25.25.5.5.5c.1 0 .15-.05.25-.05C3.1 20.45 5.05 20 6.5 20c1.95 0 4.05.4 5.5 1.5c1.35-.85 3.8-1.5 5.5-1.5c1.65 0 3.35.3 4.75 1.05c.1.05.15.05.25.05c.25 0 .5-.25.5-.5V6c-.6-.45-1.25-.75-2-1m0 13.5c-1.1-.35-2.3-.5-3.5-.5c-1.7 0-4.15.65-5.5 1.5V8c1.35-.85 3.8-1.5 5.5-1.5c1.2 0 2.4.15 3.5.5z"/><path fill="currentColor" d="M17.5 10.5c.88 0 1.73.09 2.5.26V9.24c-.79-.15-1.64-.24-2.5-.24c-1.7 0-3.24.29-4.5.83v1.66c1.13-.64 2.7-.99 4.5-.99M13 12.49v1.66c1.13-.64 2.7-.99 4.5-.99c.88 0 1.73.09 2.5.26V11.9c-.79-.15-1.64-.24-2.5-.24c-1.7 0-3.24.3-4.5.83m4.5 1.84c-1.7 0-3.24.29-4.5.83v1.66c1.13-.64 2.7-.99 4.5-.99c.88 0 1.73.09 2.5.26v-1.52c-.79-.16-1.64-.24-2.5-.24"/></svg>
                    Training
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