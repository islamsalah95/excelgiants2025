<?php

use App\Http\Controllers\Dash\CategoryController;
use App\Http\Controllers\Dash\ProductController;
use App\Http\Controllers\Dash\TagController;
use App\Http\Controllers\Dash\AboutSectionController;
use App\Http\Controllers\Dash\VisionSectionController;
use App\Http\Controllers\Dash\ServicesSectionController;
use App\Http\Controllers\Dash\WorksSectionController;
use App\Http\Controllers\Dash\ContactInfoController;
use App\Http\Controllers\Dash\ContactMessageController;
use App\Http\Controllers\Dash\ReviewController;
use Illuminate\Support\Facades\Route;


Route::get('/home', function () {
    return view('dash.home');
})->name('dash.home');

Route::group(['prefix' => 'dashboard'], function () {
    Route::resource('categories', CategoryController::class);
    Route::resource('contact-infos', ContactInfoController::class);
    Route::resource('contact-messages', ContactMessageController::class)->only(['index', 'show', 'destroy']);
    Route::resource('tags', TagController::class);
    Route::resource('products', ProductController::class);
    Route::resource('about-sections', AboutSectionController::class);
    Route::resource('vision-sections', VisionSectionController::class);
    Route::resource('services-sections', ServicesSectionController::class);
    Route::resource('works-sections', WorksSectionController::class);
    Route::resource('reviews', ReviewController::class);
    Route::get('products/{id}/upload-download', [App\Http\Controllers\Dash\ProductController::class, 'uploadDownloadForm'])->name('products.upload-download');
    Route::post('products/{id}/upload-download', [App\Http\Controllers\Dash\ProductController::class, 'saveDownloadFile'])->name('products.save-download');
    Route::post('media/upload', [App\Http\Controllers\Dash\MediaController::class, 'upload'])->name('media.upload');
    Route::delete('media/remove-temp', [App\Http\Controllers\Dash\MediaController::class, 'removeTemp'])->name('media.remove-temp');
    Route::delete('media/{id}', [App\Http\Controllers\Dash\MediaController::class, 'destroy'])->name('media.destroy');

});
