<?php

use App\Http\Controllers\EventController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\InventoryItemController;
use App\Http\Controllers\InventoryCategoryController;

Route::get('/', [InventoryItemController::class, 'index'])->name('inventory.index');


Route::resource('inventory', InventoryItemController::class);

Route::resource('categories', InventoryCategoryController::class)->except(['show']);

Route::get('/inventory-categories', [App\Http\Controllers\InventoryItemController::class, 'categories'])->name('service-inventory.category');



Route::get('/service-kitchen', function () {
    return view('pages.service-kitchen.index');
});
Route::get('/service-kitchen/{id}', function () {
    return view('pages.service-kitchen.show');
});

/**
 * Event Routes 
 */

Route::prefix('events')->name('events.')->group(function () {
    Route::get('/', [EventController::class, 'create'])->name('create');
    Route::get('/validate', [EventController::class, 'validateReservation'])->name('validate');
});

// Employee Data UI Route
Route::get('/employee-data', function () {
    return view('pages.service-event.admin.event_packages.index');
})->name('employee.data');

// Event Package Routes
Route::prefix('event-packages')->group(function () {
    Route::get('/', [App\Http\Controllers\EventPackageController::class, 'index']);
    Route::get('/create', [App\Http\Controllers\EventPackageController::class, 'create']);
    Route::post('/', [App\Http\Controllers\EventPackageController::class, 'store']);
    Route::get('/{id}/edit', [App\Http\Controllers\EventPackageController::class, 'edit']);
    Route::get('/{id}', [App\Http\Controllers\EventPackageController::class, 'show']);
    Route::put('/{id}', [App\Http\Controllers\EventPackageController::class, 'update']);
    Route::patch('/{id}', [App\Http\Controllers\EventPackageController::class, 'update']);
    Route::delete('/{id}', [App\Http\Controllers\EventPackageController::class, 'destroy']);
});
