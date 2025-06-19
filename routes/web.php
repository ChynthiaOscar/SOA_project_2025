<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EmployeeController;

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

        // Shared profile routes
        Route::get('/profile', function () {
            return view('pages.service-employee.both.profile');
        });

        Route::get('/editprofile', function () {
            return view('pages.service-employee.both.editprofile');
        });

        // Helper screens
        Route::get('/appManager', function () {
            return view('pages.service-employee.helper.appManager');
        });

        Route::get('/appEmployee', function () {
            return view('pages.service-employee.helper.appEmployee');
        });
    });

    // Manager-specific routes
    Route::middleware(['role:manager'])->group(function () {
        Route::get('/manager/dashboard', [ManagerController::class, 'index']);

        Route::get('/manager/schedule', function () {
            return view('pages.service-employee.manager.schedule');
        });

        Route::get('/manager/attendance', function () {
            return view('pages.service-employee.manager.attendance');
        });

        Route::get('/manager/employee_data', function () {
            return view('pages.service-employee.manager.employee_data');
        });
    });
});
// Batas Routes untuk Employee
