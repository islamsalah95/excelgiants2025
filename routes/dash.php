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
Route::get('products/{id}/upload-download', [App\Http\Controllers\Dash\ProductController::class, 'uploadDownloadForm'])->name('products.upload-download');
Route::post('products/{id}/upload-download', [App\Http\Controllers\Dash\ProductController::class, 'saveDownloadFile'])->name('products.save-download');
Route::post('media/upload', [App\Http\Controllers\Dash\MediaController::class, 'upload'])->name('media.upload');
Route::delete('media/remove-temp', [App\Http\Controllers\Dash\MediaController::class, 'removeTemp'])->name('media.remove-temp');
Route::delete('media/{id}', [App\Http\Controllers\Dash\MediaController::class, 'destroy'])->name('media.destroy');

