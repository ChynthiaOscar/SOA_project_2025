<?php

use Illuminate\Support\Facades\Route;
use PHPUnit\Framework\Attributes\Group;
use App\Http\Controllers\PaymentController;

Route::get('/', function () {
    return view('pages.homepage');
});

Route::get('/payment/ovo', function () {
    return view('pages.service_payment.OVO');
});

// success untuk semua payment method {masih subject to change}
Route::get('/payment/success', [PaymentController::class, 'ShowSuccess'])->name('payment.success');
// ovo
Route::get('/payment/ovo', [PaymentController::class, 'SHowOVO'])->name('payment.ovo');
Route::post('/payment/ovo/generate-qr', [PaymentController::class, 'generateOvoQr'])->name('payment.ovo.generate');
// gopay
Route::get('/payment/gopay', [PaymentController::class, 'ShowGopay'])->name('payment.gopay');
Route::get('/payment/gopay/generate-qr', [PaymentController::class, 'generateGopayQr'])->name('payment.gopay.generate');
// qris
Route::get('/payment/qris', [PaymentController::class, 'ShowQris'])->name('payment.qris');
Route::get('/payment/gris/generate-qr', [PaymentController::class, 'generateQrisQr'])->name('payment.qris.generate');

Route::get('/payment/success',[PaymentController::class, 'ShowSuccess'])->name('payment.success');

Route::get('/payment/tunai', function () {
    return view('pages.service_payment.Tunai');
});

Route::get('/payment/BCA_VA', [PaymentController::class, 'ShowBCA_VA'])->name('payment.BCA_VA');
Route::get('/payment/BCA_VA/generate-va', [PaymentController::class, 'generateBCA_VA'])->name('payment.BCA_VA.generate');

Route::get('/payment/getstatus/{payment_id}',[PaymentController::class, 'getStatustoPayment'])->name('payment.getstatus');
;


Route::delete('/payment/cancel', [PaymentController::class, 'cancelPayment'])->name('payment.cancel');