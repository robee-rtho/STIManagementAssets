<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Asset extends Model
{
    use HasFactory;

    
    protected $fillable = [
        'id_aset',
        'name',
        'category',
        'tanggal_penerimaan',
        'gambar_aset',
        'status',
    ];

    public function kategori()
    {
        return $this->belongsTo(Kategori::class, 'name', 'name');
    }
}
