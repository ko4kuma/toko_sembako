<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BarangController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\DiskonController;
use App\Http\Controllers\PembayaranController;
use App\Http\Controllers\PembelianController;
use App\Http\Controllers\MemberController;
use App\Http\Controllers\TransaksiController;
use App\Http\Controllers\StokController;
use App\Http\Controllers\StokOpnameController;



Route::resource('barang', BarangController::class)->except('show');
Route::resource('supplier', SupplierController::class)->except('show');
Route::resource('kategori', KategoriController::class)->except('show');

Route::get('diskon/eligible', [DiskonController::class, 'eligible'])->name('diskon.eligible');
Route::resource('diskon', DiskonController::class);

// Route::resource('pembayaran', PembayaranController::class);
Route::resource('stok', StokController::class)->only(['index']);

Route::resource('stok-opname', StokOpnameController::class)->only(['index', 'create', 'store', 'destroy']);
Route::get('stok-opname/{id}/isi', [StokOpnameController::class, 'isiDetail'])->name('stok-opname.isi');
Route::post('stok-opname/{id}/simpan-detail', [StokOpnameController::class, 'simpanDetail'])->name('stok-opname.simpan-detail');
Route::post('stok-opname/{id}/selesaikan', [StokOpnameController::class, 'selesaikan'])->name('stok-opname.selesaikan');

Route::resource('pembelian', PembelianController::class)->only(['index', 'create', 'store']);
Route::get('/pembelian/{id}/detail', [PembelianController::class, 'detail'])->name('pembelian.detail');

Route::redirect('/', '/member');

Route::get('member/search', [MemberController::class, 'search'])->name('member.search');
Route::resource('member', MemberController::class);

Route::resource('transaksi', TransaksiController::class)->except(['edit', 'update', 'destroy']);

Route::get(
    '/transaksi/{id}/detail',
    [TransaksiController::class, 'detail']
)->name('transaksi.detail');

Route::get('/transaksi/struk/{id}', [TransaksiController::class, 'struk'])
    ->name('transaksi.struk');



