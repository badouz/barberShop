<?php

use App\Http\Controllers\AdminReservationController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BarberManController;
use App\Http\Controllers\BarberShopController;
use App\Http\Controllers\BarberShopsImagesController;
use App\Http\Controllers\DashBoardController;
use App\Http\Controllers\ReservationController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

// Public entry point – CHAIR Home.
Route::get('/', [ReservationController::class, 'home'])->name('index');

// Public CHAIR reservation flow (Guest or Authenticated).
Route::get('/reservation/services', [ReservationController::class, 'services'])
    ->name('reservation.services');
Route::post('/mes-reservations', [ReservationController::class, 'selectServices'])
    ->name('reservation.selection');
Route::get('/mes-reservations', [ReservationController::class, 'index'])
    ->name('reservation.index');
Route::get('/reservation', fn () => redirect()->route('reservation.services'))
    ->name('reservation.create');
Route::post('/reservation', [ReservationController::class, 'store'])
    ->name('reservation.store');
Route::get('/reservation/confirmation/{reservation}', [ReservationController::class, 'confirmation'])
    ->name('reservation.confirmation');

// Authentication routes for guests.
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'auth'])->name('login');
    Route::post('/login', [AuthController::class, 'authenticate'])->name('authenticate');
    Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('showRegisterForm');
    Route::post('/register', [AuthController::class, 'register'])->name('register');
});

// Routes available to authenticated users (Purple Admin Dashboard).
Route::middleware('auth')->group(function () {
    // Dashboard and session.
    Route::get('/dashboard', [DashBoardController::class, 'index'])->name('dashboard');
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    // Admin Reservations Management.
    Route::get('/admin/reservations', [AdminReservationController::class, 'index'])
        ->name('admin.reservations.index');
    Route::patch('/admin/reservations/{reservation}/status', [AdminReservationController::class, 'updateStatus'])
        ->name('admin.reservations.status');
    Route::delete('/admin/reservations/{reservation}', [AdminReservationController::class, 'destroy'])
        ->name('admin.reservations.destroy');

    // Management resources.
    Route::resource('/barbermen', BarberManController::class);
    Route::resource('/barbershop', BarberShopController::class);
    Route::resource('/services', ServiceController::class);
    Route::resource('/users', UserController::class);

    // Service image management.
    Route::delete('/services/images/{image}', [ServiceController::class, 'deleteImage'])
        ->name('services.images.destroy');
    Route::patch('/services/images/{image}/primary', [ServiceController::class, 'setPrimaryImage'])
        ->name('services.images.primary');

    // Barber shop image management.
    Route::resource('/barbershop-images', BarberShopsImagesController::class)
        ->parameters(['barbershop-images' => 'barberShopsImage'])
        ->except(['update']);
    Route::post('/barbershop-images/{barberShopsImage}', [BarberShopsImagesController::class, 'update'])
        ->name('barbershop-images.update');
});
