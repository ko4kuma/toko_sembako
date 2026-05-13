<?php

use App\Http\Controllers\StokController;
use App\Http\Controllers\DiskonController;
use App\Http\Controllers\PembayaranController;
use App\Http\Controllers\MemberController;
use App\Http\Controllers\TransaksiController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\BarangController;
use App\Http\Controllers\KategoriController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

Route::redirect('/', '/member');


// MEMBER
Route::resource('member', MemberController::class);


// TRANSAKSI
Route::resource('transaksi', TransaksiController::class);


// DETAIL TRANSAKSI PER TRANSAKSI
Route::get(
    '/transaksi/{id}/detail',
    [TransaksiController::class, 'detail']
)->name('transaksi.detail');

Route::get('/transaksi/struk/{id}', [TransaksiController::class, 'struk'])
    ->name('transaksi.struk');


Route::resource('stok', StokController::class);
Route::resource('diskon', DiskonController::class);
Route::resource('pembayaran', PembayaranController::class);
Route::resource('supplier', SupplierController::class)->except('show');
Route::resource('barang', BarangController::class)->except('show');
Route::resource('kategori', KategoriController::class)->except('show');


