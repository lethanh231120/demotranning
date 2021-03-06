<?php

use App\Http\Controllers\Api\CustomerController;
use App\Http\Controllers\Api\ProductController;
use App\Http\Controllers\Api\OrderController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/login', [CustomerController::class, 'login']);
Route::middleware('auth:api')->prefix('auth')->group(function () {
    Route::get('/me', [CustomerController::class, 'getMe']);
    Route::put('/update', [CustomerController::class, 'update']);
    Route::get('/products', [ProductController::class, 'index']);
    Route::get('/products/{id}/show', [ProductController::class, 'show']);
    Route::post('/buy/products', [OrderController::class, 'index']);
});
