<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('pages.homepage');
});

//cuma buat cek UI
Route::get('/menu', function () {
    return view('pages.service-menu.customer_pages.all-menu');
});

Route::get('/order_menu', function () {
    return view('pages.service-menu.customer_pages.order-menu');
});

Route::get('/add_category', function () {
    return view('pages.service-menu.admin_pages.menu-category');
});

Route::get('/menu_index', function () {
    return view('pages.service-menu.admin_pages.menu.index');
});

Route::get('/add_menu', function () {
    return view('pages.service-menu.admin_pages.menu.create');
});

Route::get('/edit_menu', function () {
    return view('pages.service-menu.admin_pages.menu.edit');
});

Route::get('/add_recipe', function () {
    return view('pages.service-menu.admin_pages.menu.add-recipe');
});

Route::get('/edit_recipe', function () {
    return view('pages.service-menu.admin_pages.menu.edit-recipe');
});