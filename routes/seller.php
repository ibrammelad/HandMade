<?php

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


Route::post('register' , [\App\Http\Controllers\api\Seller\LoginController::class , 'Register']);
Route::post('login' , [\App\Http\Controllers\api\Seller\LoginController::class ,'login']);


Route::get('sellers' , [\App\Http\Controllers\api\Seller\SellerController::class , 'index']);
Route::get('sellers/{seller}' , [\App\Http\Controllers\api\Seller\SellerController::class , 'show'])->name('sellers.show');



Route::group(['middleware'=>'auth:sanctum'] , function () {
    Route::patch('sellers/{seller}' , [\App\Http\Controllers\api\Seller\SellerController::class, 'update']);
    Route::get('logout', [\App\Http\Controllers\api\Seller\LoginController::class, 'logout']);
    Route::apiResource('products' , \App\Http\Controllers\api\Product\ProductController::class)->except('show');
    Route::get('me', [\App\Http\Controllers\api\Seller\SellerController::class, 'me']);
    Route::patch('seller/changeStatus', [\App\Http\Controllers\api\Seller\SellerController::class, 'changeStatus']);
});


