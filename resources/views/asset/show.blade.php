<!-- resources/views/asset/show.blade.php -->
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Aset</title>
    @vite('resources/css/app.css')
</head>

<body>

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
        <h1 class="text-2xl font-bold">Detail Aset: {{ $asset->name }}</h1>
        <p><strong>Kategori:</strong> {{ $category }}</p>

        <div class="mt-4">
            <p><strong>ID Aset:</strong> {{ $asset->id_aset }}</p>
            <p><strong>Nama Barang:</strong> {{ $asset->name }}</p>
            <p><strong>Jenis Aset:</strong> {{ $asset->jenis_aset }}</p>
            <p><strong>Tanggal Penerimaan:</strong> {{ $asset->tanggal_penerimaan }}</p>
            <p><strong>Kategori:</strong> {{ $asset->category }}</p>

            @if($asset->gambar_aset)
            <p><strong>Gambar Aset:</strong></p>
            <img src="{{ asset('storage/' . $asset->gambar_aset) }}" alt="{{ $asset->name }}" class="w-48 h-48">
            @endif
        </div>

        <div class="mt-4 mt-4 flex space-x-2">
            <button class="bg-blue-500 text-white px-4 py-2 rounded-lg text-blue-500 hover:underline"
                onclick="openEditModal('{{ $asset->name }}', '{{ $asset->jenis_aset }}', '{{ $asset->tanggal_penerimaan }}', '{{ $asset->id }}')">
                Edit
            </button>
            <form action="{{ route('asset.destroy', $asset->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus aset ini?')">
                @csrf
                @method('DELETE')
                <button type="submit" class="bg-red-500 text-white px-4 py-2 rounded-lg hover:underline">Hapus Aset</button>
            </form>
        </div>
    </div>

    <!-- PopUp Edit Aset -->
    <div id="editAssetModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 z-50 hidden">
        <div class="flex items-center justify-center h-full">
            <div class="bg-white rounded-lg shadow-lg p-6 w-11/12 md:w-1/3">
                <h2 class="text-xl font-bold mb-4">Edit Aset</h2>

                <form id="editAssetForm" action="{{ route('asset.update', $asset->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="mb-4">
                        <label for="nama_barang" class="block text-gray-700">Nama Barang</label>
                        <input type="text" name="nama_barang" id="nama_barang" class="w-full px-4 py-2 border rounded-lg" required>
                    </div>

                    <div class="mb-4">
                        <label for="jenis_aset" class="block text-gray-700">Jenis Aset</label>
                        <input type="text" name="jenis_aset" id="jenis_aset" class="w-full px-4 py-2 border rounded-lg" required>
                    </div>

                    <div class="mb-4">
                        <label for="tanggal_penerimaan" class="block text-gray-700">Tanggal Penerimaan</label>
                        <input type="date" name="tanggal_penerimaan" id="tanggal_penerimaan" class="w-full px-4 py-2 border rounded-lg" required>
                    </div>

                    <div class="mb-4">
                        <label for="gambar_aset" class="block text-gray-700">Gambar Aset (optional)</label>
                        <input type="file" name="gambar_aset" id="gambar_aset" class="w-full px-4 py-2 border rounded-lg">
                    </div>

                    <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded-lg">Simpan Perubahan</button>
                    <button type="button" class="bg-red-500 text-white px-4 py-2 rounded-lg" onclick="closeModal()">Batal</button>
                </form>
            </div>
        </div>
    </div>
    <!-- PopUp Edit Aset -->

    <!-- Konten Utama -->

    <script>
        function openEditModal(name, jenis_aset, tanggal_penerimaan, id) {
            // Isi form dengan data yang diterima
            document.getElementById('nama_barang').value = name;
            document.getElementById('jenis_aset').value = jenis_aset;
            document.getElementById('tanggal_penerimaan').value = tanggal_penerimaan;

            // Atur action form untuk mengarah ke rute update
            document.getElementById('editAssetForm').action = '/asset/' + id;

            // Tampilkan modal
            document.getElementById('editAssetModal').classList.remove('hidden');
        }



        function closeModal() {
            document.getElementById('editAssetModal').classList.add('hidden');
        }
    </script>
</body>

</html>