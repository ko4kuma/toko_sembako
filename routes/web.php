<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BarangController;

Route::resource('barang', BarangController::class)->except('show');