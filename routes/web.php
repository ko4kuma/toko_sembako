<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BarangController;
use App\Http\Controllers\SupplierController;

Route::resource('barang', BarangController::class)->except('show');
Route::resource('supplier', SupplierController::class)->except('show');
