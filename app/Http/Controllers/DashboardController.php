<?php

namespace App\Http\Controllers;

use App\Models\Kategori;
use App\Models\Asset;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        // Ambil kategori beserta jumlah aset per kategori
        $categories = Kategori::withCount('assets')->get(); // Asumsi 'assets' adalah relasi di model Kategori

        // Siapkan data untuk chart
        $labels = $categories->pluck('name'); // Ambil nama kategori
        $dataValues = $categories->pluck('assets_count'); // Ambil jumlah aset per kategori

        // Kirim data ke view
        return view('dashboard', compact('labels', 'dataValues'));
    }
}
