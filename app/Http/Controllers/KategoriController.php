<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\riwayat;
use App\Models\Asset;

class KategoriController extends Controller
{
    public function show($category)
    {
        // Ambil aset berdasarkan kategori dari database menggunakan model Asset
        $assets = Asset::where('category', $category)->get(); // Mengambil data dari database

        return view('category.show', compact('assets', 'category'));
    }

    // Menyimpan data aset baru
    public function store(Request $request, $category)
    {
        // Validasi input
        $request->validate([
            'name' => 'required|string|max:255',
            'gambar_aset' => 'nullable|image|mimes:jpg,png,jpeg|max:2048', // Maks 2MB dan format JPG/JPEG
        ]);

        // Dapatkan kategori berdasarkan parameter yang diklik
        $kategori = strtoupper($category);

        // Pembuatan ID Aset seperti dijelaskan sebelumnya...
        $latestAsset = Asset::where('id_aset', 'like', "{$kategori}-%")->latest('id_aset')->first();
        $newNumber = $latestAsset ? intval(substr($latestAsset->id_aset, strlen($kategori) + 1)) + 1 : 1;
        $newIdAset = $kategori . '-' . str_pad($newNumber, 3, '0', STR_PAD_LEFT);

        // Simpan data aset
        $asset = new Asset();
        $asset->id_aset = $newIdAset;
        $asset->name = $request->name;
        $asset->category = $category;
        $asset->tanggal_penerimaan = now();

        // Simpan gambar jika ada
        if ($request->hasFile('gambar_aset')) {
            $file = $request->file('gambar_aset');
            $filename = time() . '_' . $file->getClientOriginalName();
            $path = $file->storeAs('assets', $filename, 'public');
            $asset->gambar_aset = $path;
        }

        $asset->save();

        // Simpan riwayat
        $riwayat = new Riwayat();
        $riwayat->asset_id = $asset->id;
        $riwayat->admin = Auth::user()->name;
        $riwayat->tanggal = now();
        $riwayat->keterangan = 'Aset baru ditambahkan';
        $riwayat->save();

        return redirect()->route('category.show', $category)->with('success', 'Aset berhasil ditambahkan.');
    }
}
