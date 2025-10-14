<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MainController;
use App\Http\Controllers\AuthController;
use App\Http\Middleware\CheckIsLogged;
use App\Http\Middleware\CheckIsNotLogged;

//app routes - user not logged
Route::middleware([CheckIsNotLogged::class])->group(function(){
    Route::get('/login',[AuthController::class,'login']);
    Route::post('/loginSubmit',[AuthController::class,'loginSubmit']);
});
//app routes - user logged

Route::middleware([CheckIsLogged::class])->group(function(){
    Route::get('/',[MainController::class,'index'])->name('home');
    Route::get('/newNote',[MainController::class,'newNote'])->name('new');
    Route::get('/logout',[AuthController::class,'logout'])->name('logout');
});





