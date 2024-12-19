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
    return $this->hasMany(Asset::class, 'category', 'name'); 
}

    public $timestamps = true;
}

?>