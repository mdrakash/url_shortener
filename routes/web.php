<?php

use App\Http\Controllers\LinkController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Auth::routes();

Route::controller(LinkController::class)->group(function () {
    Route::get('/','create')->name('url.create');
    Route::get('/list','index')->name('url.index')->middleware('isUser');
    Route::get('/{id}/edit','edit' )->name('url.edit');
    Route::post('/store','store')->name('url.store');
    Route::put('/{id}','update')->name('url.update');
    Route::delete('/{id}','destroy')->name('url.destroy');
    Route::get('short/{code}','redirect')->name('url.redirect');
});