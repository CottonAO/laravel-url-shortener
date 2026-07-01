<?php

use App\Http\Controllers\RedirectController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::get('/{shortCode}', RedirectController::class)
    ->where('shortCode', '[a-zA-Z0-9]+')
    ->name('redirect');
