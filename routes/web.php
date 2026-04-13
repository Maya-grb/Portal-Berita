<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\NewsController;
use App\Http\Controllers\CategoryController;

Route::get('/', [NewsController::class, 'index']);

Route::get('/admin', function () {
    return view('admin.dashboard');
});
Route::resource('categories', CategoryController::class);
Route::resource('categories', \App\Http\Controllers\CategoryController::class);