<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
    <title>SIMOWARJO Login</title>

    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-200 min-h-screen flex items-center justify-center p-4">
    <div class="w-full max-w-6xl bg-white rounded-2xl overflow-hidden shadow-xl grid md:grid-cols-2">

        <!-- LEFT IMAGE (Hidden Mobile) -->
        <div class="relative hidden md:flex justify-center items-center bg-gray-50">
            <div class="absolute w-80 h-80 bg-red-500 rounded-full blur-[120px] opacity-30"></div>
            <img src="{{ asset('assets/logo.png') }}" class="w-3/4 object-contain drop-shadow-lg contrast-125">
            <div class="absolute top-0 left-0 w-full h-full">
                <div class="absolute top-0 left-0 w-full h-full bg-white opacity-30 clip1"></div>
                <div class="absolute top-0 left-0 w-full h-full bg-white opacity-30 clip2"></div>
            </div>
        </div>

        <!-- RIGHT LOGIN -->
        <div class="flex flex-col justify-center px-6 py-10 md:px-16">
            <h1 class="text-red-700 font-bold text-lg mb-6">
                SIMOWARJO
            </h1>
            <h2 class="text-3xl md:text-5xl font-bold text-red-700 mb-10">
                Welcome
            </h2>

            <form action="/login" method="POST">
            @csrf

            @if ($errors->any())
                <div class="bg-red-500 text-white p-3 rounded mb-5">
                    <ul class="text-sm">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

                <!-- USERNAME -->
                <label class="flex items-center gap-2 font-semibold mb-2">
                    Email
                </label>
                <input type="email" name="email" class="w-full border-2 border-red-700 rounded-xl p-3 mb-6 outline-none focus:ring-2 focus:ring-red-300">
                <!-- PASSWORD -->
                <div class="relative w-full mb-10">
                    <label class="font-semibold mb-2 block">
                        Password
                    </label>
                    <input type="password" id="password" name="password" class="w-full border-2 border-red-700 rounded-xl p-3 pr-12 outline-none focus:ring-2 focus:ring-red-300">

                    <!-- ICON -->
                    <button type="button" onclick="togglePassword()" class="absolute right-3 top-[42px] text-gray-500 hover:text-red-700">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
                        <path fill="currentColor" d="M12 6.5a9.77 9.77 0 0 1 8.82 5.5c-1.65 3.37-5.02 5.5-8.82 5.5S4.83 15.37 3.18 12A9.77 9.77 0 0 1 12 6.5m0-2C7 4.5 2.73 7.61 1 12c1.73 4.39 6 7.5 11 7.5s9.27-3.11 11-7.5c-1.73-4.39-6-7.5-11-7.5m0 5a2.5 2.5 0 0 1 0 5a2.5 2.5 0 0 1 0-5m0-2c-2.48 0-4.5 2.02-4.5 4.5s2.02 4.5 4.5 4.5s4.5-2.02 4.5-4.5s-2.02-4.5-4.5-4.5"/></svg>
                    </button>
                </div>

                <!-- BUTTON -->
                <button type="submit" class="block w-full text-center bg-red-700 text-white py-4 rounded-xl font-semibold hover:bg-red-800 transition">
                    Login
                </button>

                <!-- Register Link -->
                <p class="text-center text-sm text-gray-500 mt-4">
                    Belum punya akun?
                    <a href="/register" class="text-green-600 font-semibold">Register</a>
                </p>

            </form>
        </div>
    </div>

    <style>
        .clip1{
        clip-path: polygon(0 20%,100% 0,100% 15%,0 35%);
        }

        .clip2{
        clip-path: polygon(0 65%,100% 45%,100% 60%,0 80%);
        }
        </style>

        <script>
        function togglePassword() {
        const password = document.getElementById("password");

        if (password.type === "password") {
        password.type = "text";
        } else {
        password.type = "password";
        }
        }
    </script>
</body>
</html>