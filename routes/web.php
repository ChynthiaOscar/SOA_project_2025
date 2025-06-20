<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DeliveryController;
use Illuminate\Support\Facades\Http;

// Frontend routes
Route::get('/delivery', [DeliveryController::class, 'userIndex'])->name('delivery.user');
Route::get('/delivery/admin', [DeliveryController::class, 'index'])->name('delivery.admin');

// API routes for gateway connection
Route::prefix('api/delivery')->group(function () {
    Route::get('/', [DeliveryController::class, 'getAllDeliveries']);
    Route::get('/{id}', [DeliveryController::class, 'getDeliveryById'])->where('id', '[0-9]+');
    Route::get('/status/{status}', [DeliveryController::class, 'getDeliveryByStatus']);
    Route::post('/create', [DeliveryController::class, 'createDelivery']);
    Route::post('/search', [DeliveryController::class, 'searchLocation']);
    Route::post('/distance', [DeliveryController::class, 'getDistance']);
    Route::put('/{id}/status', [DeliveryController::class, 'updateStatus'])->where('id', '[0-9]+');
    Route::put('/{id}', [DeliveryController::class, 'updateDelivery'])->where('id', '[0-9]+');
    Route::delete('/{id}', [DeliveryController::class, 'deleteDelivery'])->where('id', '[0-9]+');
});