<?php

use App\Http\Controllers\StokController;
use App\Http\Controllers\DiskonController;
use App\Http\Controllers\PembayaranController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\BarangController;
use App\Http\Controllers\KategoriController;


Route::resource('stok', StokController::class);
Route::resource('diskon', DiskonController::class);
Route::resource('pembayaran', PembayaranController::class);
Route::resource('supplier', SupplierController::class)->except('show');
Route::resource('barang', BarangController::class)->except('show');
Route::resource('kategori', KategoriController::class)->except('show');

