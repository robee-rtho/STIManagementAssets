<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Asset extends Model
{
    use HasFactory;

    // Tentukan kolom yang dapat diisi secara massal
    protected $fillable = [
        'id_aset',
        'name',
        'jenis_aset',
        'tanggal_penerimaan',
        'gambar_aset',
    ];

    public function kategori()
    {
        return $this->belongsTo(Kategori::class, 'name', 'name');
    }
}
