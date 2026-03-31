<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Dashboard Karyawan</title>

    <script src="https://cdn.tailwindcss.com"></script>

</head>
<body class="bg-gray-100">
    <!-- Sidebar -->
    @include('karyawan.sidebarempl')

    <!-- Content -->
    <div class="ml-64 p-8">
        @yield('content')
    </div>

</body>
</html>