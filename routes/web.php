<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashBoardController;
use App\Http\Controllers\BarberShopController;
use App\Http\Controllers\ReservationController;
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

Route::resource('/',BarberShopController::class);

Route::get('/services', [ReservationController::class, 'services'])->name('reservation.services');
Route::post('/mes-reservations', [ReservationController::class, 'selectServices'])->name('reservation.selection');
Route::get('/mes-reservations', [ReservationController::class, 'index'])->name('reservation.index');
Route::get('/reservation', fn () => redirect()->route('reservation.index'))->name('reservation.create');
Route::post('/reservation', [ReservationController::class, 'store'])->name('reservation.store');