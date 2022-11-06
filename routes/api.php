<?php

use App\Http\Controllers\Api\LinkController;
use App\Http\Controllers\Api\LoginController;
use Illuminate\Support\Facades\Route;

Route::post('login',[LoginController::class,'login']);

Route::middleware('auth:api')->group(function () {
    Route::controller(LinkController::class)->group(function () {
        Route::get('/list','index');
        Route::post('/store','store');
    });
});
