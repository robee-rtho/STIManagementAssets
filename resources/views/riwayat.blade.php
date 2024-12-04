<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Riwayat Aset</title>
    @vite('resources/css/app.css')

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
                <a href="#" class="text-gray-800 font-bold hover:text-blue-500">Riwayat</a>
            </nav>
        </div>
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
        <h2 class="text-xl font-bold mb-4">Riwayat Penambahan Aset</h2>
        <div class="overflow-x-auto">
            <table class="min-w-full bg-white border border-gray-300">
                <thead>
                    <tr class="bg-gray-200">
                        <th class="py-2 px-4 border border-gray-300">No</th>
                        <th class="py-2 px-4 border border-gray-300">ID Aset</th>
                        <th class="py-2 px-4 border border-gray-300">Nama Barang</th>
                        <th class="py-2 px-4 border border-gray-300">Kategori Aset</th>
                        <th class="py-2 px-4 border border-gray-300">Tanggal</th>
                        <th class="py-2 px-4 border border-gray-300">Nama Admin</th>
                        <th class="py-2 px-4 border border-gray-300">Keterangan</th>
                        <th class="py-2 px-4 border border-gray-300">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($riwayat as $riwayat)
                    <tr>
                        <td class="py-2 px-4 border border-gray-300">{{ $loop->iteration }}</td>
                        <td class="py-2 px-4 border border-gray-300">{{ $riwayat->asset->id_aset }}</td>
                        <td class="py-2 px-4 border border-gray-300">{{ $riwayat->asset->name }}</td>
                        <td class="py-2 px-4 border border-gray-300">{{ $riwayat->asset->category }}</td>
                        <td class="py-2 px-4 border border-gray-300">{{ $riwayat->tanggal }}</td>
                        <td class="py-2 px-4 border border-gray-300">{{ $riwayat->admin }}</td>
                        <td class="py-2 px-4 border border-gray-300">{{ $riwayat->keterangan }}</td>
                        <td class="py-2 px-4 border border-gray-300">
                            <form action="{{ route('riwayat.destroy', $riwayat->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus riwayat ini?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-500 hover:underline">Hapus</button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="mt-4">
            {{ $riwayat->links() }}
        </div>
    </div>

    <script>

    </script>
</body>

</html>