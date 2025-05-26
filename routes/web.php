<?php

// routes/web.php

use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Password;
use Illuminate\Http\Request;
use App\Http\Controllers\ProfileController;

Route::get('/', function () {
    return redirect()->route('login');
});

Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register']);

Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);

Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::middleware('auth:member')->group(function () {
    Route::get('/profile', [AuthController::class, 'profile'])->name('profile');

});

Route::get('/forgot_password', [AuthController::class, 'showForgotPassword'])->name('member.password.request');
Route::post('/forgot_password', [AuthController::class, 'sendResetLink'])->name('member.password.email');

Route::get('/reset_password/{token}', [AuthController::class, 'showResetPassword'])->name('member.password.reset');
Route::post('/reset_password', [AuthController::class, 'resetPassword'])->name('member.password.update');

Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
Route::post('/profile/update', [ProfileController::class, 'update'])->name('profile.update');


