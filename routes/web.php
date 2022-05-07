<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\MainController;
use App\Http\Controllers\CategoriesController;
use App\Http\Controllers\ProductsController;
use App\Http\Controllers\FinishesController;
use App\Http\Controllers\OrdersController;
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

Route::get('/', function (Request $request) {
    return redirect()->route(
        is_null($request->user()) ? 'login' : 'dashboard'
    );
});

Route::middleware(['auth'])->group(function () {

    Route::get('/dashboard', [MainController::class, 'dashboard'])->name('dashboard');

    Route::name('categories.')->prefix('categories')->group(function () {
        Route::get('/', [CategoriesController::class, 'view'])->name('index');
        Route::post('/', [CategoriesController::class, 'create'])->name('create');
        Route::put('/', [CategoriesController::class, 'update'])->name('update');
        Route::delete('/', [CategoriesController::class, 'delete'])->name('delete');
    });

    Route::name('products.')->prefix('products')->group(function () {
        Route::get('/', [ProductsController::class, 'view'])->name('index');
        Route::post('/', [ProductsController::class, 'create'])->name('create');
        Route::put('/', [ProductsController::class, 'update'])->name('update');
        Route::delete('/', [ProductsController::class, 'delete'])->name('delete');
        
        Route::post('/promo', [ProductsController::class, 'create_promo'])->name('create.promo');
        Route::delete('/promo', [ProductsController::class, 'delete_promo'])->name('delete.promo');
    });

    Route::name('finishes.')->prefix('finishes')->group(function () {
        Route::get('/', [FinishesController::class, 'view'])->name('index');
        Route::post('/', [FinishesController::class, 'create'])->name('create');
        Route::put('/', [FinishesController::class, 'update'])->name('update');
        Route::delete('/', [FinishesController::class, 'delete'])->name('delete');
    });

    Route::name('orders.')->prefix('orders')->group(function () {
        Route::get('/', [OrdersController::class, 'view'])->name('index');
        Route::patch('/', [OrdersController::class, 'patch'])->name('patch');
        Route::get('/{id}', [OrdersController::class, 'details'])->name('details');
    });

});

require __DIR__.'/auth.php';

