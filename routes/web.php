<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\ReservationController as AdminReservationController;
use App\Http\Controllers\Admin\TableController as TableController;
use App\Http\Controllers\Admin\SlotTimeController as SlotTimeController;
use App\Http\Controllers\Member\ReservationController as MemberReservationController;

Route::get('/', function () {
    return view('pages.homepage');
});

// Member
Route::prefix('member')->middleware(['auth', 'role:member'])->group(function () {
    Route::get('/dashboard', fn() => view('pages.member.dashboard'))->name('member.dashboard');

    Route::prefix('reservations')->group(function () {
        Route::get('/', [MemberReservationController::class, 'index'])->name('member.reservations.index');
        Route::get('/create', [MemberReservationController::class, 'create'])->name('member.reservations.create');
        Route::post('/', [MemberReservationController::class, 'store'])->name('member.reservations.store');

        Route::get('/select-time', [MemberReservationController::class, 'selectTime'])->name('member.reservations.select-time');
        Route::get('/{reservation}/confirm', [MemberReservationController::class, 'confirm'])->name('member.reservations.confirm');
        Route::get('/{reservation}/confirmed', [MemberReservationController::class, 'confirmed'])->name('member.reservations.confirmed');
        Route::get('/{reservation}/status', [MemberReservationController::class, 'status'])->name('member.reservations.status');
    });
});

// Admin
Route::prefix('admin')->middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/dashboard', fn() => view('pages.admin.dashboard'))->name('admin.dashboard');

    // Reservations
    Route::prefix('reservations')->group(function () {
        Route::get('/', [AdminReservationController::class, 'index'])->name('admin.reservations.index');
        Route::get('/{date}', [AdminReservationController::class, 'showByDate'])->name('admin.reservations.byDate');
        Route::post('/{reservation}/reject', [AdminReservationController::class, 'reject'])->name('admin.reservations.reject');
        Route::post('/{reservation}/approve', [AdminReservationController::class, 'approve'])->name('admin.reservations.approve');
    });

    // Tables
    Route::prefix('tables')->group(function () {
        Route::get('/', [TableController::class, 'index'])->name('admin.tables.index');
        Route::post('/store', [TableController::class, 'store'])->name('admin.tables.store');
        Route::post('/update', [TableController::class, 'update'])->name('admin.tables.update');
        Route::post('/delete', [TableController::class, 'destroy'])->name('admin.tables.destroy');
    });

    // Slot Times
    Route::prefix('slots')->group(function () {
        Route::get('/', [SlotTimeController::class, 'index'])->name('admin.slots.index');
        Route::post('/store', [SlotTimeController::class, 'store'])->name('admin.slots.store');
        Route::post('/delete', [SlotTimeController::class, 'destroy'])->name('admin.slots.destroy');
    });
});
