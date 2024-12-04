<?php

namespace App\Http\Controllers;

use App\Models\Kategori;
use App\Models\Asset;

class DashboardController extends Controller
{
    public function index()
    {
        // Ambil kategori beserta jumlah aset per kategori
        $categories = Kategori::withCount('assets')->get();

        // Siapkan data untuk chart
        $labels = $categories->pluck('name'); // Ambil nama kategori
        $dataValues = $categories->pluck('assets_count'); // Ambil jumlah aset per kategori

        // Siapkan data untuk status berdasarkan kategori
        $statusCounts = [];
        foreach ($categories as $category) {
            $statusCounts[$category->name] = [
                'tersedia' => Asset::where('category', $category->name)->where('status', 'tersedia')->count(),
                'sedang_dipinjam' => Asset::where('category', $category->name)->where('status', 'sedang dipinjam')->count(),
                'rusak' => Asset::where('category', $category->name)->where('status', 'rusak')->count(),
                'sudah_tidak_ada' => Asset::where('category', $category->name)->where('status', 'sudah tidak ada')->count(),
            ];
        }

        // Kirim data ke view
        return view('dashboard', compact('labels', 'dataValues', 'statusCounts'));
    }

    
}
