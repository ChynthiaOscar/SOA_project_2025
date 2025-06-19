<?php

use App\Http\Controllers\EventController;
use App\Http\Controllers\EventPackageController;
use App\Http\Controllers\EventSpaceController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\InventoryItemController;
use App\Http\Controllers\InventoryCategoryController;
use App\Http\Controllers\DishCategoriesController;

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
Route::prefix('event-packages')->name('event-packages.')->group(function () {
    Route::get('/', [EventPackageController::class, 'index'])->name('index');
    Route::get('/create', [EventPackageController::class, 'create'])->name('create');
    Route::post('/', [EventPackageController::class, 'store'])->name('store');
    Route::get('/{id}/edit', [EventPackageController::class, 'edit'])->name('edit');
    Route::get('/{id}', [EventPackageController::class, 'show'])->name('show');
    Route::put('/{id}', [EventPackageController::class, 'update'])->name('update');
    Route::delete('/{id}', [EventPackageController::class, 'destroy'])->name('destroy');
});

// Route::resource('event-spaces', [EventSpaceController::class]);
Route::prefix('event-spaces')->name('event-space.')->group(function () {
    Route::get('/', [EventSpaceController::class, 'index'])->name('index');
    Route::get('/create', [EventSpaceController::class, 'create'])->name('create');
    Route::post('/', [EventSpaceController::class, 'store'])->name('store');
    Route::get('/edit/{id}', [EventSpaceController::class, 'edit'])->name('edit');
    Route::get('/{id}', [EventSpaceController::class, 'show'])->name('show');
    Route::put('/{id}', [EventSpaceController::class, 'update'])->name('update');
    Route::delete('/{id}', [EventSpaceController::class, 'destroy'])->name('destroy');
});

Route::prefix('dish-categories')->name('dish-categories.')->group(function () {
    Route::get('/', [DishCategoriesController::class, 'index'])->name('index');
    Route::get('/create', [DishCategoriesController::class, 'create'])->name('create');
    Route::post('/', [DishCategoriesController::class, 'store'])->name('store');
    Route::get('/edit/{id}', [DishCategoriesController::class, 'edit'])->name('edit');
    Route::get('/{id}', [DishCategoriesController::class, 'show'])->name('show');
    Route::put('/{id}', [DishCategoriesController::class, 'update'])->name('update');
    Route::delete('/{id}', [DishCategoriesController::class, 'destroy'])->name('destroy');
});
