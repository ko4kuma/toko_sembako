<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MemberController;
use App\Http\Controllers\TransaksiController;

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