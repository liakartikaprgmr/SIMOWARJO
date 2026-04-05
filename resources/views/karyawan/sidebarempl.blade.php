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

            <div class="p-4 border-t border-red-700 flex items-center w-full">
                <!-- PROFILE & LOGOUT -->
                @php $user = auth()->user(); @endphp
                <div class="relative w-full">
                    <button id="profileBtn" class="w-full flex items-center justify-between focus:outline-none hover:bg-red-700 p-2 rounded-lg transition">
                        <div class="flex items-center gap-2">
                            <img src="{{ $user?->foto ? url($user->foto) : 'https://i.pravatar.cc/40' }}" class="w-10 h-10 rounded-full object-cover bg-white" alt="Profile">
                            <div class="text-sm text-left">
                                <p class="font-semibold text-white">{{ $user?->nama ?? 'Guest User' }}</p>
                                <p class="text-red-200 text-xs leading-tight">{{ $user?->email ?? 'Not Logged In' }}</p>
                            </div>
                        </div>
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-red-200" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                        </svg>
                    </button>
                    
                    @if(auth()->check())
                    <div id="profileDropdown" class="hidden absolute left-0 top-full mt-1 w-full bg-white border border-gray-100 rounded-lg shadow-lg py-2 z-50">
                        <form action="{{ route('logout') }}" method="POST">
                            @csrf
                            <button type="submit" class="w-full text-left px-4 py-2 text-sm text-red-600 hover:bg-red-50 hover:text-red-800 transition flex items-center gap-2">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-4 h-4">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 9V5.25A2.25 2.25 0 0013.5 3h-6a2.25 2.25 0 00-2.25 2.25v13.5A2.25 2.25 0 007.5 21h6a2.25 2.25 0 002.25-2.25V15M12 9l-3 3m0 0l3 3m-3-3h12.75" />
                                </svg>
                                Logout
                            </button>
                        </form>
                    </div>
                    @endif
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

        // Script untuk Profile Dropdown di Sidebar
        const profileBtn = document.getElementById('profileBtn');
        const profileDropdown = document.getElementById('profileDropdown');
        
        if (profileBtn && profileDropdown) {
            profileBtn.addEventListener('click', (e) => {
                e.stopPropagation();
                // Munculin ke bawah / toggle class hidden
                profileDropdown.classList.toggle('hidden');
            });

            document.addEventListener('click', (e) => {
                if (!profileBtn.contains(e.target) && !profileDropdown.contains(e.target)) {
                    profileDropdown.classList.add('hidden');
                }
            });
        }
    </script>
</body>
</html>