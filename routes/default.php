<?php

use App\Http\Controllers\Web\Default\ArticleController;
use App\Http\Controllers\Web\Default\HomeController;
use App\Http\Controllers\Web\Default\PageController;
use Illuminate\Support\Facades\Route;

/**
 * Home
 */
Route::get('/', HomeController::class)->name('home');

/**
 * Pages
 */
Route::get('/pages/{slug}', PageController::class)->name('pageItem');

/**
 * Blog
 */
Route::get('/blog', [ArticleController::class, 'index'])->name('articleIndex');

Route::get('/blog/{slug}', [ArticleController::class, 'show'])->name('articleShow');
/**
 * Tags
 */
Route::get('/tag/article', [ArticleController::class, 'tag'])->name('tagArticle');