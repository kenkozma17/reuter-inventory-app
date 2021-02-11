<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProductsController;
use \App\Http\Controllers\CategoriesController;

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
Route::middleware('auth')->group(function(){
    Route::get('/', [HomeController::class, 'index']);

    Route::prefix('admin')->group(function(){
        // Products
        Route::get('/products/all', [ProductsController::class, 'getProducts']);
        Route::resource('products', ProductsController::class);

        // Categories
        Route::get('/categories/all', [CategoriesController::class, 'getCategories']);
        Route::resource('categories', CategoriesController::class);
    });
});

require __DIR__.'/auth.php';
