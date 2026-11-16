<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashBoardController;
// guest route 
Route::get('/login',[AuthController::class,"auth"])->name("login");
Route::post('/login',[AuthController::class,"authenticate"])->name("authenticate");
Route::get('/register',[AuthController::class,"showRegisterForm"])->name("showRegisterForm");
Route::post('/register',[AuthController::class,"register"])->name("register");

// auth route
Route::get('/dashboard',[DashBoardController::class,"index"])
->name("dashboard")
->middleware("auth");

Route::post('/logout',[AuthController::class,"logout"])
->name("logout")
->middleware("auth");
