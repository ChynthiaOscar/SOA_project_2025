<?php

use App\Http\Controllers\ChefController;
use App\Http\Controllers\KitchenController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/service-kitchen', [KitchenController::class, 'index'])->name('kitchen.index');
Route::post('/service-kitchen/assign', [KitchenController::class, 'assignChef'])->name('kitchen.assign');
Route::get('/service-kitchen/chef', [ChefController::class, 'chefTasks'])->name('kitchen.show');
Route::post('/service-kitchen/chef/status', [ChefController::class, 'updateStatus'])->name('kitchen.updateStatus');
Route::get('/service-kitchen/dummy', [KitchenController::class, 'dummy_local']);
