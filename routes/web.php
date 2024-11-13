<?php

use App\Http\Controllers\AssetController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\RiwayatController;
use App\Http\Controllers\TambahKategori;

// Route::get('/', function () {
//     return view('login');
// });
Route::get('/', [AuthController::class, 'showLoginForm'])->name('login.index');
Route::post('/login', [AuthController::class, 'login'])->name('login');
Route::get('/register', [AuthController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [AuthController::class, 'register'])->name('register');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::group(['middleware' => ['auth']], function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
<<<<<<< HEAD
    Route::get('/kategori', [KategoriController::class, 'index'])->name('kategori');
    Route::post('/kategori', [KategoriController::class, 'store'])->name('kategori.store'); // Untuk menambah kategori
    Route::get('/kategori/{categoryName}', [AssetController::class, 'indexByCategory'])->name('kategori.indexByCategory');
    Route::delete('/kategori/{category}', [KategoriController::class, 'destroy'])->name('kategori.destroy'); // Untuk menghapus kategori
=======
    Route::get('/kategori', [TambahKategori::class, 'index'])->name('kategori');
    Route::post('/kategori', [TambahKategori::class, 'store'])->name('kategori.store'); // Untuk menambah kategori
    Route::delete('/kategori/{category}', [TambahKategori::class, 'destroy'])->name('kategori.destroy'); // Untuk menghapus kategori
    Route::get('/kategori/{category}', [KategoriController::class, 'show'])->name('category.show');
    Route::post('/kategori/{category}/store', [KategoriController::class, 'store'])->name('asset.store');
>>>>>>> 0f916f52f1790ca20a63f04a4553d9821830a02a
    Route::get('/riwayat', [RiwayatController::class, 'index'])->name('riwayat');
    Route::delete('/riwayat/{id}', [RiwayatController::class, 'destroy'])->name('riwayat.destroy');
    Route::post('/assets/{category}', [AssetController::class, 'store'])->name('asset.store');
    Route::get('/asset/{id}', [AssetController::class, 'show'])->name('asset.show');
    Route::get('asset/{id}/edit', [AssetController::class, 'edit'])->name('asset.edit');
    Route::put('/asset/{id}', [AssetController::class, 'update'])->name('asset.update');
    Route::delete('/asset/{id}', [AssetController::class, 'destroy'])->name('asset.destroy');
});
