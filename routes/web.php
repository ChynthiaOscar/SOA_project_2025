<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\MenuRecipeController;
use App\Http\Controllers\MenuCategoryController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Password;
use Illuminate\Http\Request;

// menu
Route::get('/', function () {
    return view('pages.homepage');
});

// Auth & Profile
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

//service lain
