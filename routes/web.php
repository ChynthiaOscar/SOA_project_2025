<?php

use Illuminate\Support\Facades\Route;
use App\Jobs\ExampleRabbitJob;
use App\Http\Controllers\InventoryItemController;
use App\Http\Controllers\InventoryCategoryController;
use App\Jobs\FetchInventoryJob;
use App\Models\InventoryItem;

Route::get('/', [InventoryItemController::class, 'index'])-> name('inventory.index');


Route::resource('inventory', InventoryItemController::class);

Route::resource('categories', InventoryCategoryController::class)->except(['show']);

Route::get('/inventory-categories', [InventoryCategoryController::class, 'index'])->name('service-inventory.category');


Route::get('/test-rabbit', function () {
    ExampleRabbitJob::dispatch();
    return 'Job dispatched!';
});

Route::get('/test-fetch-inventory', function () {
    FetchInventoryJob::dispatch();
    return 'FetchInventoryJob dispatched!';
});

Route::get('/api/inventory', function () {
    return response()->json(InventoryItem::all());
});
Route::post('/api/inventory', [InventoryItemController::class, 'apiStore']);
