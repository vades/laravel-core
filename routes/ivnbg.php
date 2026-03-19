<?php

use App\Http\Controllers\Web\Default\ArticleController;
use App\Http\Controllers\Web\Default\HomeController;
use App\Http\Controllers\Web\Default\PageController;
use App\Http\Controllers\Web\Default\PhotoGalleryController;
use App\Http\Controllers\Web\Default\PlaceController;
use App\Http\Controllers\Web\Default\TagController;
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
 * Places
 */
Route::get('/place', [PlaceController::class, 'index'])->name('placeIndex');

Route::get('/place/{slug}', [PlaceController::class, 'show'])->name('placeShow');
/**
 * Tags
 */
Route::get('/tags/article', [TagController::class, 'index'])->name('tagArticle');

/**
 * Photo Gallery
 */
Route::get('/photo-gallery', [PhotoGalleryController::class,'index'])->name('photoGalleryIndex');
Route::get('/photo-gallery/{slug}', [PhotoGalleryController::class,'show'])->name('photoGalleryShow');