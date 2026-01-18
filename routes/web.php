<?php

use App\Http\Controllers\Web\MainHomeController;
use Illuminate\Support\Facades\Route;




Route::get('/{category?}', [MainHomeController::class, 'index'])->name('home');

Route::post('/contact/store', [App\Http\Controllers\Web\ContactController::class, 'store'])->name('contact.store');

Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');


require __DIR__ . '/dash.php';

require __DIR__ . '/settings.php';
