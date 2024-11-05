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
            'id_aset' => 'required',
            'name' => 'required|string|max:255',
            'jenis_aset' => 'required|string|max:255',
            'tanggal_penerimaan' => 'required|date',
            'gambar_aset' => 'nullable|image|max:2048',
        ]);

        // Simpan data aset
        $asset = new Asset();
        $asset->id_aset = $request->id_aset;
        $asset->name = $request->name;
        $asset->category = $category;
        $asset->jenis_aset = $request->jenis_aset;
        $asset->tanggal_penerimaan = $request->tanggal_penerimaan;

        // Simpan gambar jika ada
        if ($request->hasFile('gambar_aset')) {
            $file = $request->file('gambar_aset');
            $filename = time() . '_' . $file->getClientOriginalName();
            $path = $file->storeAs('assets', $filename, 'public');
            $asset->gambar_aset = $path;
        }

        $asset->save();

        //Simpan riwayat
        $riwayat = new Riwayat();
        $riwayat->asset_id = $asset->id;
        $riwayat->admin = Auth::user()->name;
        $riwayat->tanggal = now();
        $riwayat->keterangan = 'Aset baru ditambahkan';
        $riwayat->save();

        // Redirect ke halaman yang sesuai
        return redirect()->route('category.show', $category)->with('success', 'Aset berhasil ditambahkan.');
    }
}
