<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\ProductController;
use App\Http\Controllers\Api\CategoryController;
//admin route
// Route::get('users/{user:name}', [UserController::class, 'show']); search by specific attribute
Route::prefix('auth')->group(function(){

    Route::post('login' ,[AuthController::class, 'login']);       
    Route::post('register' ,[AuthController::class, 'register']);
    Route::middleware('auth:api')->prefix('user')->group(function(){
        Route::get('me', [AuthController::class, 'me']);          
        Route::post('refresh', [AuthController::class, 'refresh']);
        Route::post('logout', [AuthController::class, 'logout']);   
    });
});
// Route::apiResource('users', UserController::class);

Route::middleware(['auth:api', 'admin'])->prefix('admin')->group(function(){

   Route::apiResource('users', UserController::class);
});

Route::apiResource('products', ProductController::class);

Route::apiResource('categories', CategoryController::class);