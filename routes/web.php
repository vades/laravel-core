<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    ds('Welcome to Livewire Volt!');
    return view('welcome');
})->name('home');
