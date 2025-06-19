<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DeliveryController;
use Illuminate\Support\Facades\Http;

// Frontend routes
Route::get('/', [DeliveryController::class, 'userIndex'])->name('home');
Route::get('/admin', [DeliveryController::class, 'index'])->name('admin');

// API routes for gateway connection
Route::prefix('api/delivery')->group(function () {
    Route::get('/', [DeliveryController::class, 'getAllDeliveries']);
    Route::get('/{id}', [DeliveryController::class, 'getDeliveryById'])->where('id', '[0-9]+');
    Route::get('/status/{status}', [DeliveryController::class, 'getDeliveryByStatus']);
    Route::post('/', [DeliveryController::class, 'createDelivery']);
    Route::post('/search', [DeliveryController::class, 'searchLocation']);
    Route::post('/distance', [DeliveryController::class, 'getDistance']);
    Route::put('/{id}/status', [DeliveryController::class, 'updateStatus'])->where('id', '[0-9]+');
    Route::put('/{id}', [DeliveryController::class, 'updateDelivery'])->where('id', '[0-9]+');
    Route::delete('/{id}', [DeliveryController::class, 'deleteDelivery'])->where('id', '[0-9]+');
});

Route::get('/test-connection', function() {
    try {
        $response = Http::get('http://54.160.170.89:8002/delivery');
        
        if ($response->successful()) {
            return response()->json([
                'status' => 'success',
                'message' => 'Successfully connected to Gateway service',
                'data' => $response->json()
            ]);
        } else {
            return response()->json([
                'status' => 'error',
                'message' => 'Gateway returned an error response',
                'details' => [
                    'status' => $response->status(),
                    'body' => $response->body()
                ]
            ], 500);
        }
    } catch (\Exception $e) {
        return response()->json([
            'status' => 'error',
            'message' => 'Failed to connect to Gateway service',
            'error' => $e->getMessage()
        ], 500);
    }
});

Route::get('/test-connection-page', [DeliveryController::class, 'testConnection']);