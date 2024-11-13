<?php

namespace App\Http\Controllers;

use App\Models\Asset;
use App\Models\Kategori;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AssetController extends Controller
{
    

    
    public function show($id)
    {
        // Ambil data aset dari database berdasarkan id
        $asset = Asset::findOrFail($id); // Error jika id tidak ditemukan

        // Mengambil kategori dari aset
        $category = $asset->kategori;

        // Kembalikan view untuk detail barang
        return view('asset.show', compact('asset', 'category'));
    }

    public function store(Request $request, $category)
    {
        // Validasi input
        $request->validate([
            'name' => 'required|string|max:255',
            'jenis_aset' => 'required|string|max:255',
            'gambar_aset' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        // Ambil kategori untuk mendapatkan ID
        $kategori = Kategori::where('name', $category)->firstOrFail();

        // Ambil prefix dari nama kategori
        $prefix = strtoupper($kategori->name);

        // Hitung jumlah aset yang ada dengan prefix yang sama
        $latestAsset = Asset::where('id_aset', 'like', "{$prefix}-%")->latest()->first();

        // Buat ID baru dengan format prefix-angka
        $newId = $prefix . '-' . sprintf('%03d', ($latestAsset ? intval(substr($latestAsset->id_aset, strlen($prefix) + 1)) + 1 : 1));

        // Simpan data aset baru
        Asset::create([
            'id_aset' => $newId,
            'name' => $request->name,
            'jenis_aset' => $request->jenis_aset,
            'gambar_aset' => $request->hasFile('gambar_aset') ? $request->file('gambar_aset')->store('assets', 'public') : null,
        ]);

        return redirect()->route('category.show', $category)->with('success', 'Aset berhasil ditambahkan!');
    }

    public function update(Request $request, $id)
    {
        // Validasi input
        $request->validate([
            'name' => 'required|string|max:255',
            'jenis_aset' => 'required|string|max:255',
            'gambar_aset' => 'nullable|image|mimes:jpeg,png,jpg|max:2048', // Jika gambar diupload
        ]);

        // Ambil data aset dari database
        $asset = Asset::findOrFail($id); // Error jika id tidak ditemukan

        // Update data aset
        $asset->name = $request->name;
        $asset->jenis_aset = $request->jenis_aset;

        // Jika ada gambar baru, simpan dan update field gambar_aset
        if ($request->hasFile('gambar_aset')) {
            // Hapus gambar lama jika ada
            if ($asset->gambar_aset) {
                Storage::disk('public')->delete($asset->gambar_aset);
            }

            // Simpan gambar baru di folder 'public/assets'
            $path = $request->file('gambar_aset')->store('assets', 'public');
            $asset->gambar_aset = $path; // Simpan path langsung tanpa perlu str_replace
        }

        // Simpan perubahan ke database
        $asset->save();

        // Redirect atau kembali dengan pesan sukses
        return redirect()->route('asset.show', $asset->id)->with('success', 'Aset berhasil diperbarui!');
    }

    public function destroy($id)
    {
        // Ambil data aset berdasarkan ID
        $asset = Asset::findOrFail($id);

        // Hapus file gambar dari storage jika ada
        if ($asset->gambar_aset) {
            Storage::disk('public')->delete($asset->gambar_aset);
        }

        // Hapus data aset dari database
        $asset->delete();

        // Redirect ke halaman daftar aset dengan pesan sukses
        return redirect()->route('kategori')->with('success', 'Aset berhasil dihapus.');
    }
}
