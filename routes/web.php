<?php

use App\Http\Controllers\EventAddOnsController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\EventPackageController;
use App\Http\Controllers\EventSpaceController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\ManagerController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\MenuRecipeController;
use App\Http\Controllers\MenuCategoryController;
use App\Http\Controllers\Member\ReservationController;
use App\Http\Controllers\Admin\ReservationController as AdminReservationController;
use App\Http\Controllers\Admin\TableController as AdminTableController;
use App\Http\Controllers\Admin\SlotTimeController as AdminSlotTimeController;
use App\Http\Controllers\ChefController;
use App\Http\Controllers\InventoryItemController;
use App\Http\Controllers\InventoryCategoryController;
use App\Http\Controllers\DishCategoriesController;
use App\Http\Controllers\EventMenuController;
use App\Http\Controllers\EventReservationController;
use App\Http\Controllers\KitchenController;
use App\Http\Controllers\VoucherController;



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

// Member Dashboard
Route::middleware(['auth.reservation'])->group(function () {
    Route::get('/member/dashboard', function () {
        return view('pages.member.dashboard');
    })->name('member.dashboard');
});

// Member Reservations - Updated to use session-based authentication
Route::prefix('member/reservations')->name('member.reservations.')->group(function () {
    Route::get('/', [ReservationController::class, 'index'])->name('index');
    Route::get('/create', [ReservationController::class, 'create'])->name('create');
    Route::post('/select-time', [ReservationController::class, 'selectTime'])->name('select-time');
    Route::post('/confirm', [ReservationController::class, 'confirm'])->name('confirm');
    Route::post('/store', [ReservationController::class, 'store'])->name('store');
    Route::get('/{reservationId}/status', [ReservationController::class, 'status'])->name('status');
    Route::post('/{reservationId}/pay', [ReservationController::class, 'pay'])->name('pay');
    Route::post('/{reservationId}/cancel', [ReservationController::class, 'cancel'])->name('cancel');
    Route::get('/{reservationId}/confirmed', [ReservationController::class, 'confirmed'])->name('confirmed');
    Route::get('/{reservationId}/minimal-charge', [ReservationController::class, 'getMinimalCharge'])->name('minimal-charge');
});

// Admin Dashboard
Route::middleware(['role:manager'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', function () {
        return view('pages.admin.dashboard');
    })->name('dashboard');

    // Reservation Management
    Route::prefix('reservations')->name('reservations.')->group(function () {
        Route::get('/', [AdminReservationController::class, 'index'])->name('index');
        Route::post('/{reservationId}/approve', [AdminReservationController::class, 'approve'])->name('approve');
        Route::post('/{reservationId}/reject', [AdminReservationController::class, 'reject'])->name('reject');
    });

    // Table Management
    Route::prefix('tables')->name('tables.')->group(function () {
        Route::get('/', [AdminTableController::class, 'index'])->name('index');
        Route::post('/', [AdminTableController::class, 'store'])->name('store');
        Route::put('/{tableId}', [AdminTableController::class, 'update'])->name('update');
        Route::delete('/{tableId}', [AdminTableController::class, 'destroy'])->name('destroy');
    });

    // Slot Time Management
    Route::prefix('slots')->name('slots.')->group(function () {
        Route::get('/', [AdminSlotTimeController::class, 'index'])->name('index');
        Route::post('/', [AdminSlotTimeController::class, 'store'])->name('store');
        Route::delete('/{slotId}', [AdminSlotTimeController::class, 'destroy'])->name('destroy');
    });
});

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
        Route::get('/employee_data', [ManagerController::class, 'showEmployees'])->name('employee_data');
        Route::get('/employee/{id}/edit', [ManagerController::class, 'editEmployee'])->name('employee.edit');

        // Schedule
        Route::get('/schedule', [ManagerController::class, 'scheduleView'])->name('schedule');
        Route::get('/schedule/add', [ManagerController::class, 'createSingleSchedule'])->name('schedule.single.create');
        Route::get('/schedule/add-batch', [ManagerController::class, 'createBatchSchedule'])->name('schedule.batch.create');
        Route::post('/schedule', [ManagerController::class, 'storeSingleSchedule'])->name('schedule.single.store');
        Route::post('/schedule/batch', [ManagerController::class, 'storeBatchSchedule'])->name('schedule.batch.store');

        // Attendance
        Route::get('/attendance', [ManagerController::class, 'attendanceView'])->name('attendance');
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

