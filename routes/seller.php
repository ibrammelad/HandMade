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


Route::post('register' , [\App\Http\Controllers\Seller\LoginController::class , 'Register']);
Route::post('login' , [\App\Http\Controllers\Seller\LoginController::class ,'login']);

Route::group(['middleware'=>'auth:sanctum'] , function () {
    Route::get('logout', [\App\Http\Controllers\Seller\LoginController::class, 'logout']);
});

//Route::group(['middleware'=>'auth:sanctum'] , function (){
    Route::apiResource('categories', \App\Http\Controllers\Seller\CategoryController::class)->only('index','store', 'update', 'destroy');
//});

