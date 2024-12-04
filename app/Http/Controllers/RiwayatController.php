<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\riwayat;

class RiwayatController extends Controller
{
    //
    public function index()
{
    // Mengambil riwayat tanpa eager loading
    $riwayat = riwayat::paginate(10);

    return view('riwayat', compact('riwayat'));
}


    public function destroy($id)
    {
        //Mencari riwayat berdasarkan ID
        $riwayat = Riwayat::find($id);

        if (!$riwayat) {
            return redirect()->back()->withErrors(['message' => 'Riwayat tidak ditemukan.']);
        }

        //Hapus riwayat
        $riwayat->delete();
        return redirect()->route('riwayat')->with('Succes', 'Riwayat berhasil dihapus.');
    }
}
