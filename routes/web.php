<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashBoardController;
use App\Http\Controllers\ServiceController;

// Public routes
Route::get('/', function () {
    return redirect()->route('login');
});

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
