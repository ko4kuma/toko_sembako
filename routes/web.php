<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\BarangController;

// Route::get('/', function () {
//     return view('welcome');
// });
Route::resource('supplier', SupplierController::class)->except('show');
Route::resource('barang', BarangController::class)->except('show');