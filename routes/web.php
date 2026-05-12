<?php

use App\Http\Controllers\StokController;
use App\Http\Controllers\DiskonController;
use App\Http\Controllers\PembayaranController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::resource('stok', StokController::class);
Route::resource('diskon', DiskonController::class);
Route::resource('pembayaran', PembayaranController::class);