<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BarangController;
use App\Http\Controllers\BelanjaController;
use App\Http\Controllers\TransaksiController;
use App\Http\Controllers\TransaksiDetailController;

// Route::get('/', function () {
//     return view('welcome');
// });


Route::middleware('auth')->group(function () {
    Route::get('logout', [AuthController::class, 'logout']);
    Route::get('dashboard', [BarangController::class, 'dashboard']);
    Route::get('barang', [BarangController::class, 'index'])->name('barang');
    Route::get('getetalase', [BarangController::class, 'getdataetalase'])->name('getetalase');
    Route::resource('barang', BarangController::class)->except(['show']);
    Route::resource('belanja', BelanjaController::class)->except(['update', 'edit', 'show']);
    Route::get('cart', [TransaksiController::class, 'cart'])->name('cart');

    Route::post('mycart', [TransaksiController::class, 'mycart'])->name('mycart');
    Route::post('checkoutcart', [TransaksiController::class, 'checkout'])->name('checkoutcart');
    Route::get('generateFaktur', [TransaksiController::class, 'generateFaktur'])->name('generateFaktur');
    Route::get('fetchcartitems', [TransaksiController::class, 'fetchcartitems'])->name('fetchcartitems');
    Route::get('clearcart', [TransaksiController::class, 'clearCart'])->name('clearcart');

    Route::resource('transaksi', TransaksiController::class);
    Route::resource('detail', TransaksiDetailController::class);
});
Route::get('fetch-barang', [AuthController::class, 'fetchBarang']);

Route::middleware('guest')->group(function () {
    Route::get('/', [AuthController::class, 'index']);
    Route::post('login', [AuthController::class, 'authenticate'])->name('login');
    Route::get('login', [AuthController::class, 'login']);
    Route::get('register', [AuthController::class, 'register']);
    Route::post('register', [AuthController::class, 'registerUser']);
});
