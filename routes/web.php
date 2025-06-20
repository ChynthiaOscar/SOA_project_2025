<?php

use App\Http\Controllers\ChefController;
use App\Http\Controllers\KitchenController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});
