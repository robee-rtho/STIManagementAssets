<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\RiwayatPerbaikan;
use App\Models\Asset;

class RiwayatPerbaikanController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'asset_id' => 'required|exists:assets,id',
            'keterangan' => 'required|string',
            'tanggal_rusak' => 'required|date',
            'tanggal_perbaikan' => 'nullable|date',
        ]);
        
        RiwayatPerbaikan::create([
            'asset_id' => $request->asset_id,
            'keterangan' => $request->keterangan,
            'tanggal_rusak' => $request->tanggal_rusak,
            'tanggal_perbaikan' => $request->tanggal_perbaikan,
        ]);
        return redirect()->back()->with('success', 'Riwayat perbaikan berhasil ditambahkan.');
    }
}
