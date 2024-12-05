<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Riwayat Aset</title>
    @vite('resources/css/app.css')
    <link href="https://cdn.datatables.net/1.10.19/css/jquery.dataTables.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/responsive/2.2.3/css/responsive.dataTables.min.css" rel="stylesheet">


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
        <div id='recipients' class="p-8 mt-6 lg:mt-0 rounded shadow bg-white">


            <table id="example" class="stripe hover" style="width:100%; padding-top: 1em;  padding-bottom: 1em;">
                <thead>
                    <tr>
                        <th data-priority="1">No</th>
                        <th data-priority="2">ID Aset</th>
                        <th data-priority="3">Nama Barang</th>
                        <th data-priority="4">Kategori Aset</th>
                        <th data-priority="5">Tanggal</th>
                        <th data-priority="6">Nama Admin</th>
                        <th data-priority="7">Keterangan</th>
                        <th data-priority="8">Aksi</th>


                    </tr>
                </thead>
                <tbody>
                    @foreach ($riwayat as $riwayat)
                    <tr>
                        <td data-priority="1">{{ $loop->iteration }}</td>
                        <td data-priority="2">{{ $riwayat->asset->id_aset }}</td>
                        <td data-priority="3">{{ $riwayat->asset->name }}</td>
                        <td data-priority="4">{{ $riwayat->asset->category }}</td>
                        <td data-priority="5">{{ $riwayat->tanggal }}</td>
                        <td data-priority="6">{{ $riwayat->admin }}</td>
                        <td data-priority="7">{{ $riwayat->keterangan }}</td>
                        <td data-priority="8">
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

    </div>

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