<?php

use App\Http\Controllers\MenuController;
use App\Http\Controllers\MenuRecipeController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('pages.homepage');
});

//cuma buat cek UI
Route::get('/menu', function () {
    return view('pages.service-menu.customer_pages.all-menu');
});

Route::get('/order_menu', [MenuController::class, 'user_index'])->name('order_menu');
Route::get('/add_menu', [MenuController::class, 'create'])->name('add_menu');
Route::get('/menu_index', [MenuController::class, 'admin_index'])->name('menu_index');
Route::post('/add_recipe', [MenuRecipeController::class, 'create'])->name('add_recipe');


Route::get('/add_category', function () {
    return view('pages.service-menu.admin_pages.menu-category');
});



Route::get('/edit_menu', function () {
    return view('pages.service-menu.admin_pages.menu.edit');
});


Route::get('/edit_recipe', function () {
    return view('pages.service-menu.admin_pages.menu.edit-recipe');
});