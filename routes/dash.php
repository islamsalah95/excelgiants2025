<?php

use App\Http\Controllers\Dash\CategoryController;
use App\Http\Controllers\Dash\ProductController;
use App\Http\Controllers\Dash\TagController;
use Illuminate\Support\Facades\Route;


Route::get('/home', function () {
    return view('dash.home');
})->name('dash.home');

Route::resource('categories', CategoryController::class);
Route::resource('tags', TagController::class);
Route::resource('products', ProductController::class);
Route::delete('media/{id}', [App\Http\Controllers\Dash\MediaController::class, 'destroy'])->name('media.destroy');

