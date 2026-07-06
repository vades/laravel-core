<?php

use App\Http\Controllers\Web\Default\ArticleController;
use App\Http\Controllers\Web\Default\HomeController;
use App\Http\Controllers\Web\Default\PageController;
use App\Http\Controllers\Web\Default\PhotoGalleryController;
use App\Http\Controllers\Web\Default\PlaceController;
use App\Http\Controllers\Web\Default\TagController;
use App\Http\Middleware\AbortWithNotFound;
use Illuminate\Support\Facades\Route;

/**
 * Home
 */
Route::get('/', HomeController::class)->name('home');
Route::permanentRedirect('/home', '/');

/**
 * Pages
 */
Route::get('/pages/{slug}', PageController::class)->name('pageItem');

/**
 * Blog
 */
Route::get('/blog', [ArticleController::class, 'index'])->name('articleIndex') ->middleware(AbortWithNotFound::class);

Route::get('/blog/{slug}', [ArticleController::class, 'show'])->name('articleShow') ->middleware(AbortWithNotFound::class);

/**
 * Places
 */
Route::get('/place', [PlaceController::class, 'index'])->name('placeIndex') ->middleware(AbortWithNotFound::class);

Route::get('/place/{slug}', [PlaceController::class, 'show'])->name('placeShow') ->middleware(AbortWithNotFound::class);
/**
 * Tags
 */
Route::get('/tags/article', [TagController::class, 'index'])->name('tagArticle') ->middleware(AbortWithNotFound::class);

/**
 * Photo Gallery
 */
Route::get('/photo-gallery', [PhotoGalleryController::class,'index'])->name('photoGalleryIndex') ->middleware(AbortWithNotFound::class);
Route::get('/photo-gallery/{slug}', [PhotoGalleryController::class,'show'])->name('photoGalleryShow');