<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pengaduan Masyarakat</title>
    @include('layout.cdn')
    <style>
        /* Pastikan tinggi header tetap konsisten */
        header {
            height: 64px;
            /* Sama dengan py-4 (16px x 4 = 64px) */
        }

        main {
            padding-top: 64px;
            /* Ruang untuk menghindari tabrakan dengan header */
        }
    </style>
</head>

<body class="bg-gray-100 min-h-screen">
    <!-- Header -->
    <header
        class="bg-blue-600 text-white px-6 flex justify-between items-center fixed top-0 left-0 w-full z-50 shadow-lg">
        <h1 class="text-xl font-bold">Pengaduan Masyarakat</h1>

        <!-- Navbar -->
        <nav class="space-x-6">
            @guest
            <a href="{{ route('dashboard') }}" class="hover:text-blue-300">Home</a>
            @endguest
            @auth
            <a href="{{ route('report') }}" class="hover:text-blue-300">Home</a>
                <a href="{{ route('report_create') }}" class="hover:text-blue-300">Pengaduan</a>
                <a href="{{ route('report_me') }}" class="hover:text-blue-300">Monitoring</a>
            </nav>


            <a href="{{ route('logout') }}" class="text-white bg-red-500 hover:bg-red-600 px-4 py-2 rounded">Logout</a>
        @endauth
    </header>

    <!-- Content -->
    <main class="container ">
        @yield('content')
    </main>
</body>

</html>
