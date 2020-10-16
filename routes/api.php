<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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



Route::prefix('api')->group(function(){
    Route::middleware('auth:api')->group(function () {
        
        Route::get('profile', [UserController::class, 'index']);
        Route::post('profile/change', [UserController::class, 'store']);
        Route::post('profile/change/password', [UserController::class, 'storePass']);
        Route::get('logout', [AuthController::class, 'logout']);
    });
    Route::post('register', [AuthController::class, 'register']);
    Route::get('test', [AuthController::class, 'test']);
    Route::post('login', [AuthController::class, 'login']);
});