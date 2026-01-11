<?php

use Illuminate\Support\Facades\Route;


Route::get('/home', function () {
    return view('dash.home');
})->name('dash.home');