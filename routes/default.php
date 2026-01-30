<?php

use App\Http\Controllers\Web\Default\HomeController;
use Illuminate\Support\Facades\Route;

/**
 * Home
 */
Route::get('/', HomeController::class)->name('home');