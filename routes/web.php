<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\ManagerController;

// Public
Route::get('/', function () {
    return view('pages.homepage');
});
Route::prefix('employee')->group(function () {

    Route::get('/login', function () {
        return view('pages.service-employee.login');
    })->name('employee.login');

    Route::get('/register', function () {
        return view('pages.service-employee.employee.register');
    });

    // Authenticated Employee
    Route::middleware(['role'])->group(function () {
        Route::get('/dashboard', [EmployeeController::class, 'dashboard'])->name('employee.dashboard');

        // Shared Profile Routes
        Route::get('/profile', function () {
            return view('pages.service-employee.both.profile');
        })->name('employee.profile');

        Route::get('/editprofile', [EmployeeController::class, 'edit'])->name('employee.edit');
    });

    // Manager-specific routes
    Route::middleware(['role:manager'])->prefix('manager')->name('manager.')->group(function () {
        Route::get('/dashboard', [ManagerController::class, 'index'])->name('dashboard');

        // Employee Management
        Route::get('/employee_data', [ManagerController::class, 'showEmployees'])->name('manager.employee_data');
        Route::get('/employee/{id}/edit', [ManagerController::class, 'editEmployee'])->name('employee.edit');

        // Schedule
        Route::get('/schedule', [ManagerController::class, 'scheduleView'])->name('manager.schedule');
        Route::get('/schedule/add', [ManagerController::class, 'createSingleSchedule'])->name('schedule.single.create');
        Route::get('/schedule/add-batch', [ManagerController::class, 'createBatchSchedule'])->name('schedule.batch.create');
        Route::post('/schedule', [ManagerController::class, 'storeSingleSchedule'])->name('schedule.single.store');
        Route::post('/schedule/batch', [ManagerController::class, 'storeBatchSchedule'])->name('schedule.batch.store');

        // Attendance
        Route::get('/attendance', [ManagerController::class, 'attendanceView'])->name('manager.attendance');
    });
});

Route::prefix('api')->group(function () {
    Route::post('/employee/login', [EmployeeController::class, 'login']);
    Route::post('/employee/register', [EmployeeController::class, 'register']);
    Route::post('/employee/logout', [EmployeeController::class, 'logout'])->name('employee.logout');

    Route::put('/employee/{id}', [EmployeeController::class, 'updateProfile']);
    Route::put('/employee/{id}/manager', [EmployeeController::class, 'updateByManager'])->name('manager.employee.update');

    Route::put('/employee/schedule/{id}', [ManagerController::class, 'updateSchedule'])->name('manager.schedule.update');
});
// Batas Routes untuk Employee
