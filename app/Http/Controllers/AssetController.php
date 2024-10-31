<?php

namespace App\Http\Controllers;

use App\Models\Asset;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;


class AssetController extends Controller
{
    public function show($id)
    {
        // Ambil data aset dari database berdasarkan id
        $asset = Asset::findOrFail($id); // Error jika id tidak ditemukan

        // Mengambil kategori dari aset
        $category = $asset->category;


        // Kembalikan view untuk detail barang
        return view('asset.show', compact('asset', 'category'));
    }

    public function update(Request $request, $id)
    {
        // Validasi input
        $request->validate([
            'nama_barang' => 'required|string|max:255',
            'jenis_aset' => 'required|string|max:255',
            'tanggal_penerimaan' => 'required|date',
            'gambar_aset' => 'nullable|image|mimes:jpeg,png,jpg|max:2048', // Jika gambar diupload
        ]);

        // Ambil data aset dari database
        $asset = Asset::findOrFail($id); // Error jika id tidak ditemukan



        // Update data aset
        $asset->name = $request->nama_barang;
        $asset->jenis_aset = $request->jenis_aset;
        $asset->tanggal_penerimaan = $request->tanggal_penerimaan;

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
