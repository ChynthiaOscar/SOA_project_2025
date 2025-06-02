<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EmployeeController;

Route::get('/', function () {
    return view('pages.homepage');
});

// Employee Routes
Route::get('/appManager', function () {
    return view('/helper/appManager');    
});

Route::get('/appEmployee', function () {
    return view('/helper/appEmployee');    
});


Route::get('/login', function () {
    return view('/pages/service-employee/login');
});

Route::get('/dashboard', function () {
    return view('/employee/dashboard');
});

Route::get('/profile', function () {
    return view('/profile');
});

Route::get('/schedule', function () {
    return view('/manager/schedule');
});

Route::get('/attendance', function () {
    return view('/manager/attendance');
});

Route::get('/employee_data', function () {
    return view('/manager/employee_data');
});

// Register
Route::get('/register', [EmployeeController::class, 'showForm']);
Route::post('/register', [EmployeeController::class, 'store'])->name('employee.store');

// Batas Routes untuk Employee