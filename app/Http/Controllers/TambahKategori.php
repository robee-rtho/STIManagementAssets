<?php

namespace App\Http\Controllers;
use App\Models\Kategori;
use Illuminate\Http\Request;

class TambahKategori extends Controller
{
    public function index()
    {
        // Mengambil semua kategori dari database
        $categories = Kategori::all(); // Mengambil data kategori
        return view('kategori', compact('categories'));
    }

    public function store(Request $request)
    {
        // Validasi input
        $request->validate([
            'name' => 'required|string|max:255|unique:kategori',
            'icon' => 'nullable|image|max:2048', // Validasi kategori unik
        ]);

        //Simpan Kategori Baru
        $kategori = new Kategori();
        $kategori->name = $request->name;

        if ($request->hasFile('icon')) {
            $file = $request->file('icon');
            $filename = time() . '_' . $file->getClientOriginalName();
            $path = $file->storeAs('icons', $filename, 'public'); // Simpan ikon di storage/app/public/icons
            $kategori->icon = $path; // Simpan path ikon ke dalam kolom icon
        }

        $kategori->save(); // Simpan kategori ke dalam database

        return redirect()->route('kategori')->with('success', 'Kategori berhasil ditambahkan.');
    }

    public function destroy($category)
    {
        // Hapus kategori
        $categoryToDelete = Kategori::where('name', $category)->first();

        if ($categoryToDelete) {
            $categoryToDelete->delete();
            return redirect()->route('kategori')->with('success', 'Kategori berhasil dihapus.');
        }

        return redirect()->route('kategori')->withErrors(['msg' => 'Kategori tidak ditemukan.']);
    }


}