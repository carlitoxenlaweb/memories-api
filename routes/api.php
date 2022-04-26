<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\ApiController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::get('categories', [ApiController::class, 'getCategories']);
Route::get('categories/{id}', [ApiController::class, 'getCategory']);
Route::get('categories/{id}/products', [ApiController::class, 'getCategoryProducts']);

Route::get('finishes', [ApiController::class, 'getFinishes']);
Route::get('finishes/{id}', [ApiController::class, 'getFinish']);

Route::get('products', [ApiController::class, 'getProducts']);
Route::get('products/{id}', [ApiController::class, 'getProduct']);

Route::get('address', [ApiController::class, 'getAddresses']);
Route::get('address/{id}', [ApiController::class, 'getAddress']);
Route::post('address', [ApiController::class, 'newAddress']);

Route::get('cards', [ApiController::class, 'getCards']);
Route::get('cards/{id}', [ApiController::class, 'getCard']);
Route::post('cards', [ApiController::class, 'newCard']);

Route::get('orders', [ApiController::class, 'getOrders']);
Route::get('orders/{id}', [ApiController::class, 'getOrder']);
Route::post('orders', [ApiController::class, 'newOrder']);

/* Route::middleware('auth:sanctum')->group(function () {

    Route::get('/user', function (Request $request) {
        return $request->user();
    });
    
}); */
