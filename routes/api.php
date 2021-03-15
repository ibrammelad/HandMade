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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
Route::post('register' , [\App\Http\Controllers\User\LoginController::class , 'Register']);
Route::post('login' , [\App\Http\Controllers\User\LoginController::class ,'login']);

Route::group(['middleware'=>'auth:sanctum'] , function () {
    Route::get('logout', [\App\Http\Controllers\User\LoginController::class, 'logout']);
});

Route::apiResource('categories' , \App\Http\Controllers\User\CategoryController::class)->only('index' , 'show');
