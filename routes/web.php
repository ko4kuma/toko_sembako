<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BarangController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\DiskonController;
use App\Http\Controllers\PembayaranController;
use App\Http\Controllers\MemberController;
use App\Http\Controllers\TransaksiController;
use App\Http\Controllers\StokController;



Route::resource('barang', BarangController::class)->except('show');
Route::resource('supplier', SupplierController::class)->except('show');
Route::resource('kategori', KategoriController::class)->except('show');

Route::get('diskon/eligible', [DiskonController::class, 'eligible'])->name('diskon.eligible');
Route::resource('diskon', DiskonController::class);

Route::resource('pembayaran', PembayaranController::class);
Route::resource('stok', StokController::class);

Route::redirect('/', '/member');

Route::get('member/search', [MemberController::class, 'search'])->name('member.search');
Route::resource('member', MemberController::class);

Route::resource('transaksi', TransaksiController::class);

Route::get(
    '/transaksi/{id}/detail',
    [TransaksiController::class, 'detail']
)->name('transaksi.detail');

Route::get('/transaksi/struk/{id}', [TransaksiController::class, 'struk'])
    ->name('transaksi.struk');



