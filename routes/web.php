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

