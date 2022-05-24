<?php

use App\Http\Controllers\Admin\ScrapeController;
use App\Http\Controllers\ArticleController;
use App\Http\Controllers\ArticleWishlistController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\FavoriteController;
use App\Http\Controllers\StorageController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\WishlistController;
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
})->name('landing');

Route::get('/dashboard', [DashboardController::class, 'show'])->middleware(['auth'])->name('dashboard');

Route::prefix('products')->middleware('auth')->name('products')->group(
    function(){
        // Show the products page
        Route::get('/', [ArticleController::class, 'show']);
        Route::get('/filter', [ArticleController::class, 'ArticlesByFilters'])->name('.filters');
        Route::get('/detail/{id}', [ArticleController::class, 'showProductDetail'])->name('.detail');
    }
);

Route::prefix('favorites')->middleware('auth')->name('favorites')->group(
    function(){
        // Show the products page
        Route::get('/', [FavoriteController::class, 'show']);
        Route::get('/add/{article_id}', [FavoriteController::class, 'add'])->name('.add');
        Route::get('/delete/{article_id}/{favorite_id}', [FavoriteController::class, 'delete'])->name('.delete');
    }
);

Route::prefix('settings')->middleware('auth')->name('settings')->group(
    function(){
        Route::get('/', [UserController::class, 'show']);
        Route::get('/delete', [UserController::class, 'deleteUser'])->name('.delete');
        Route::get('/edit', [UserController::class, 'show'])->name('.edit');
        Route::post('/edit', [UserController::class, 'updateUser'])->name('.update');
    }
);

Route::prefix('wishlists')->middleware('auth')->name('wishlists')->group(
    function(){
        Route::get('/', [WishlistController::class, 'show']);
        Route::get('/new', [WishlistController::class, 'newWishlist'])->name('.new');
        Route::post('/new', [WishlistController::class, 'createWishlist'])->name('.create');
        Route::get('/add/{article_id}', [ArticleWishlistController::class, 'add'])->name('.addProduct');
        Route::post('/create', [ArticleWishlistController::class, 'store'])->name('.storeProduct');
    }
);

/**
 * SCRAPER
 */

Route::get('/scrape', [ScrapeController::class, 'show'])->name('scrape');
Route::post('/scrape/categories', [ScrapeController::class, 'scrapeCategories'])->name('scrape.categories');
Route::post('/scrape/articles', [ScrapeController::class, 'scrapeArticles'])->name('scrape.articles');

require __DIR__.'/auth.php';
