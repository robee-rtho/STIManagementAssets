<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kategori Aset</title>
    @vite('resources/css/app.css') <!-- Pastikan ini ada -->
</head>

<body class="bg-gray-100">

    <!-- Header -->
    <header class="bg-custom-color-main shadow p-4 flex justify-between items-center">
        <div class="flex items-center">
            <img src="{{ asset('images/logo-pln.png') }}" alt="Logo" class="h-18 w-12 mr-2">
            <h1 class="text-xl font-bold mr-4">
                <a href="{{ route('dashboard') }}">Dashboard </a>
            </h1>
            <nav class="flex space-x-4">
                <a href="{{ route('kategori') }}" class="text-gray-800 font-bold hover:text-blue-500">Kategori Aset</a>
                <a href="{{ route('riwayat') }}" class="text-gray-800 font-bold hover:text-blue-500">Riwayat</a>
            </nav>
        </div>
        <div class="flex items-center relative group">
            <span class="mr-4 text-gray-800 font-bold">Hello, {{ Auth::user()->name }}</span>
            <button class="text-gray-800 font-bold focus:outline-none">Menu</button>
            <!-- Dropdown Menu -->
            <div class="absolute right-0 mt-2 w-48 bg-white rounded-md shadow-lg z-10 hidden group-hover:block">
                <a href="#" class="block px-4 py-2 text-gray-800 hover:bg-gray-200">Ubah Data</a>
                <a href="#" class="block px-4 py-2 text-gray-800 hover:bg-gray-200"
                    onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Logout</a>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                    @csrf
                </form>
            </div>
        </div>
    </header>

    <!-- Main Content -->
    <div class="container mx-auto mt-4 p-4">
        <h2 class="text-2xl font-bold mr-4 mb-2">Kategori Asset</h2>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
            <!-- Kategori Aset 1 -->
            <a href="{{ route('category.show', ['category' => 'kategori1']) }}" class="bg-white rounded-lg shadow p-4 text-center hover:shadow-lg transition">
                <img src="{{ asset('images/logo-kategori1.png') }}" alt="Kategori 1" class="h-24 w-24 mx-auto mb-2">
                <h3 class="text-lg font-bold">Kategori 1</h3>
            </a>

            <!-- Kategori Aset 2 -->
            <a href="{{ route('category.show', ['category' => 'kategori2']) }}" class="bg-white rounded-lg shadow p-4 text-center hover:shadow-lg transition">
                <img src="{{ asset('images/logo-kategori2.png') }}" alt="Kategori 2" class="h-24 w-24 mx-auto mb-2">
                <h3 class="text-lg font-bold">Kategori 2</h3>
            </a>

            <!-- Kategori Aset 3 -->
            <a href="{{ route('category.show', ['category' => 'kategori3']) }}" class="bg-white rounded-lg shadow p-4 text-center hover:shadow-lg transition">
                <img src="{{ asset('images/logo-kategori3.png') }}" alt="Kategori 3" class="h-24 w-24 mx-auto mb-2">
                <h3 class="text-lg font-bold">Kategori 3</h3>
            </a>

            <!-- Kategori Aset 4 -->
            <a href="{{ route('category.show', ['category' => 'kategori4']) }}" class="bg-white rounded-lg shadow p-4 text-center hover:shadow-lg transition">
                <img src="{{ asset('images/logo-kategori4.png') }}" alt="Kategori 4" class="h-24 w-24 mx-auto mb-2">
                <h3 class="text-lg font-bold">Kategori 4</h3>
            </a>

            <!-- Kategori Aset 5 -->
            <a href="{{ route('category.show', ['category' => 'kategori5']) }}" class="bg-white rounded-lg shadow p-4 text-center hover:shadow-lg transition">
                <img src="{{ asset('images/logo-kategori5.png') }}" alt="Kategori 5" class="h-24 w-24 mx-auto mb-2">
                <h3 class="text-lg font-bold">Kategori 5</h3>
            </a>

            <!-- Kategori Aset 6 -->
            <a href="{{ route('category.show', ['category' => 'kategori6']) }}" class="bg-white rounded-lg shadow p-4 text-center hover:shadow-lg transition">
                <img src="{{ asset('images/logo-kategori6.png') }}" alt="Kategori 6" class="h-24 w-24 mx-auto mb-2">
                <h3 class="text-lg font-bold">Kategori 6</h3>
            </a>
        </div>
    </div>

</body>

</html>