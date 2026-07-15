<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
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
use App\Http\Controllers\PegawaiController;


Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::resource('barang', BarangController::class)->except('show');
    Route::resource('supplier', SupplierController::class)->except('show');
    Route::resource('kategori', KategoriController::class)->except('show');
    Route::get('diskon/eligible', [DiskonController::class, 'eligible'])->name('diskon.eligible');
    Route::resource('diskon', DiskonController::class);
    Route::resource('stok', StokController::class)->only(['index']);
    // Member: index, edit, update, destroy khusus admin
    Route::get('member', [MemberController::class, 'index'])->name('member.index');
    Route::get('member/{member}/edit', [MemberController::class, 'edit'])->name('member.edit');
    Route::put('member/{member}', [MemberController::class, 'update'])->name('member.update');
    Route::delete('member/{member}', [MemberController::class, 'destroy'])->name('member.destroy');
    Route::resource('pegawai', PegawaiController::class)->except('show');
});

Route::middleware(['auth', 'role:kasir,admin'])->group(function () {
    Route::resource('transaksi', TransaksiController::class)->except(['edit', 'update', 'destroy']);
    Route::get('/transaksi/{id}/detail', [TransaksiController::class, 'detail'])->name('transaksi.detail');
    Route::get('/transaksi/struk/{id}', [TransaksiController::class, 'struk'])->name('transaksi.struk');
    // Kasir boleh cari & tambah member 
    Route::get('member/search', [MemberController::class, 'search'])->name('member.search');
    Route::get('member/create', [MemberController::class, 'create'])->name('member.create');
    Route::post('member', [MemberController::class, 'store'])->name('member.store');
});

Route::middleware(['auth', 'role:purchasing,admin'])->group(function () {
    Route::resource('pembelian', PembelianController::class)->only(['index', 'create', 'store']);
    Route::get('/pembelian/{id}/detail', [PembelianController::class, 'detail'])->name('pembelian.detail');
});

Route::middleware(['auth', 'role:gudang'])->group(function () {
    Route::resource('stok-opname', StokOpnameController::class)->only(['index', 'create', 'store', 'destroy']);
    Route::get('stok-opname/{id}/isi', [StokOpnameController::class, 'isiDetail'])->name('stok-opname.isi');
    Route::post('stok-opname/{id}/simpan-detail', [StokOpnameController::class, 'simpanDetail'])->name('stok-opname.simpan-detail');
    Route::post('stok-opname/{id}/selesaikan', [StokOpnameController::class, 'selesaikan'])->name('stok-opname.selesaikan');
});

Route::redirect('/', '/login');



