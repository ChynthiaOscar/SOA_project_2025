<?php

use Illuminate\Support\Facades\Route;
use PHPUnit\Framework\Attributes\Group;
use App\Http\Controllers\PaymentController;

Route::get('/', function () {
    return view('pages.homepage');
});

Route::get('/payment/ovo', function () {
    return view('pages.service_payemnt.OVO');
});

// success untuk semua payment method {masih subject to change}
Route::get('/payment/success', [PaymentController::class, 'ShowSuccess'])->name('payment.success');
// ovo
Route::get('/payment/ovo', [PaymentController::class, 'SHowOVO'])->name('payment.ovo');
Route::get('/payment/ovo/generate-qr', [PaymentController::class, 'generateOvoQr'])->name('payment.ovo.generate');
// gopay
Route::get('/payment/gopay', [PaymentController::class, 'ShowGopay'])->name('payment.gopay');
Route::get('/payment/gopay/generate-qr', [PaymentController::class, 'generateGopayQr'])->name('payment.gopay.generate');
// qris
Route::get('/payment/qris', [PaymentController::class, 'ShowQris'])->name('payment.qris');
Route::get('/payment/gris/generate-qr', [PaymentController::class, 'generateQrisQr'])->name('payment.qris.generate');

Route::get('/payment/tunai', function () {
    return view('pages.service_payemnt.Tunai');
});

Route::get('/payment/BCA_VA', function () {
    return view('pages.service_payemnt.BCA_VA');
});
