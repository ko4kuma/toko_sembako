<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\KategoriController;

Route::resource('kategori', KategoriController::class)->except('show');