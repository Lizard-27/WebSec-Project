<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\UserController;

Route::post('users',  [UserController::class, 'store']);   // register
Route::post('login',  [UserController::class, 'login']);   // login
Route::post('logout', [UserController::class, 'logout'])
     ->middleware('auth:api');


Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
