<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PromoController;
use App\Http\Controllers\VoucherController;
use App\Http\Controllers\PromoVoucherHomeController;

Route::get('/promo', function () {
    return view('pages.voucher-promo.promoHome');
});

Route::get('/promo', [PromoVoucherHomeController::class, 'index']);

Route::get('/promo/create', [PromoController::class, 'create']);
Route::post('/promo/store', [PromoController::class, 'store']);
Route::resource('promos', PromoController::class);

Route::get('/voucher/create', [VoucherController::class, 'create']);
Route::post('/voucher/store', [VoucherController::class, 'store']);
Route::resource('vouchers', VoucherController::class);
