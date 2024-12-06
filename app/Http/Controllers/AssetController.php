<?php

namespace App\Http\Controllers;

use App\Models\Asset;
use App\Models\Kategori;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use SimpleSoftwareIO\QrCode\Facades\QrCode;


class AssetController extends Controller
{

    public function show($id)
    {
        // Ambil data aset dari database berdasarkan id
        $asset = Asset::findOrFail($id);

        // Mengambil kategori dari aset
        $category = $asset->kategori;

        // Kembalikan view untuk detail barang
        return view('asset.show', compact('asset', 'category'));
    }

    // Update Asset
    public function update(Request $request, $id)
    {
        // Validasi input
        $request->validate([
            'name' => 'required|string|max:255',
            'gambar_aset' => 'nullable|image|mimes:jpeg,png,jpg|max:2048', // Jika gambar diupload
        ]);

        // Ambil data aset dari database
        $asset = Asset::findOrFail($id); // Error jika id tidak ditemukan

        // Update data aset
        $asset->name = $request->name;

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
        return redirect()->route('assets.show', ['id' => $asset->id])->with('success', 'Aset berhasil diperbarui!');
    }

    public function generateQRCode($id)
    {
        $link = route('asset.show', ['id' => $id]);

        $qrCodeSVG = \QrCode::format('svg')->size(100)->generate($link);


        $path = public_path('qrcodes/' . $id . '.svg');
        file_put_contents($path, $qrCodeSVG);

        return back()->with('success', 'QR Code berhasil di-generate dan disimpan.');
    }

    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|string',
        ]);

        $asset = Asset::findOrFail($id);
        $asset->status = $request->status;
        $asset->save();

        return back()->with('success', 'Status aset berhasil diperbarui.');
    }

    // Hapus Asset
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
