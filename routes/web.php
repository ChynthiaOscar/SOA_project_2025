<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EmployeeController;

Route::get('/', function () {
    return view('pages.homepage');
});

// Employee Routes
Route::get('/appManager', function () {
    return view('/pages/service-employee/helper/appManager');
});

Route::get('/appEmployee', function () {
    return view('/pages/service-employee/helper/appEmployee');
});


Route::get('/login', function () {
    return view('/pages/service-employee/login');
});

Route::get('/dashboard', function () {
    return view('/pages/service-employee/employee/dashboard');
});
Route::get('/register', function () {
    return view('/pages/service-employee/employee/register');
});

// Employee & Manager PROFILE

Route::get('/profile', function () {
    return view('/pages/service-employee/both/profile');
});

Route::get('/editprofile', function () {
    return view('pages/service-employee/both/editprofile');
});

// Manager

Route::get('/schedule', function () {
    return view('/pages/service-employee/manager/schedule');
});

Route::get('/attendance', function () {
    return view('/pages/service-employee/manager/attendance');
});

Route::get('/employee_data', function () {
    return view('/pages/service-employee/manager/employee_data');
});

// Batas Routes untuk Employee
