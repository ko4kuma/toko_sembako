<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SupplierController;

Route::resource('supplier', SupplierController::class)->except('show');
