<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class riwayat extends Model
{
    use HasFactory;

    protected $table = 'riwayat'; 

    public function asset()
    {
        return $this->belongsTo(Asset::class, 'asset_id'); // Menghubungkan dengan model Asset
    }
}
