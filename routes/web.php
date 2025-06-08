<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\InventoryItemController;
use App\Http\Controllers\InventoryCategoryController;

Route::get('/', [InventoryItemController::class, 'index'])-> name('inventory.index');


Route::resource('inventory', InventoryItemController::class);

Route::resource('categories', InventoryCategoryController::class)->except(['show']);

Route::get('/inventory-categories', [App\Http\Controllers\InventoryItemController::class, 'categories'])->name('service-inventory.category');



Route::get('/service-kitchen', function () {
    return view('pages.service-kitchen.index');
});
Route::get('/service-kitchen/{id}', function () {
    return view('pages.service-kitchen.show');
});
