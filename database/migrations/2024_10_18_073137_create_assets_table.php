<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('assets', function (Blueprint $table) {
            $table->id();
            $table->string('id_aset')->unique();
            $table->string('name'); // Nama aset
            $table->string('category'); // Kategori aset
            $table->string('jenis_aset');
            $table->date('tanggal_penerimaan');
            $table->string('gambar_aset'); // Gambar aset
            $table->timestamps();
        });
        
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('assets');
    }
};
