<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProductsController;
use \App\Http\Controllers\CategoriesController;
use \App\Http\Controllers\TransactionController;

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
    Route::get('/', [HomeController::class, 'index'])->name('home');

    Route::prefix('admin')->group(function(){
        // Products
        Route::get('/products/all', [ProductsController::class, 'getProducts']);
        Route::resource('products', ProductsController::class);

        // Categories
        Route::get('/categories/all', [CategoriesController::class, 'getCategories']);
        Route::resource('categories', CategoriesController::class);

        // Transactions
        Route::get('/transactions/all', [TransactionController::class, 'getTransactions']);
        Route::get('/transactions', [TransactionController::class, 'index'])->name('transactions.index');
        Route::get('/transactions/add/{productId}', [TransactionController::class, 'createTransaction']);
        Route::post('/transactions/store/{productId}', [TransactionController::class, 'store'])->name('transactions.store');
        Route::get('/transactions/show/{transactionId}', [TransactionController::class, 'show'])->name('transactions.show');
//        Route::resource('transactions',TransactionController::class);
    });
});

require __DIR__.'/auth.php';
