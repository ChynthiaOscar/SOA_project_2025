<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DeliveryController;
use Illuminate\Support\Facades\Http;

Route::get('/delivery', [\App\Http\Controllers\DeliveryController::class, 'getAllDeliveries']);
Route::get('/delivery/status/{status}', [\App\Http\Controllers\DeliveryController::class, 'getDeliveryByStatus']);
Route::put('/delivery/{id}/status', [\App\Http\Controllers\DeliveryController::class, 'updateStatus']);
Route::delete('/delivery/{id}', [\App\Http\Controllers\DeliveryController::class, 'deleteDelivery']);