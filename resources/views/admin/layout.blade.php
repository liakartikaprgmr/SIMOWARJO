<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Dashboard Admin</title>

    <script src="https://cdn.tailwindcss.com"></script>

</head>

<body class="bg-gray-100">

    <!-- Sidebar -->
    @include('admin.sidebar')


<div id="contentWrapper" class="ml-0 md:ml-64 transition-all duration-300 p-8 max-w-screen-xl mx-auto">
    @yield('content')
</div>

    @stack('scripts')

</body>

</html>