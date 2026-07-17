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
use App\Http\Controllers\LaporanController;
use App\Http\Controllers\DashboardController;


Route::get('/', function () {
    if (auth()->check()) {
        return redirect()->route('dashboard');
    }

    return redirect()->route('login');
});

Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
});

Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::resource('barang', BarangController::class)->except('show');
    Route::resource('supplier', SupplierController::class)->except('show');
    Route::resource('kategori', KategoriController::class)->except('show');
    Route::get('diskon/eligible', [DiskonController::class, 'eligible'])->name('diskon.eligible');
    Route::resource('diskon', DiskonController::class);
    Route::resource('stok', StokController::class)->only(['index']);
    Route::get('member', [MemberController::class, 'index'])->name('member.index');
    Route::get('member/{member}/edit', [MemberController::class, 'edit'])->name('member.edit');
    Route::put('member/{member}', [MemberController::class, 'update'])->name('member.update');
    Route::delete('member/{member}', [MemberController::class, 'destroy'])->name('member.destroy');
    Route::resource('pegawai', PegawaiController::class)->except('show');
    Route::get('/laporan', [LaporanController::class, 'index'])->name('laporan.index');
    Route::get('/laporan/print', [LaporanController::class, 'print'])->name('laporan.print');
    Route::post('/stok-opname/{id}/approve', [StokOpnameController::class, 'approve'])->name('stok-opname.approve');
    Route::post('/stok-opname/{id}/reject', [StokOpnameController::class, 'reject'])->name('stok-opname.reject');
});

Route::middleware(['auth', 'role:kasir,admin'])->group(function () {
    Route::resource('transaksi', TransaksiController::class)->except(['edit', 'update', 'destroy']);
    Route::get('/transaksi/{id}/detail', [TransaksiController::class, 'detail'])->name('transaksi.detail');
    Route::get('/transaksi/struk/{id}', [TransaksiController::class, 'struk'])->name('transaksi.struk');
    // Kasir boleh cari & tambah member 
    Route::get('member', [MemberController::class, 'index'])->name('member.index');
    Route::get('member/search', [MemberController::class, 'search'])->name('member.search');
    Route::get('member/create', [MemberController::class, 'create'])->name('member.create');
    Route::post('member', [MemberController::class, 'store'])->name('member.store');
    // Kasir boleh cek eligibilitas diskon saat transaksi
    Route::get('diskon/eligible', [DiskonController::class, 'eligible'])->name('diskon.eligible');
});

Route::middleware(['auth', 'role:purchasing,admin'])->group(function () {
    Route::resource('pembelian', PembelianController::class)->only(['index', 'create', 'store']);
    Route::get('/pembelian/{id}/detail', [PembelianController::class, 'detail'])->name('pembelian.detail');
});

Route::middleware(['auth', 'role:gudang,admin'])->group(function () {
    Route::resource('stok-opname', StokOpnameController::class)->only(['index', 'create', 'store', 'destroy']);
    Route::get('stok-opname/{id}/isi', [StokOpnameController::class, 'isiDetail'])->name('stok-opname.isi');
    Route::post('stok-opname/{id}/simpan-detail', [StokOpnameController::class, 'simpanDetail'])->name('stok-opname.simpan-detail');
    Route::post('stok-opname/{id}/ajukan', [StokOpnameController::class, 'ajukan'])->name('stok-opname.ajukan');

});

    Route::get('/pembelian/{id}/edit', [PembelianController::class, 'edit'])
        ->name('pembelian.edit');

    Route::put('/pembelian/{id}', [PembelianController::class, 'update'])
        ->name('pembelian.update');


