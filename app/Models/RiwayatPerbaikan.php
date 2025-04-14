<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RiwayatPerbaikan extends Model
{
    protected $fillable = [
        'asset_id', 'keterangan', 'tanggal_rusak', 'tanggal_perbaikan'
    ];

    public function asset()
    {
        return $this->belongsTo(Asset::class);
    }
}
