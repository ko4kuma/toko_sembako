<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BarangController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\PembayaranController;

Route::resource('barang', BarangController::class)->except('show');
Route::resource('supplier', SupplierController::class)->except('show');
Route::resource('kategori', KategoriController::class)->except('show');
Route::resource('pembayaran', PembayaranController::class);
