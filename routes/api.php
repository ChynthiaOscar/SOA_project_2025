<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\InventoryItemController;
use App\Http\Controllers\InventoryCategoryController;

// API route for getting all inventory items (already exists)
Route::get('/inventory', [InventoryItemController::class, 'apiIndex']);

// API route for creating a new inventory item (POST)
Route::post('/inventory', [InventoryItemController::class, 'apiStore']);

// API route for creating a new category (POST)
Route::post('/category', [InventoryCategoryController::class, 'apiStore']);
