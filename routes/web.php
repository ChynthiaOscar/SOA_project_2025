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