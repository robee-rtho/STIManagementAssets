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
        <!-- @foreach ($assets as $asset)
        <tr>
            <td class="py-2 px-4 border">{{ $asset->id_aset }}</td>
            <td class="py-2 px-4 border">{{ $asset->name }}</td>
            <td class="py-2 px-4 border">{{ $asset->created_at }}</td>
            <td class="py-2 px-4 border">
                <a href="{{ route('asset.show', $asset['id']) }}" class="text-blue-500 hover:underline">Edit</a>
            </td>
        </tr>
        @endforeach
        @endif -->

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

            <!-- Pesan Error -->
            <div id="error-message" class="text-red-500 text-center mb-4 hidden">Data tidak boleh kosong</div>

            <form id="asset-form" action="{{ route('asset.store', $category) }}" method="POST" enctype="multipart/form-data" onsubmit="return validateForm()">
                @csrf
                <input type="hidden" name="category" value="{{ $category }}">

                <!-- Nama Barang -->
                <div class="mb-4">
                    <label for="name" class="block text-gray-700">Nama Barang (maksimal 255 karakter)</label>
                    <input type="text" name="name" id="name" maxlength="255" class="w-full px-4 py-2 border rounded-lg" placeholder="Masukkan nama barang">
                    @error('name')
                    <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Gambar Aset -->
                <div class="mb-4">
                    <label for="gambar_aset" class="block text-gray-700">Gambar Aset (JPEG/JPG/PNG, maksimal 2MB)</label>
                    <input type="file" name="gambar_aset" id="gambar_aset" class="w-full px-4 py-2 border rounded-lg">
                    @error('gambar_aset')
                    <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Tombol Simpan dan Batal -->
                <div class="flex justify-between">
                    <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded-lg">Simpan Aset</button>
                    <button type="button" onclick="closeModal()" class="bg-gray-300 text-gray-700 px-4 py-2 rounded-lg">Batal</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        function validateForm() {
            // Mengambil nilai dari input nama barang dan gambar
            const name = document.getElementById('name').value.trim();
            const imageInput = document.getElementById('gambar_aset');
            const errorMessage = document.getElementById('error-message');

            // Validasi: Pastikan nama barang tidak kosong
            if (!name) {
                errorMessage.textContent = "Nama barang tidak boleh kosong.";
                errorMessage.classList.remove('hidden');
                return false;
            }

            // Validasi ukuran file dan format gambar jika ada gambar yang diunggah
            if (imageInput.files.length > 0) {
                const file = imageInput.files[0];
                const fileSizeMB = file.size / 1024 / 1024; // Convert ukuran ke MB
                const fileExtension = file.name.split('.').pop().toLowerCase();

                // Cek ukuran file
                if (fileSizeMB > 2) {
                    errorMessage.textContent = "Ukuran gambar tidak boleh lebih dari 2MB.";
                    errorMessage.classList.remove('hidden');
                    return false;
                }

                // Cek format file
                if (fileExtension !== 'jpg' && fileExtension !== 'jpeg' && fileExtension !== 'png') {
                    errorMessage.textContent = "Format gambar harus JPG atau JPEG atau PNG.";
                    errorMessage.classList.remove('hidden');
                    return false;
                }
            } else {
                errorMessage.textContent = "Gambar aset tidak boleh kosong.";
                errorMessage.classList.remove('hidden');
                return false;
            }

            // Jika semua validasi lolos, sembunyikan pesan error dan lanjutkan submit
            errorMessage.classList.add('hidden');
            return true;
        }

        function openModal() {
            document.getElementById('modal').classList.remove('hidden');
        }

        function closeModal() {
            document.getElementById('modal').classList.add('hidden');
        }
    </script>
</body>

</html>