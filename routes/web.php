<?php

use App\Http\Controllers\Admin\ScrapeController;
use App\Http\Controllers\ArticleController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\StorageController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('pages.landingpage');
});

Route::get('/dashboard', [DashboardController::class, 'show'])->middleware(['auth'])->name('dashboard');

Route::prefix('products')->middleware('auth')->name('products')->group(
    function(){
        // Show the products page
        Route::get('/', [ArticleController::class, 'show']);
        // ...
    }
);

Route::prefix('basket')->middleware('auth')->name('basket')->group(
    function(){
        // Show the products page
        Route::get('/', function(){ return view('pages.basket');});
        // ...
    }
);

Route::prefix('settings')->middleware('auth')->name('settings')->group(
    function(){
        Route::get('/', function(){ return view('pages.settings');});
        // ...
    }
);

Route::prefix('wishlists')->middleware('auth')->name('wishlists')->group(
    function(){
        Route::get('/', function(){ return view('pages.wishlists');});
        // ...
    }
);

/**
 * SCRAPER
 */

Route::get('/scrape', [ScrapeController::class, 'show'])->name('scrape');
Route::post('/scrape/categories', [ScrapeController::class, 'scrapeCategories'])->name('scrape.categories');
Route::post('/scrape/articles', [ScrapeController::class, 'scrapeArticles'])->name('scrape.articles');

require __DIR__.'/auth.php';
