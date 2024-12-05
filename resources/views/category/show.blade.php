<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Aset {{ ucfirst($category) }}</title>
    @vite('resources/css/app.css')
    <link href="https://cdn.datatables.net/1.10.19/css/jquery.dataTables.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/responsive/2.2.3/css/responsive.dataTables.min.css" rel="stylesheet">
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

        <div class="flex gap-8">
            <!-- Tombol Tambah Aset -->
            <div class="mb-4 flex-1">
                <button class="bg-blue-500 text-white px-4 py-2 rounded-lg hover:bg-blue-600" onclick="openModal()">Tambah Aset</button>
            </div>
            <!-- Pencarian -->
            <div class="mb-4 flex">
                <input type="text" placeholder="Cari aset..." class="px-4 py-2 border rounded-lg w-full" id="search">
            </div>
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

            <div id='recipients' class="p-8 mt-6 lg:mt-0 rounded shadow bg-white">


                <table id="example" class="stripe hover" style="width:100%; padding-top: 1em;  padding-bottom: 1em;">
                    <thead>
                        <tr>
                            <th data-priority="1">ID Barang</th>
                            <th data-priority="2">Nama Barang</th>
                            <th data-priority="3">Tanggal</th>
                            <th class="py-2 px-4 border relative">
                                <div data-priority="4" class="inline-block">
                                    <button onclick="toggleDropdown()" class="font-semibold focus:outline-none">
                                        Status <span>&#9662;</span>
                                    </button>
                                    <!-- Dropdown -->
                                    <div id="dropdown-status" class="absolute right-0 mt-2 w-48 bg-white border rounded shadow-lg hidden">
                                        <ul>
                                            <li>
                                                <a href="{{ route('category.show', ['category' => $category]) }}"
                                                    class="block px-4 py-2 text-gray-700 hover:bg-gray-200">
                                                    Semua Status
                                                </a>
                                            </li>
                                            <li>
                                                <a href="{{ route('category.show', ['category' => $category, 'status' => 'Tersedia']) }}"
                                                    class="block px-4 py-2 text-gray-700 hover:bg-gray-200">
                                                    Tersedia
                                                </a>
                                            </li>
                                            <li>
                                                <a href="{{ route('category.show', ['category' => $category, 'status' => 'Sedang Dipinjam']) }}"
                                                    class="block px-4 py-2 text-gray-700 hover:bg-gray-200">
                                                    Sedang Dipinjam
                                                </a>
                                            </li>
                                            <li>
                                                <a href="{{ route('category.show', ['category' => $category, 'status' => 'Rusak']) }}"
                                                    class="block px-4 py-2 text-gray-700 hover:bg-gray-200">
                                                    Rusak
                                                </a>
                                            </li>
                                            <li>
                                                <a href="{{ route('category.show', ['category' => $category, 'status' => 'Sudah Tidak Ada']) }}"
                                                    class="block px-4 py-2 text-gray-700 hover:bg-gray-200">
                                                    Sudah Tidak Ada
                                                </a>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </th>
                            <th data-priority="5">Aksi</th>



                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($assets as $asset)
                        <tr>
                            <td data-priority="">{{ $asset->id_aset }}</td>
                            <td data-priority="">{{ $asset->name }}</td>
                            <td data-priority="">{{ $asset->created_at }}</td>
                            <td data-priority="">
                                @php
                                $color = match($asset->status) {
                                'Tersedia' => 'text-green-500',
                                'Sedang Dipinjam' => 'text-orange-500',
                                'Rusak' => 'text-red-500',
                                'Sudah Tidak Ada' => 'text-gray-500',
                                default => 'text-black'
                                };
                                @endphp
                                <span class="{{ $color }}">{{ $asset->status }}</span>
                            </td>
                            <td data-priority=""">
                                <a href=" {{ route('asset.show', $asset->id) }}" class="text-blue-500 hover:underline">Edit</a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>


                </table>


            </div>

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

        function toggleDropdown() {
            const dropdown = document.getElementById('dropdown-status');
            dropdown.classList.toggle('hidden');
        }

        // Menutup dropdown saat klik di luar
        window.addEventListener('click', function(e) {
            const dropdown = document.getElementById('dropdown-status');
            const button = dropdown.previousElementSibling;
            if (!button.contains(e.target) && !dropdown.contains(e.target)) {
                dropdown.classList.add('hidden');
            }
        });

        function openModal() {
            document.getElementById('modal').classList.remove('hidden');
        }

        function closeModal() {
            document.getElementById('modal').classList.add('hidden');
        }
    </script>
    <script type="text/javascript" src="https://code.jquery.com/jquery-3.4.1.min.js"></script>

    <!--Datatables -->
    <script src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.2.3/js/dataTables.responsive.min.js"></script>
    <script>
        $(document).ready(function() {

            var table = $('#example').DataTable({
                    responsive: true
                })
                .columns.adjust()
                .responsive.recalc();
        });
    </script>
</body>

</html>