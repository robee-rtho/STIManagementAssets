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
        <h2 class="text-2xl font-bold mr-4 mb-2">Kategori Aset</h2>

        <!-- Pesan Sukses atau Kesalahan -->
        @if (session('success'))
        <div class="mb-4 text-green-500">
            {{ session('success') }}
        </div>
        @endif

        @if ($errors->any())
        <div class="mb-4 text-red-500">
            <ul>
                @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif

        <!-- Button untuk membuka modal -->
        <button onclick="openModal()" class="bg-blue-500 text-white px-4 py-2 rounded-lg hover:bg-blue-600 transition">Tambah Kategori</button>

        <!-- PopUp Modal untuk tambah kategori -->
        <div id="addCategoryModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 z-50 hidden">
            <div class="flex items-center justify-center h-full">
                <div class="bg-white rounded-lg shadow-lg p-6 w-11/12 md:w-1/3">
                    <h2 class="text-xl font-bold mb-4">Tambah Kategori</h2>

                    <form method="POST" action="{{ route('kategori.store') }}" enctype="multipart/form-data">
                        @csrf
                        <div class="mb-4">
                            <label for="name" class="block text-gray-700">Nama Kategori</label>
                            <input type="text" name="name" id="name" placeholder="Nama Kategori" required class="w-full px-4 py-2 border rounded-lg">
                        </div>

                        <div class="mb-4">
                            <label for="icon" class="block text-gray-700">Ikon Kategori (optional)</label>
                            <input type="file" name="icon" id="icon" accept="image/*" class="w-full px-4 py-2 border rounded-lg">
                        </div>

                        <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded-lg">Tambah Kategori</button>
                        <button type="button" class="bg-red-500 text-white px-4 py-2 rounded-lg" onclick="closeModal()">Batal</button>
                    </form>
                </div>
            </div>
        </div>

        <!-- Daftar Kategori -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4 mt-4">
            @foreach ($categories as $category)
            <div class="bg-white rounded-lg shadow p-4 text-center hover:shadow-lg transition relative">
                <!-- Menambahkan elemen untuk menampilkan ikon -->
                <img src="{{ asset('storage/' . $category->icon) }}" alt="{{ $category->name }} Icon" class="h-16 w-16 mx-auto mb-2">

                <h3 class="text-lg font-bold">
                    <a href="{{ route('category.show', ['category' => $category->name]) }}" class="text-blue-500 hover:underline">{{ $category->name }}</a>
                </h3>

                <form method="POST" action="{{ route('kategori.destroy', $category->name) }}" class="absolute top-2 right-2">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="text-red-500 hover:text-red-600">Hapus</button>
                </form>
            </div>
            @endforeach
        </div>
    </div>

    <!-- Script untuk membuka dan menutup modal -->
    <script>
        // Menampilkan modal
        function openModal() {
            document.getElementById('addCategoryModal').classList.remove('hidden');
        }

        // Menutup modal
        function closeModal() {
            document.getElementById('addCategoryModal').classList.add('hidden');
        }
    </script>

</body>

</html>