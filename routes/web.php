<?php

use App\Http\Controllers\Admin\ScrapeController;
use App\Http\Controllers\ArticleController;
use App\Http\Controllers\ArticleWishlistController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\FavoriteController;
use App\Http\Controllers\GuestController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\StorageController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\WebhookController;
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
        // Route::get('/filter', [ArticleController::class, 'articlesByFilters'])->name('.filters');
        Route::get('/search', [ArticleController::class, 'search'])->name('.search');
        Route::get('/detail/{id}', [ArticleController::class, 'showProductDetail'])->name('.detail');
        Route::get('/{shop}', [ArticleController::class, 'articlesByShop'])->name('.byShop');
    }
);

Route::prefix('favorites')->middleware('auth')->name('favorites')->group(
    function(){
        Route::get('/', [FavoriteController::class, 'show']);
        Route::get('/add/{article_id}', [FavoriteController::class, 'add'])->name('.add');
        Route::get('/delete/{article_id}/{favorite_id}', [FavoriteController::class, 'delete'])->name('.delete');
    }
);

Route::prefix('settings')->middleware('auth')->name('settings')->group(
    function(){
        Route::get('/', [UserController::class, 'show']);
        Route::get('/edit', [UserController::class, 'show'])->name('.edit');
        Route::post('/edit', [UserController::class, 'updateUser'])->name('.update');
    }
);

Route::prefix('guest')->middleware(['guest'])->name('guest')->group(
    function(){
        Route::get('/{slug}', [GuestController::class, 'show']);
        Route::post('/{slug}', [GuestController::class, 'checkPassword'])->name('.check');
        Route::get('/{slug}/register', [GuestController::class, 'showRegister'])->name('.register');
        Route::post('/{slug}/register', [GuestController::class, 'registerGuest'])->name('.register.create');
        Route::get('/{slug}/wishlist', [GuestController::class, 'getWishlist'])->name('.wishlist');
        Route::post('/{slug}/wishlist', [GuestController::class, 'addProductToBasket'])->name('.addToBasket');
        Route::post('/{slug}/basket', [GuestController::class, 'removeItemfromBasket'])->name('.removeFromBasket');
        Route::get('/{slug}/basket', [GuestController::class, 'showProductsInBasket'])->name('.showBasket');
        Route::get('/{slug}/checkout', [PaymentController::class, 'checkout'])->name('.checkout');
        Route::get('/{slug}/checkout/succes', [PaymentController::class, 'success'])->name('.chekout.success');
    }
);

Route::prefix('wishlists')->middleware('auth')->name('wishlists')->group(
    function(){
        Route::get('/', [WishlistController::class, 'show']);
        Route::get('/new', [WishlistController::class, 'newWishlist'])->name('.new');
        Route::post('/new', [WishlistController::class, 'createWishlist'])->name('.create');
        Route::get('/edit/{wishlist_id}', [WishlistController::class, 'editWishlist'])->name('.edit-wishlist');
        Route::get('/add/{article_id}', [ArticleWishlistController::class, 'add'])->name('.add-product');
        Route::get('/delete/product/{article_id}', [ArticleWishlistController::class, 'deleteProductFromWishlist'])->name('.delete-product');
        Route::get('/delete/{wishlist_id}', [ArticleWishlistController::class, 'deleteWishlist'])->name('.delete-wishlist');
        Route::post('/create', [ArticleWishlistController::class, 'store'])->name('.store-product');
        Route::get('/detail/{id}', [ArticleWishlistController::class, 'showWishlistDetail'])->name('.detail');
    }
);

/**
 * Webhooks
 */

 Route::post('/webhooks/mollie', [WebhookController::class, 'handle'])->name('webhooks.mollie');

/**
 * SCRAPER
 */
Route::get('admin', [ScrapeController::class, 'showDashboard'])->middleware('auth')->name('admin.dashboard');
Route::get('admin/scrape', [ScrapeController::class, 'show'])->middleware('auth')->name('scrape');
Route::post('admin/scrape/categories', [ScrapeController::class, 'scrapeCategories'])->middleware('auth')->name('scrape.categories');
Route::post('admin/scrape/articles', [ScrapeController::class, 'scrapeArticles'])->middleware('auth')->name('scrape.articles');
Route::get('admin/products', [ScrapeController::class, 'showProducts'])->name('admin.products');
Route::post('admin/products', [ScrapeController::class, 'deleteProduct'])->name('admin.delete-product');

require __DIR__.'/auth.php';
