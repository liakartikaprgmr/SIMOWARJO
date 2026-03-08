<!DOCTYPE html>
    <html lang="id">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>SIMOWARJO</title>

            <script src="https://cdn.tailwindcss.com"></script>
            <script>tailwind.config = {darkMode: 'class'} </script>
            <script src="https://code.iconify.design/iconify-icon/1.0.7/iconify-icon.min.js"></script>
        </head>

    <body class="bg-red-50 dark:bg-gray-700 transition duration-300">

    <!-- NAVBAR -->
    <nav class="max-w-9xl mx-auto mt-6 px-6">  
        <div class="bg-white/50 dark:bg-gray-800/50 backdrop-blur-md rounded-2xl shadow-md px-6 py-4">
            <div class="flex items-center justify-between">
                <!-- Logo -->
                <div class="flex items-center space-x-1">
                    <img src="{{ asset('assets/logo.png') }}" class="h-12">
                    <h1 class="text-lg font-bold text-red-700">SIMOWARJO</h1>
                </div>
                <!-- Menu Desktop -->
                <div class="hidden md:flex space-x-8 text-gray-700 dark:text-gray-200 font-medium">
                    <a href="#" class="hover:text-red-600">Beranda</a>
                    <a href="#" class="hover:text-red-600">Fitur</a>
                    <a href="#" class="hover:text-red-600">Tentang</a>
                    <a href="#" class="hover:text-red-600">Kontak</a>
                </div>
            <div class="flex items-center gap-4">
                <!-- DARK MODE BUTTON -->
                <button id="themeToggle" class="w-16 h-8 flex items-center bg-stone-100 dark:bg-gray-700 rounded-full p-1 transition">
                    <div id="toggleCircle"
                    class="bg-white w-6 h-6 rounded-full shadow-md transform transition flex items-center justify-center">
                    <iconify-icon id="icon" icon="mdi:white-balance-sunny" width="16"></iconify-icon>
                    </div>
                </button>
                <!-- Login Button -->
                <div class="hidden md:block">
                <button class="bg-red-700 text-white px-5 py-2 rounded-lg hover:bg-red-800">
                Login
                </button>
                </div>
                <!-- Mobile Button -->
                <button id="menuBtn" class="md:hidden text-2xl dark:text-white">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
                        <path fill="currentColor" d="M2 16v2h20v-2zm0-5v2h20v-2zm0-5v2h20V6z"/></svg>
                </button>
            </div>
        </div>

            <!-- Mobile Menu -->
            <div id="mobileMenu" class="hidden md:hidden mt-4 flex flex-col space-y-3 text-gray-700 dark:text-gray-200 font-medium">
                <a href="#" class="hover:text-red-600">Beranda</a>
                <a href="#" class="hover:text-red-600">Fitur</a>
                <a href="#" class="hover:text-red-600">Tentang</a>
                <a href="#" class="hover:text-red-600">Kontak</a>
                <button class="bg-red-600 text-white px-5 py-2 rounded-lg w-full">
                Login
                </button>
            </div>
        </div>
    </nav>


    <!-- HERO SECTION -->
    <section class="relative max-w-7xl mx-auto py-20 px-6">
        <div class="relative flex items-center">

            <!-- CARD WELCOME -->
            <div class="bg-white/80 dark:bg-gray-800/80 backdrop-blur-md p-12 rounded-xl shadow-xl max-w-xl relative z-10">
                <h1 class="text-4xl font-bold text-gray-800 dark:text-white mb-4">
                Selamat Datang di 
                <span class="text-red-700">SIMOWARJO</span>
                </h1>
                    <p class="text-gray-600 dark:text-gray-300 mb-6">
                    Sistem Manajemen Operasional Warjo yang membantu mengelola
                    operasional warung secara efisien dan terintegrasi.
                    </p>

                <div class="flex gap-4 mb-10">
                    <button class="bg-red-700 text-white px-6 py-3 rounded-lg">
                        Masuk Sistem
                    </button>
                    <button class="border dark:border-gray-500 px-6 py-3 rounded-lg dark:text-white">
                        Pelajari Fitur
                    </button>
                </div>

                <!-- FITUR -->
                <div class="flex justify-between text-center dark:text-white">
                    <div>
                        <div class="flex justify-center text-red-700">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-8 h-8" viewBox="0 0 24 24">
                                <path fill="currentColor" d="M12 22H5a2 2 0 0 1-2-2l.01-14c0-1.1.88-2 1.99-2h1V3c0-.55.45-1 1-1s1 .45 1 1v1h8V3c0-.55.45-1 1-1s1 .45 1 1v1h1c1.1 0 2 .9 2 2v6h-2v-2H5v10h7zm10.13-5.01l.71-.71a.996.996 0 0 0 0-1.41l-.71-.71a.996.996 0 0 0-1.41 0l-.71.71zm-.71.71l-5.01 5.01c-.18.18-.44.29-.7.29H14.5c-.28 0-.5-.22-.5-.5v-1.21c0-.27.11-.52.29-.71l5.01-5.01z"/>
                            </svg>
                        </div>
                        <p class="mt-2 font-medium">Presensi & Penggajian</p>
                    </div>
                    <div>
                        <div class="flex justify-center text-red-700">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-8 h-8" viewBox="0 0 24 24">
                            <path fill="currentColor" d="M20.16 7.8c-.09-.46-.5-.8-.98-.8H4.82c-.48 0-.89.34-.98.8L3 12v1c0 .55.45 1 1 1v5c0 .55.45 1 1 1h8c.55 0 1-.45 1-1v-5h4v5c0 .55.45 1 1 1s1-.45 1-1v-5c.55 0 1-.45 1-1v-1zM12 18H6v-4h6zM5 6h14c.55 0 1-.45 1-1s-.45-1-1-1H5c-.55 0-1 .45-1 1s.45 1 1 1"/></svg>    
                        </div>
                        <p class="mt-2 font-medium">Stok Barang</p>
                    </div>
                    <div>
                        <div class="flex justify-center text-red-700">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-8 h-8" viewBox="0 0 24 24">
                            <path fill="currentColor" d="M11 2v20c-5.07-.5-9-4.79-9-10s3.93-9.5 9-10m2.03 0v8.99H22c-.47-4.74-4.24-8.52-8.97-8.99m0 11.01V22c4.74-.47 8.5-4.25 8.97-8.99z"/></svg>
                        </div>
                        <p class="mt-2 font-medium">Laporan</p>
                    </div>
                </div>
            </div>


            <!-- IMAGE -->
            <div class="absolute right-0 top-1/2 -translate-y-1/2 w-[55%] z-0">
                <img 
                src="{{ asset('assets/potowarjo.png') }}"
                class="rounded-3xl shadow-xl w-full h-[500px] object-cover">
            </div>

        </div>
    </section>


    <!-- FITUR -->
    <section class="bg-white dark:bg-gray-900 py-16">
        <div class="max-w-7xl mx-auto px-6">
            <h2 class="text-3xl font-bold text-center mb-12 text-gray-800 dark:text-white">
                Fitur Utama SIMOWARJO
            </h2>
            <div class="grid md:grid-cols-3 gap-8">
                <!-- CARD -->
                <div class="group bg-gray-50 dark:bg-gray-800 p-8 rounded-2xl border border-gray-200 dark:border-gray-700
                            shadow-sm transition-all duration-500 ease-out
                            hover:-translate-y-3 hover:scale-[1.03] hover:shadow-2xl hover:border-red-500">

                    <h3 class="text-xl font-bold text-red-700 mb-3 group-hover:text-red-600 transition">
                        Presensi & Penggajian
                    </h3>
                    <p class="text-gray-600 dark:text-gray-300 leading-relaxed">
                        Kelola absensi karyawan dan penggajian secara otomatis dan akurat.
                    </p>
                </div>

                <!-- CARD -->
                <div class="group bg-gray-50 dark:bg-gray-800 p-8 rounded-2xl border border-gray-200 dark:border-gray-700
                            shadow-sm transition-all duration-500 ease-out
                            hover:-translate-y-3 hover:scale-[1.03] hover:shadow-2xl hover:border-red-500">

                    <h3 class="text-xl font-bold text-red-700 mb-3 group-hover:text-red-600 transition">
                        Pengelolaan Stok Barang
                    </h3>
                    <p class="text-gray-600 dark:text-gray-300 leading-relaxed">
                        Memantau stok bahan baku dan barang secara real time.
                    </p>
                </div>

                <!-- CARD -->
                <div class="group bg-gray-50 dark:bg-gray-800 p-8 rounded-2xl border border-gray-200 dark:border-gray-700
                            shadow-sm transition-all duration-500 ease-out
                            hover:-translate-y-3 hover:scale-[1.03] hover:shadow-2xl hover:border-red-500">

                    <h3 class="text-xl font-bold text-red-700 mb-3 group-hover:text-red-600 transition">
                        Laporan Keuangan
                    </h3>
                    <p class="text-gray-600 dark:text-gray-300 leading-relaxed">
                        Melihat laporan pemasukan dan pengeluaran secara detail.
                    </p>
                </div>
            </div>
        </div>
    </section>


    <!-- FOOTER -->
    <footer class="bg-red-700 text-white text-center py-6">
        <p>©2026 SIMOWARJO | Sistem Manajemen Operasional Warjo</p>
    </footer>

    <script>
        const menuBtn = document.getElementById("menuBtn");
        const mobileMenu = document.getElementById("mobileMenu");
            menuBtn.addEventListener("click", () => {
            mobileMenu.classList.toggle("hidden");
            });

        const toggleBtn = document.getElementById("themeToggle");
        const circle = document.getElementById("toggleCircle");
        const icon = document.getElementById("icon");

        toggleBtn.addEventListener("click", () => {
        document.documentElement.classList.toggle("dark");
        if(document.documentElement.classList.contains("dark")){
            circle.classList.add("translate-x-8");
            icon.setAttribute("icon","mdi:moon-waning-crescent");
        }else{
            circle.classList.remove("translate-x-8");
            icon.setAttribute("icon","mdi:white-balance-sunny");
        }
        });
    </script>

    </body>
</html>