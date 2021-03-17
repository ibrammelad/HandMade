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

Route::apiResource('sellers' , \App\Http\Controllers\api\Seller\SellerController::class);

Route::group(['middleware'=>'auth:sanctum'] , function () {
    Route::get('logout', [\App\Http\Controllers\api\Seller\LoginController::class, 'logout']);
});


