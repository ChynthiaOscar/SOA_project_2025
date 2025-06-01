<?php

use Illuminate\Support\Facades\Route;

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

Route::get('/register', function () {
    return view('/employee/register');
});

Route::get('/login', function () {
    return view('/login');
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
// Batas Routes untuk Empluyee