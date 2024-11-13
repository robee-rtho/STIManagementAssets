<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Aset {{ ucfirst($category) }}</title>
    @vite('resources/css/app.css')
</head>

<body class="bg-gray-100">
    <!-- Header -->
    <header class="bg-custom-color-main shadow p-4 flex justify-between items-center">
        <div class="flex items-center ">
            <img src="{{ asset('images/logo-pln.png') }}" alt="Logo" class="h-18 w-12 mr-2">
            <h1 class="text-xl font-bold mr-4">Aset {{ ucfirst($category) }}</h1>
            <nav class="flex space-x-4">
                <a href="{{ route('kategori') }}" class="text-gray-800 font-bold hover:text-blue-500">Kategori</a>
            </nav>
        </div>
        <div class="flex items-center">
            <span class="mr-4 text-gray-800 font-bold">Hello, {{ Auth::user()->name }}</span>
            <button class="text-gray-800 font-bold focus:outline-none">Menu</button>
        </div>
    </header>

    <!-- Konten Utama -->
    <div class="container mx-auto mt-4 p-4">
        <h2 class="text-xl font-bold mb-4">Daftar Aset {{ ucfirst($category) }}</h2>

        <!-- Pencarian -->
        <div class="mb-4">
            <input type="text" placeholder="Cari aset..." class="px-4 py-2 border rounded-lg w-full" id="search">
        </div>

        <!-- Tombol Tambah Aset -->
        <div class="mb-4">
            <button class="bg-blue-500 text-white px-4 py-2 rounded-lg hover:bg-blue-600" onclick="openModal()">Tambah Aset</button>
        </div>
        @if($assets->isEmpty())
    <p>Tidak ada aset yang ditemukan.</p>
@else
    @foreach ($assets as $asset)
        <tr>
            <td class="py-2 px-4 border">{{ $asset->id_aset }}</td>
            <td class="py-2 px-4 border">{{ $asset->name }}</td>
            <td class="py-2 px-4 border">{{ $asset->created_at }}</td>
            <td class="py-2 px-4 border">
                <a href="{{ route('asset.show', $asset['id']) }}" class="text-blue-500 hover:underline">Edit</a>
            </td>
        </tr>
    @endforeach
@endif
        <!-- Tabel Daftar Aset -->
        <div class="overflow-x-auto">
            <table class="min-w-full bg-white border">
                <thead>
                    <tr class="bg-gray-200">
                        <th class="py-2 px-4 border">ID Barang</th>
                        <th class="py-2 px-4 border">Nama Barang</th>
                        <th class="py-2 px-4 border">Tanggal</th>
                        <th class="py-2 px-4 border">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($assets as $asset)
                    <tr>
                        <td class="py-2 px-4 border">{{ $asset->id_aset }}</td>
                        <td class="py-2 px-4 border">{{ $asset->name }}</td>
                        <td class="py-2 px-4 border">{{ $asset->created_at }}</td>
                        <td class="py-2 px-4 border">
                            <a href="{{ route('asset.show', $asset['id']) }}" class="text-blue-500 hover:underline ">Edit</a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <!-- Modal untuk Tambah Aset -->
    <div id="modal" class="fixed inset-0 bg-gray-600 bg-opacity-50 flex justify-center items-center hidden">
        <div class="bg-white p-6 rounded-lg shadow-lg w-full max-w-md">
            <h2 class="text-xl font-bold mb-4">Tambah Aset Baru</h2>
            <form action="{{ route('asset.store', $category) }}" method="POST" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="category" value="{{ $category }}">

                <!-- Nama Barang -->
                <div class="mb-4">
                    <label for="name" class="block text-gray-700">Nama Barang</label>
                    <input type="text" name="name" id="name" required class="w-full px-4 py-2 border rounded-lg">
                </div>

                <!-- Jenis Aset -->
                <div class="mb-4">
                    <label for="jenis_aset" class="block text-gray-700">Jenis Aset</label>
                    <input type="text" name="jenis_aset" id="jenis_aset" required class="w-full px-4 py-2 border rounded-lg">
                </div>


                <!-- Gambar Aset -->
                <div class="mb-4">
                    <label for="gambar_aset" class="block text-gray-700">Gambar Aset</label>
                    <input type="file" name="gambar_aset" id="gambar_aset" class="w-full px-4 py-2 border rounded-lg">
                </div>
                <div class="flex justify-between">
                <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded-lg">Simpan Aset</button>
                <button type="button" onclick="closeModal()" class="bg-gray-300 text-gray-700 px-4 py-2 rounded-lg">Batal</button>
            </div>
            </form>
        </div>
    </div>

    <script>
        function openModal() {
            document.getElementById('modal').classList.remove('hidden');
        }

        function closeModal() {
            document.getElementById('modal').classList.add('hidden');
        }
    </script>
</body>

</html>