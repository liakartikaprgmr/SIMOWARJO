<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Admin</title>

    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100">

    <!-- Sidebar + Navbar -->
    @include('admin.sidebar')

    <!-- Content -->
    <main id="contentWrapper" class="pt-10 md:pt-10 ml-0 md:ml-64 p-4 md:p-8 transition-all duration-300">

        @yield('content')

    </main>

    @stack('scripts')

</body>

</html>