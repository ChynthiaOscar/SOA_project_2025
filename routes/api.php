<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\EmployeeController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::post('/employee/login', [EmployeeController::class, 'login']);
Route::post('/employee/register', [EmployeeController::class, 'register']);
Route::put('/employee/{id}', [EmployeeController::class, 'updateProfile']);
