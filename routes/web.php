<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\ManagerController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\MenuRecipeController;
use App\Http\Controllers\MenuCategoryController;
use App\Http\Controllers\PromoController;
use App\Http\Controllers\VoucherController;
use App\Http\Controllers\PromoVoucherHomeController;

Route::get('/', function () {
    return view('pages.homepage');
});

// Auth & Profile (Member)
Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register']);

Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);

Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::get('/profile', [AuthController::class, 'profile'])->name('profile');

Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
Route::post('/profile/update', [ProfileController::class, 'update'])->name('profile.update');
Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

// Menu Management
Route::get('/menu', function () {
    return view('pages.service-menu.customer_pages.all-menu');
});

Route::get('/order_menu', [MenuController::class, 'user_index'])->name('order_menu');
Route::get('/menu_index', [MenuController::class, 'admin_index'])->name('menu_index');
Route::get('/add_menu', [MenuController::class, 'create'])->name('add_menu');
Route::get('/edit_menu/{id}', [MenuController::class, 'edit'])->name('edit_menu');
Route::post('/add_recipe', [MenuRecipeController::class, 'create'])->name('add_recipe');
Route::put('/edit_recipe/{id}', [MenuRecipeController::class, 'edit'])->name('edit_recipe');
Route::post('/store_menu', [MenuRecipeController::class, 'store'])->name('store.menu');
Route::put('/update_menu/{id}', [MenuRecipeController::class, 'update'])->name('update.menu');
Route::delete('/delete_menu', [MenuController::class, 'destroy'])->name('delete.menu');

Route::get('/menu-category', [MenuCategoryController::class, 'index'])->name('menu.category');
Route::post('/store_category', [MenuCategoryController::class, 'store'])->name('store.category');
Route::put('/update_category/{id}', [MenuCategoryController::class, 'update'])->name('update.category');
Route::delete('/delete_category/{id}', [MenuCategoryController::class, 'destroy'])->name('delete.category');
// menu

//Employee
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


// routes untuk payment 

Route::prefix('payment')->group(function () {
    // Success page
    Route::get('/success', [PaymentController::class, 'ShowSuccess'])->name('payment.success');

    // OVO
    Route::get('/ovo', [PaymentController::class, 'SHowOVO'])->name('payment.ovo');
    Route::post('/ovo/generate-qr', [PaymentController::class, 'generateOvoQr'])->name('payment.ovo.generate');

    // Gopay
    Route::get('/gopay', [PaymentController::class, 'ShowGopay'])->name('payment.gopay');
    Route::get('/gopay/generate-qr', [PaymentController::class, 'generateGopayQr'])->name('payment.gopay.generate');

    // QRIS
    Route::get('/qris', [PaymentController::class, 'ShowQris'])->name('payment.qris');
    Route::get('/qris/generate-qr', [PaymentController::class, 'generateQrisQr'])->name('payment.qris.generate');

    // Tunai
    Route::get('/tunai', function () {
        return view('pages.service_payment.Tunai');
    });

    // BCA VA
    Route::get('/BCA_VA', [PaymentController::class, 'ShowBCA_VA'])->name('payment.BCA_VA');
    Route::get('/BCA_VA/generate-va', [PaymentController::class, 'generateBCA_VA'])->name('payment.BCA_VA.generate');

    // Get Payment Status
    Route::get('/getstatus/{payment_id}', [PaymentController::class, 'getStatustoPayment'])->name('payment.getstatus');

    // Cancel Payment
    Route::delete('/cancel', [PaymentController::class, 'cancelPayment'])->name('payment.cancel');
});


// Voucher & Promo Management
Route::get('/promo', function () {
    return view('pages.voucher-promo.promoHome');
});

Route::get('/promo', [PromoVoucherHomeController::class, 'index'])->name('promoHome');

Route::get('/promo/create', [PromoController::class, 'create']);
Route::post('/promo/store', [PromoController::class, 'store']);
Route::resource('promos', PromoController::class);

Route::get('/voucher/create', [VoucherController::class, 'create']);
Route::post('/voucher/store', [VoucherController::class, 'store']);
Route::resource('vouchers', VoucherController::class);