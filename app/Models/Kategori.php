<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kategori extends Model
{
    use HasFactory;

    protected $table = 'kategori';

    protected $fillable = [
        'name',
    ];

    public function assets()
{
    return $this->hasMany(Asset::class, 'category', 'name');  // Asumsi 'category' adalah kolom pada table 'assets' yang menyimpan nama kategori
}

    // Jika Anda ingin mengatur waktu untuk timestamps (created_at dan updated_at)
    public $timestamps = true;
}
