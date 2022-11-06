<?php

use App\Http\Controllers\LinkController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Auth::routes();

Route::get('/',[LinkController::class,'create'])->name('url.create');
Route::get('/list',[LinkController::class,'index'])->name('url.index')->middleware('isAdmin');
Route::get('/{id}/edit',[LinkController::class,'edit'] )->name('url.edit');
Route::post('/store',[LinkController::class,'store'])->name('url.store');
Route::put('/{id}',[LinkController::class,'update'])->name('url.update');
Route::delete('/{id}',[LinkController::class,'destroy'])->name('url.destroy');
Route::get('short/{code}',[LinkController::class,'redirect'])->name('url.redirect');