// routes untuk payment 
Route::prefix('payment')->group(function () {
    // Success page
    Route::get('/success', [PaymentController::class, 'ShowSuccess'])->name('payment.success');

    // OVO
    Route::get('/ovo', [PaymentController::class, 'SHowOVO'])->name('payment.ovo');
    Route::post('/ovo/generate-qr', [PaymentController::class, 'generateOvoQr'])->name('payment.ovo.generate');

    // Gopay
    Route::get('/gopay', [PaymentController::class, 'ShowGopay'])->name('payment.gopay');
    Route::post('/gopay/generate-qr', [PaymentController::class, 'generateGopayQr'])->name('payment.gopay.generate');

    // QRIS
    Route::get('/qris', [PaymentController::class, 'ShowQris'])->name('payment.qris');
    Route::post('/qris/generate-qr', [PaymentController::class, 'generateQrisQr'])->name('payment.qris.generate');

    // Tunai
    Route::get('/tunai', [PaymentController::class, 'ShowTunai'])->name('payment.tunai');
    Route::post('/tunai/confirm', [PaymentController::class, 'confirmPaymentTunai'])->name('payment.tunai.confirm');

    // BCA VA
    Route::get('/BCA_VA', [PaymentController::class, 'ShowBCA_VA'])->name('payment.bca');
    Route::post('/BCA_VA/generate-va', [PaymentController::class, 'generateBCA_VA'])->name('payment.bca.generate');

    // Get Payment Status
    Route::get('/{payment_id}/check-status', [PaymentController::class, 'getStatustoPayment'])->name('payment.check-status');

    // Cancel Payment
    Route::delete('/cancel', [PaymentController::class, 'cancelPayment'])->name('payment.cancel');
});

// Promo & Voucher Routes
Route::get('/promo', [\App\Http\Controllers\PromoVoucherHomeController::class, 'index'])->name('promoHome');

Route::prefix('promo')->group(function () {
    Route::get('/create', [\App\Http\Controllers\PromoController::class, 'create']);
    Route::post('/store', [\App\Http\Controllers\PromoController::class, 'store']);
});

Route::prefix('promos')->group(function () {
    Route::get('/{id}/edit', [\App\Http\Controllers\PromoController::class, 'edit']);
    Route::put('/{id}', [\App\Http\Controllers\PromoController::class, 'update'])->name('promos.update');
    Route::delete('/{id}', [\App\Http\Controllers\PromoController::class, 'destroy']);
});

Route::prefix('voucher')->group(function () {
    Route::get('/create', [\App\Http\Controllers\VoucherController::class, 'create']);
    Route::post('/store', [\App\Http\Controllers\VoucherController::class, 'store']);
});

Route::get('/voucher/create', [VoucherController::class, 'create']);
Route::post('/voucher/store', [VoucherController::class, 'store']);
Route::resource('vouchers', VoucherController::class);

Route::get('/service-kitchen', [KitchenController::class, 'index'])->name('kitchen.index');
Route::post('/service-kitchen/assign', [KitchenController::class, 'assignChef'])->name('kitchen.assign');
Route::get('/service-kitchen/chef', [ChefController::class, 'chefTasks'])->name('kitchen.show');
Route::post('/service-kitchen/chef/status', [ChefController::class, 'updateStatus'])->name('kitchen.updateStatus');
Route::get('/service-kitchen/dummy', [KitchenController::class, 'dummy_local']);

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

Route::prefix('event-addons')->name('event-addon.')->group(function () {
    Route::get('/', [EventAddOnsController::class, 'index'])->name('index');
    Route::get('/create', [EventAddOnsController::class, 'create'])->name('create');
    Route::post('/', [EventAddOnsController::class, 'store'])->name('store');
    Route::get('/edit/{id}', [EventAddOnsController::class, 'edit'])->name('edit');
    Route::get('/{id}', [EventAddOnsController::class, 'show'])->name('show');
    Route::put('/{id}', [EventAddOnsController::class, 'update'])->name('update');
    Route::delete('/{id}', [EventAddOnsController::class, 'destroy'])->name('destroy');
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

Route::prefix('event-menus')->name('event-menus.')->group(function () {
    Route::get('/', [EventMenuController::class, 'index'])->name('index');
    Route::get('/create', [EventMenuController::class, 'create'])->name('create');
    Route::post('/', [EventMenuController::class, 'store'])->name('store');
    Route::get('/edit/{id}', [EventMenuController::class, 'edit'])->name('edit');
    Route::get('/{id}', [EventMenuController::class, 'show'])->name('show');
    Route::put('/{id}', [EventMenuController::class, 'update'])->name('update');
    Route::delete('/{id}', [EventMenuController::class, 'destroy'])->name('destroy');
});

Route::prefix('event-reservations')->name('event-reservations.')->group(function () {
    Route::get('/', [EventReservationController::class, 'index'])->name('index');
    Route::get('/create', [EventReservationController::class, 'create'])->name('create');
    Route::post('/', [EventReservationController::class, 'store'])->name('store');
    Route::get('/edit/{id}', [EventReservationController::class, 'edit'])->name('edit');
    Route::get('/{id}', [EventReservationController::class, 'show'])->name('show');
    Route::put('/{id}', [EventReservationController::class, 'update'])->name('update');
    Route::delete('/{id}', [EventReservationController::class, 'destroy'])->name('destroy');
});
