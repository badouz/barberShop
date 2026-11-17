<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BarberManController;
use App\Http\Controllers\DashBoardController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\BarberShopController;
use App\Http\Controllers\BarberShopsImagesController;

// Public routes
Route::get('/', function () {
    return redirect()->route('login');
});

Route::resource('barber-men', BarberManController::class)
->middleware('auth');

Route::post('/logout',[AuthController::class,"logout"])
->name("logout")
->middleware("auth");
// Guest routes 
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, "auth"])->name("login");
    Route::post('/login', [AuthController::class, "authenticate"])->name("authenticate");
    Route::get('/register', [AuthController::class, "showRegisterForm"])->name("showRegisterForm");
    Route::post('/register', [AuthController::class, "register"])->name("register");
});

// Authenticated routes
Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [DashBoardController::class, "index"])->name("dashboard");
    Route::post('/logout', [AuthController::class, "logout"])->name("logout");

    // Services CRUD & Image management
    Route::resource('services', ServiceController::class);
    Route::delete('/services/images/{image}', [ServiceController::class, 'deleteImage'])->name('services.images.destroy');
    Route::patch('/services/images/{image}/primary', [ServiceController::class, 'setPrimaryImage'])->name('services.images.primary');
});

// BarberShop CRUD routes
Route::middleware('auth')->group(function () {
    Route::resource('/barbershop', BarberShopController::class);
});

// BarberShopsImages CRUD routes
Route::middleware('auth')->group(function () {
    Route::get('/barbershop-images',                       [BarberShopsImagesController::class, 'index'])->name('barbershop-images.index');
    Route::get('/barbershop-images/create',                [BarberShopsImagesController::class, 'create'])->name('barbershop-images.create');
    Route::post('/barbershop-images',                      [BarberShopsImagesController::class, 'store'])->name('barbershop-images.store');
    Route::get('/barbershop-images/{barberShopsImage}',    [BarberShopsImagesController::class, 'show'])->name('barbershop-images.show');
    Route::get('/barbershop-images/{barberShopsImage}/edit', [BarberShopsImagesController::class, 'edit'])->name('barbershop-images.edit');
    Route::post('/barbershop-images/{barberShopsImage}',   [BarberShopsImagesController::class, 'update'])->name('barbershop-images.update');
    Route::delete('/barbershop-images/{barberShopsImage}', [BarberShopsImagesController::class, 'destroy'])->name('barbershop-images.destroy');
});