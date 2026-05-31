<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Karyawan Dashboard</title>

    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">

    <!-- SIDEBAR -->
    <aside id="sidebar"
    class="fixed top-0 left-0 w-64 h-screen bg-red-800 text-white pt-6 transform -translate-x-full md:translate-x-0 transition-transform duration-300">
        <div>
            <div class="flex items-center gap-3 px-4">
                <img src="{{ asset('assets/logo.png') }}" class="w-10 h-10 bg-white rounded-full" alt="">
                <h1 class="font-bold text-lg">SIMOWARJO</h1>
            </div>

            <nav class="px-4 space-y-6">
                <!-- UTAMA -->
                <div>
                    <p class="text-xs text-red-200 mb-2 py-2">SELF SERVICE</p>
                    <a href="#" class="flex items-center gap-2 p-2 rounded-lg hover:bg-red-700">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path fill="currentColor" d="M4 13h6c.55 0 1-.45 1-1V4c0-.55-.45-1-1-1H4c-.55 0-1 .45-1 1v8c0 .55.45 1 1 1m0 8h6c.55 0 1-.45 1-1v-4c0-.55-.45-1-1-1H4c-.55 0-1 .45-1 1v4c0 .55.45 1 1 1m10 0h6c.55 0 1-.45 1-1v-8c0-.55-.45-1-1-1h-6c-.55 0-1 .45-1 1v8c0 .55.45 1 1 1M13 4v4c0 .55.45 1 1 1h6c.55 0 1-.45 1-1V4c0-.55-.45-1-1-1h-6c-.55 0-1 .45-1 1"/></svg>
                        Dashboard
                    </a>
                    <a href="/karyawan/presensi" class="flex items-center gap-2 p-2 rounded-lg hover:bg-red-700">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><circle cx="12" cy="12" r="3.2" fill="currentColor"/><path fill="currentColor" d="M9 2L7.17 4H4c-1.1 0-2 .9-2 2v12c0 1.1.9 2 2 2h16c1.1 0 2-.9 2-2V6c0-1.1-.9-2-2-2h-3.17L15 2zm3 15c-2.76 0-5-2.24-5-5s2.24-5 5-5s5 2.24 5 5s-2.24 5-5 5"/></svg>
                        Presensi Wajah
                    <span class="ml-auto text-[10px] px-2 py-0.5 rounded-full bg-blue-500/20 text-blue-300 font-semibold">
                        AI
                    </span>
                    </a>
                    <a href="#" class="flex items-center gap-2 p-2 rounded-lg hover:bg-red-700">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path fill="currentColor" d="M19 4h-1V2h-2v2H8V2H6v2H5c-1.11 0-1.99.9-1.99 2L3 20a2 2 0 0 0 2 2h14c1.1 0 2-.9 2-2V6c0-1.1-.9-2-2-2m0 16H5V10h14zM9 14H7v-2h2zm4 0h-2v-2h2zm4 0h-2v-2h2zm-8 4H7v-2h2zm4 0h-2v-2h2zm4 0h-2v-2h2z"/></svg>
                        Kehadiran
                    </a>
                    <a href="#" class="flex items-center gap-2 p-2 rounded-lg hover:bg-red-700">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path fill="currentColor" d="M19 14V6c0-1.1-.9-2-2-2H3c-1.1 0-2 .9-2 2v8c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2m-9-1c-1.66 0-3-1.34-3-3s1.34-3 3-3s3 1.34 3 3s-1.34 3-3 3m13-6v11c0 1.1-.9 2-2 2H4v-2h17V7z"/></svg>
                        Slip Gaji
                    </a>
                    <div>
                    <!-- Parent Menu -->
                    <div onclick="toggleDropdown()" class="flex items-center justify-between gap-2 p-2 rounded-lg hover:bg-red-700 cursor-pointer">
                        <div class="flex items-center gap-2">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor"><path d="M22 5v2h-3v3h-2V7h-3V5h3V2h2v3zm-3 14H5V5h6V3H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2v-6h-2zm-4-6v4h2v-4zm-4 4h2V9h-2zm-2 0v-6H7v6z"/></svg>
                            <span>Manajemen Kehadiran</span>
                        </div>
                        <svg id="arrowIcon" xmlns="http://www.w3.org/2000/svg" width="20" height="20" class="transition-transform">
                            <path fill="currentColor" d="M6.23 20.23L8 22l10-10L8 2L6.23 3.77L14.46 12z"/>
                        </svg>
                    </div>
                    <!-- Dropdown Menu -->
                    <div id="dropdownMenu" class="hidden flex flex-col ml-6 mt-2 gap-1">
                        <a href="#" class="p-2 rounded hover:bg-red-700">Pengajuan Izin</a>
                        <a href="#" class="p-2 rounded hover:bg-red-700">Sick Leave</a>
                    </div>
                </div>
            </nav>

             <div class="p-4 border-t border-red-700 flex items-center gap-4">
            <img src="https://i.pravatar.cc/40" class="w-8 h-8 rounded-full">
            <div>
                <p class="font-semibold text-sm">Amar</p>
                <p class="text-xs text-red-200">Karyawan</p>
            </div>
        </div>
        </div>
    </aside>

    <!-- SCRIPT SIDEBAR -->
    <script>
        const menuBtn = document.getElementById('menuBtn');
        const sidebar = document.getElementById('sidebar');
        menuBtn.addEventListener('click', () => {
        sidebar.classList.toggle('-translate-x-full');
        });
    </script>
    <!-- SCRIPT DROPDOWN -->
     <script>
        function toggleDropdown() {
            const menu = document.getElementById("dropdownMenu");
            const icon = document.getElementById("arrowIcon");
            menu.classList.toggle("hidden");
            // Rotate icon
            icon.classList.toggle("rotate-90");
        }
        </script>
</body>
</html>