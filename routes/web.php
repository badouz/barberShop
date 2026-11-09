<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;

Route::get('/login',[AuthController::class,"auth"])->name("login");
Route::post('/login',[AuthController::class,"authenticate"])->name("authenticate");
Route::get('/register',[AuthController::class,"showRegisterForm"])->name("showRegisterForm");
Route::post('/register',[AuthController::class,"register"])->name("register");
