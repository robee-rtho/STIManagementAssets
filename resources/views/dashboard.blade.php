<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    @vite('resources/css/app.css')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <link href="https://cdn.datatables.net/1.10.19/css/jquery.dataTables.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/responsive/2.2.3/css/responsive.dataTables.min.css" rel="stylesheet">
</head>

<body class="bg-gray-100">

    <!-- Header -->
    <header class=" navbar p-4 flex justify-between items-center">
        <div class="flex items-center">
            <img src="{{ asset('http://127.0.0.1:8000/images/logo-pln.png') }}" alt="Logo" class="h-18 w-12 mr-2">
            <h1 class="text-xl font-bold ">
                <a href="{{ route('dashboard') }}">Dashboard </a>
            </h1>
            <nav class="flex space-x-4">
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
                <a href="#" class="block px-4 py-2 "
                    onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Logout</a>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                    @csrf
                </form>
            </div>
        </div>
    </header>




    <!-- Main Content -->
    <div class="container mx-auto mt-4 p-4">

        <!-- Menampilkan kotak status aset -->
        <div class="flex space-x-4 mb-6">
            <!-- Kotak Teks Status Aset -->
            <div class="bg-white w-full md:w-1/2 rounded-lg shadow p-4">
                <h2 class="text-lg font-bold mb-2">Status Aset per Kategori</h2>
                <select id="categorySelect" class="form-select">
                    <option value="">Pilih Kategori</option>
                    @foreach($labels as $category)
                    <option value="{{ $category}}">{{ $category}}</option>
                    @endforeach
                </select>

                <div id="statusInfo" class="hidden mt-8">
                    <p><strong>Tersedia         :</strong> <span id="tersedia">         0</span></p>
                    <p><strong>Sedang Dipinjam  :</strong> <span id="sedangDipinjam">   0</span></p>
                    <p><strong>Rusak            :</strong> <span id="rusak">            0</span></p>
                    <p><strong>Sudah Tidak Ada  :</strong> <span id="sudahTidakAda">    0</span></p>
                </div>
            </div>

            <!-- Kotak Chart Pie -->
            <div class="bg-white w-full md:w-1/2 rounded-lg shadow p-4">
                <h2 class="text-lg font-bold mb-2">Status Aset per Kategori (Pie Chart)</h2>
                <canvas id="statusPieChart" style="max-height: 200px;"></canvas>
            </div>
        </div>

        <!-- Chart Jumlah Asset -->
        <div class="bg-white rounded-lg shadow p-4">
            <h2 class="text-lg font-bold mb-2">Jumlah Aset</h2>
            <canvas id="assetChart" style="max-height: 300px;"></canvas>
        </div>

    </div>



    <script>
        const ctx = document.getElementById('assetChart').getContext('2d');

        // Data dari controller
        const labels = @json($labels); // Nama kategori
        const dataValues = @json($dataValues); // Jumlah aset per kategori

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

        document.addEventListener('DOMContentLoaded', function() {
            const statusCounts = @json($statusCounts); // Data status berdasarkan kategori

            const categorySelect = document.getElementById('categorySelect');
            const statusInfo = document.getElementById('statusInfo');

            const tersedia = document.getElementById('tersedia');
            const sedangDipinjam = document.getElementById('sedangDipinjam');
            const rusak = document.getElementById('rusak');
            const sudahTidakAda = document.getElementById('sudahTidakAda');

            const ctx = document.getElementById('statusPieChart').getContext('2d');
            let statusPieChart;

            categorySelect.addEventListener('change', function() {
                const selectedCategory = this.value;

                if (statusCounts[selectedCategory]) {
                    statusInfo.classList.remove('hidden');
                    tersedia.textContent = statusCounts[selectedCategory].tersedia;
                    sedangDipinjam.textContent = statusCounts[selectedCategory].sedang_dipinjam;
                    rusak.textContent = statusCounts[selectedCategory].rusak;
                    sudahTidakAda.textContent = statusCounts[selectedCategory].sudah_tidak_ada;

                    // Update Chart
                    const statusData = [
                        statusCounts[selectedCategory].tersedia,
                        statusCounts[selectedCategory].sedang_dipinjam,
                        statusCounts[selectedCategory].rusak,
                        statusCounts[selectedCategory].sudah_tidak_ada
                    ];

                    if (statusPieChart) {
                        statusPieChart.destroy(); // Hapus chart lama
                    }

                    statusPieChart = new Chart(ctx, {
                        type: 'pie',
                        data: {
                            labels: ['Tersedia', 'Sedang Dipinjam', 'Rusak', 'Sudah Tidak Ada'],
                            datasets: [{
                                data: statusData,
                                backgroundColor: ['#4caf50', '#ff9800', '#f44336', '#9e9e9e'],
                                hoverOffset: 4
                            }]
                        },
                        options: {
                            responsive: true
                        }
                    });
                }
            });
        });
    </script>
</body>

</html>