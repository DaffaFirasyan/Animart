<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\BahanBakuController;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\ResepController;
use App\Http\Controllers\KasirController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\LaporanController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return redirect()->route('login');
});

// Grup route yang HANYA bisa diakses setelah login
Route::middleware('auth')->group(function () {
    
    // Rute Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Route untuk Profile
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Rute untuk Kasir 
    Route::get('kasir', [KasirController::class, 'index'])->name('kasir.index');
    Route::post('kasir', [KasirController::class, 'store'])->name('kasir.store');

    // Rute untuk CRUD Bahan Baku 
    Route::resource('bahan-baku', BahanBakuController::class);
    Route::get('/bahan-baku/{bahanBaku}/tambah-stok', [BahanBakuController::class, 'showTambahStokForm'])
         ->name('bahan-baku.show-tambah-stok');
    Route::post('/bahan-baku/tambah-stok', [BahanBakuController::class, 'storeTambahStok'])
         ->name('bahan-baku.store-tambah-stok');

    // Rute untuk CRUD Menu 
    Route::resource('menu', MenuController::class);

    // Rute untuk Resep 
    Route::post('resep', [ResepController::class, 'store'])->name('resep.store');
    Route::delete('resep/{resep}', [ResepController::class, 'destroy'])->name('resep.destroy');

    // Rute untuk Laporan 
    Route::get('laporan', [LaporanController::class, 'index'])->name('laporan.index');
    Route::get('laporan/pdf', [LaporanController::class, 'downloadPDF'])->name('laporan.pdf');
});

// Route autentikasi bawaan Breeze (biarkan di paling bawah)
require __DIR__.'/auth.php';