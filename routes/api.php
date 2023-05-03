<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Seller\ProductController as SellerProductController;
use App\Http\Controllers\Seller\CategoryController as SellerCategoryController;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::middleware('api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group(['middleware' => 'api'], function ($router) {
    Route::group(['prefix' => 'auth'], function () {
        Route::post('register', [AuthController::class, 'register'])->name('register');
        Route::get('user', [AuthController::class, 'user'])->name('user');
        Route::post('login', [AuthController::class, 'login']);
        Route::post('logout', [AuthController::class, 'logout']);
        Route::post('refresh', [AuthController::class, 'refresh']);
        Route::post('me', [AuthController::class, 'me']);
    });
    Route::group(['prefix' => 'seller', 'middleware' => ['auth:api', 'role:seller']], function () {
        Route::get('categories', [SellerCategoryController::class, 'index']);
        Route::post('categories', [SellerCategoryController::class, 'store']);
        Route::get('categories/{id}', [SellerCategoryController::class, 'show']);
        Route::patch('categories/{id}/update', [SellerCategoryController::class, 'update']);
        Route::delete('categories/{id}', [SellerCategoryController::class, 'destroy']);
        Route::get('product', [SellerProductController::class, 'index']);
        Route::post('product', [SellerProductController::class, 'store']);
        Route::get('product/{id}', [SellerProductController::class, 'show']);
        Route::patch('product/{id}/update', [SellerProductController::class, 'update']);
        Route::delete('product/{id}', [SellerProductController::class, 'destroy']);
    });
    Route::group(['prefix' => 'buyer', 'middleware' => ['role:buyer']], function () {
        // Route::get('categories', [CategoryController::class, 'index']);
        // Route::post('categories', [CategoryController::class, 'store']);
        // Route::get('categories/{id}', [CategoryController::class, 'show']);
        // Route::patch('categories/{id}/update', [CategoryController::class, 'update']);
        // Route::delete('categories/{id}', [CategoryController::class, 'destroy']);
        // Route::get('product', [ProductController::class, 'index']);
        // Route::post('product', [ProductController::class, 'store']);
        // Route::get('product/{id}', [ProductController::class, 'show']);
        // Route::patch('product/{id}/update', [ProductController::class, 'update']);
        // Route::delete('product/{id}', [ProductController::class, 'destroy']);
    });
});