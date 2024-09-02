<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\AuthController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

// Route::post('/order/placeOrder',[OrderController::class, 'placeOrder']);

Route::post('register', [AuthController::class, 'register']);
Route::post('login', [AuthController::class, 'login']);

Route::group(['middleware' => 'auth:api'], function () {
    Route::post('/order/placeOrder',[OrderController::class, 'placeOrder']);

    Route::post('logout', [AuthController::class, 'logout']);
    Route::get('me', [AuthController::class, 'me']);

    Route::group(['prefix' => 'product'], function () {

        Route::get('/',[ProductController::class, 'index']);
        Route::post('/create',[ProductController::class, 'store']);
        Route::get('/{id}',[ProductController::class, 'show']);
        Route::put('/update/{id}',[ProductController::class, 'update']);
        Route::post('/delete/{id}',[ProductController::class, 'destroy']);
    
    });
    
    Route::group(['prefix' => 'order'], function () {

        Route::get('/',[OrderController::class, 'index']);
        Route::post('/create',[OrderController::class, 'store']);
        Route::get('/{order}',[OrderController::class, 'show']);
        Route::post('/placeOrder',[OrderController::class, 'placeOrder']);
        Route::post('/update/{order}',[OrderController::class, 'update']);
        Route::post('/delete/{order}',[OrderController::class, 'destroy']);
    
    });
});


Route::apiResource('users', UserController::class);
