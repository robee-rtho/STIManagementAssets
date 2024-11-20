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
        <div class="flex items-center">
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
    <!-- Konten Utama -->
    <div class="container mx-auto mt-4 p-4 px-4">
        <h1 class="text-2xl font-bold">Detail Aset: {{ $asset->name }}</h1>
        <br>
        @if (session('success'))
        <div class="bg-green-500 text-white p-2 mb-4 rounded">
            {{ session('success') }}
        </div>
        @endif

        <div class="flex gap-8 mt-4">
            <!-- Bagian Kiri: Detail Aset -->
            <div class="flex-1 space-y-4 p-6">
                <div>
                    <p class="font-semibold text-lg">ID Aset:</p>
                    <p>{{ $asset->id_aset }}</p>
                </div>
                <div>
                    <p class="font-semibold text-lg">Nama Barang:</p>
                    <p>{{ $asset->name }}</p>
                </div>
                <div>
                    <p class="font-semibold text-lg">Tanggal Penerimaan:</p>
                    <p>{{ $asset->tanggal_penerimaan }}</p>
                </div>
                <p class="font-semibold text-lg">Kategori:</p>
                <p>{{ $asset->category }}</p>

                <div class="flex space-x-2 mt-4">
                    <button class="bg-blue-500 text-white px-4 py-2 rounded-lg hover:underline"
                        onclick="openEditModal('{{ $asset->name }}', '{{ $asset->jenis_aset }}', '{{ $asset->tanggal_penerimaan }}', '{{ $asset->id }}')">
                        Edit
                    </button>

                    <form action="{{ route('asset.destroy', $asset->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus aset ini?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="bg-red-500 text-white px-4 py-2 rounded-lg hover:underline">
                            Hapus Aset
                        </button>
                    </form>
                </div>
            </div>

            <!-- Bagian Kanan: Gambar Aset & QR Code -->
            <div class="flex-1 flex flex-col items-center p-6">
                @if($asset->gambar_aset)
                <div class="text-center mb-4">
                    <p><strong>Gambar Aset:</strong></p>
                    <img src="{{ asset('storage/' . $asset->gambar_aset) }}" alt="{{ $asset->name }}" class="w-48 h-48 object-cover mx-auto">
                </div>
                @endif

                @if(file_exists(public_path('qrcodes/' . $asset->id . '.svg')))
                <div class="text-center mb-4">
                    <p><strong>QR Code untuk Aset:</strong></p>
                    <div class="w-32 h-32 p-4 flex justify-center items-center mx-auto">
                        {!! file_get_contents(public_path('qrcodes/' . $asset->id . '.svg')) !!}
                    </div>
                </div>
                @else
                <p><strong>QR Code belum dihasilkan.</strong></p>
                @endif

                <!-- Tombol untuk Generate QR Code -->
                @if(!$asset->qr_code) <!-- Hanya tampilkan tombol jika QR Code belum ada -->
                <form action="{{ route('generate.qr', $asset->id) }}" method="POST" class="mt-4">
                    @csrf
                    <button type="submit" class="bg-green-500 text-white px-4 py-2 rounded-lg">Generate QR Code</button>
                </form>
                @endif
            </div>
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
                        <input type="text" name="name" id="nama_barang" class="w-full px-4 py-2 border rounded-lg" value="{{ $asset->name }}" required>
                    </div>

                    <div class="mb-4">
                        <label for="tanggal_penerimaan" class="block text-gray-700">Tanggal Penerimaan</label>
                        <input type="date" name="tanggal_penerimaan" id="tanggal_penerimaan" class="w-full px-4 py-2 border rounded-lg" value="{{ $asset->tanggal_penerimaan }}" required>
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

    <script>
        function openEditModal(name, jenis_aset, tanggal_penerimaan, id) {
            // Isi form dengan data yang diterima
            document.getElementById('nama_barang').value = name;
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