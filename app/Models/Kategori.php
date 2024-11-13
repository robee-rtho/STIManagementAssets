<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kategori extends Model
{
    use HasFactory;

    // Tentukan nama tabel jika tidak sesuai dengan konvensi
    protected $table = 'kategori';

    // Tentukan kolom yang dapat diisi secara massal
    protected $fillable = [
        'name',
    ];

    // Jika Anda ingin mengatur waktu untuk timestamps (created_at dan updated_at)
    public $timestamps = true;
}
