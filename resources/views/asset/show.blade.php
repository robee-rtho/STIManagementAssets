<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Aset</title>
    @vite('resources/css/app.css')
    <link href="https://cdn.datatables.net/1.10.19/css/jquery.dataTables.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/responsive/2.2.3/css/responsive.dataTables.min.css" rel="stylesheet">
</head>

<body>

    <!-- Header -->
    <header class=" navbar p-4 flex justify-between items-center">
        <div class="flex items-center ">
            <img src="{{ asset('images/logo-pln.png') }}" alt="Logo" class="h-18 w-12 mr-2">
            <h1 class="text-xl font-bold mr-4">Aset {{ ucfirst($category) }}</h1>

            <nav class="flex space-x-4">
                <a href="{{ route('dashboard') }}" class=" font-bold ">Dashboard</a>
                <a href="{{ route('kategori') }}" class=" font-bold ">Kategori Aset</a>
                <a href="{{ route('riwayat') }}" class=" font-bold ">Riwayat</a>
            </nav>
        </div>
        <div class="flex items-center relative group">
            <span class="mr-4  font-bold">Hello, {{ Auth::user()->name }}</span>
            <button class=" font-bold focus:outline-none">
                Menu
            </button>
            <!-- Dropdown Menu -->
            <div class="absolute right-0 mt-2 w-48 bg-black rounded-md shadow-lg z-10 hidden group-hover:block">
                <a href="#" class="block px-4 py-2  "
                    onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Logout</a>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                    @csrf
                </form>
            </div>
        </div>
    </header>
    <!-- Header -->


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

                <div class="mt-4">
                    <label for="status" class="block font-bold text-gray-700">Status Aset:</label>
                    <form action="{{ route('asset.updateStatus', $asset->id) }}" method="POST" class="inline-block">
                        @csrf
                        @method('PUT')
                        <select name="status" id="status" class="border rounded-lg px-4 py-2" onchange="this.form.submit()">
                            <option value="Tersedia" {{ $asset->status == 'Tersedia' ? 'selected' : '' }}>Tersedia</option>
                            <option value="Sedang Dipinjam" {{ $asset->status == 'Sedang Dipinjam' ? 'selected' : '' }}>Sedang Dipinjam</option>
                            <option value="Rusak" {{ $asset->status == 'Rusak' ? 'selected' : '' }}>Rusak</option>
                            <option value="Sudah Tidak Ada" {{ $asset->status == 'Sudah Tidak Ada' ? 'selected' : '' }}>Sudah Tidak Ada</option>
                        </select>
                    </form>
                </div>


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

            <!-- Gambar Aset & QR Code -->
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


            </div>
        </div>

<!-- Tabel Daftar Aset -->
<h3 class="text-lg font-bold mt-6">Riwayat Perbaikan:</h3>
<div class="overflow-x-auto">

<div id='recipients' class="p-8 mt-1 lg:mt-0 rounded shadow bg-white">


    <table id="example" class="stripe hover" style="width:100%;  padding-bottom: 1em;">
        <thead>
            <tr>
                <th data-priority="1">Tanggal Rusak</th>
                <th data-priority="2">Tanggal Perbaikan</th>
                <th data-priority="3">Keterangan</th>

            </tr>
        </thead>
        <tbody>
        @foreach ($asset->riwayatPerbaikans as $riwayat)
            <tr>
                <td data-priority="">{{ $riwayat->tanggal_rusak ?? '-'  }}</td>
                <td data-priority="">{{ $riwayat->tanggal_perbaikan ?? '-' }}</td>
                <td data-priority="">{{ $riwayat->keterangan}}</td>
            </tr>
            @endforeach
        </tbody>
    </table>


</div>

</div>
<!-- Tabel Daftar Aset --> 
        <button onclick="document.getElementById('modal-riwayat').classList.remove('hidden')"
            class="bg-blue-500 text-white px-4 py-2 rounded">Tambah Riwayat Perbaikan</button>

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

    <!-- PopUp Riwayat Aset -->
    <div id="modal-riwayat" class="hidden fixed top-0 left-0 w-full h-full flex items-center justify-center bg-black bg-opacity-40 z-50">
        <div class="bg-white p-6 rounded shadow-md w-96">
            <form action="{{ route('riwayat-perbaikan.store') }}" method="POST">
                @csrf
                <input type="hidden" name="asset_id" value="{{ $asset->id }}">

                <div class="mb-4">

                    <label for="name" class="block text-gray-700">Keterangan (maksimal 255 karakter)</label>
                    <input type="text" name="keterangan" id="name" maxlength="255" class="w-full px-4 py-2 border rounded-lg" placeholder="Masukkan Keterangan" required>
                    @error('name')
                    <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-4">
                    <label class="block">Tanggal Rusak</label>
                    <input type="date" name="tanggal_rusak" class="w-full border rounded px-3 py-2">
                </div>

                <div class="mb-4">
                    <label class="block">Tanggal Perbaikan</label>
                    <input type="date" name="tanggal_perbaikan" class="w-full border rounded px-3 py-2">
                </div>

                <div class="flex justify-between">
                    <button type="submit" class="bg-green-500 text-white px-4 py-2 rounded">Simpan</button>
                    <button type="button" onclick="document.getElementById('modal-riwayat').classList.add('hidden')"
                        class="bg-red-500 text-white px-4 py-2 rounded">Batal</button>
                </div>
            </form>
        </div>
    </div>
    <!-- PopUp Riwayat Aset -->

    <script>
        function openEditModal(name, jenis_aset, id) {
            // Isi form dengan data yang diterima
            document.getElementById('nama_barang').value = name;

            // Atur action form untuk mengarah ke rute update
            document.getElementById('editAssetForm').action = '/asset/' + id;

            // Tampilkan modal
            document.getElementById('editAssetModal').classList.remove('hidden');
        }

        function closeModal() {
            document.getElementById('editAssetModal').classList.add('hidden');
        }
    </script>
     <script type="text/javascript" src="https://code.jquery.com/jquery-3.4.1.min.js"></script>


<script src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.2.3/js/dataTables.responsive.min.js"></script>
<script>
    $(document).ready(function() {
        var table = $('#example').DataTable({
            responsive: true,
            columnDefs: [{
                    orderable: false,
                    targets: 3
                } // Menonaktifkan sort di kolom ke-4 
            ]
        }).columns.adjust().responsive.recalc();
    });
</script>
</body>

</html>