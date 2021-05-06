<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


Route::post('register' , [\App\Http\Controllers\api\User\LoginController::class , 'Register']);
Route::post('login' , [\App\Http\Controllers\api\User\LoginController::class ,'login']);


Route::apiResource('users' , \App\Http\Controllers\api\User\UserController::class)->except('store');
Route::apiResource('categories' , App\Http\Controllers\api\Category\CategoryController::class)->only('index' , 'show');
Route::get('categories/{category}/products' , [App\Http\Controllers\api\Product\CategoryProductsController::class , 'categoryProducts']);
Route::get('timeline' , [App\Http\Controllers\api\Product\ProductSellerController::class , 'timeline']);
Route::get('/productsForUsers' , [App\Http\Controllers\api\Product\ProductController::class,'productsUsers']);
Route::get('/categories/{category}/sellers' , [App\Http\Controllers\api\Category\CategorySellerController::class,'categorySellers']);

Route::group(['middleware'=>'auth:sanctum'] , function () {
    Route::get('logout', [\App\Http\Controllers\api\User\LoginController::class, 'logout']);

    Route::get('me', [\App\Http\Controllers\api\User\UserController::class, 'me']);

});

