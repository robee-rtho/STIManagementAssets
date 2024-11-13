<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    @vite('resources/css/app.css')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>

<body class="bg-gray-100">

    <!-- Header -->
    <header class="bg-custom-color-main shadow p-4 flex justify-between items-center">
        <div class="flex items-center">
            <img src="{{ asset('http://127.0.0.1:8000/images/logo-pln.png') }}" alt="Logo" class="h-18 w-12 mr-2">
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
            <button class="text-gray-800 font-bold focus:outline-none">
                Menu
            </button>
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
        <!-- Chart Jumlah Asset -->
        <div class="bg-white rounded-lg shadow p-4">
            <h2 class="text-lg font-bold mb-2">Jumlah Aset</h2>
            <canvas id="assetChart"></canvas>
        </div>

    </div>



    <script>
        const ctx = document.getElementById('assetChart').getContext('2d');

        // Data dari controller
        
        const assetChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: labels,
                datasets: [{
                    label: 'Jumlah Aset',
                    data: dataValues,
                    backgroundColor: 'rgba(12, 97, 145, 0.5)',
                    borderColor: 'rgba(12, 97, 145, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });

        
    </script>
</body>

</html>