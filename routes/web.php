<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\BarberManController;
use App\Http\Controllers\BarberShopController;
use App\Http\Controllers\BarberShopsImagesController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\DashBoardController;
use App\Http\Controllers\ReservationController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

// Public entry point – landing page (no auth required).
Route::get('/', function () {
    return view('welcome');
})->name('index');

// ─── CHAIR Client Area ───────────────────────────────────────────────────────
Route::prefix('client')->name('client.')->middleware('auth')->group(function () {
    Route::get('/',                                              [ClientController::class, 'home'])               ->name('home');
    Route::get('/shop/{shop}',                                   [ClientController::class, 'shop'])               ->name('shop');
    Route::get('/reserve/{shop}',                                [ClientController::class, 'reserve'])            ->name('reserve');
    Route::post('/reserve/{shop}',                               [ClientController::class, 'storeReservation'])   ->name('store');
    Route::get('/booking-success/{reservation}',                 [ClientController::class, 'bookingSuccess'])     ->name('booking-success');
    Route::get('/bookings',                                      [ClientController::class, 'myBookings'])         ->name('bookings');
    Route::get('/bookings/{reservation}',                        [ClientController::class, 'reservationDetails']) ->name('booking-detail');
    Route::patch('/bookings/{reservation}/cancel',               [ClientController::class, 'cancelReservation']) ->name('cancel');
    Route::patch('/bookings/{reservation}/reschedule',           [ClientController::class, 'reschedule'])         ->name('reschedule');
    Route::get('/settings',                                      [ClientController::class, 'settings'])           ->name('settings');
    Route::patch('/settings',                                    [ClientController::class, 'updateSettings'])     ->name('settings.update');
});

// Public service catalog used by the landing page and reservation flow.
Route::get('/reservation/services', [ReservationController::class, 'services'])
    ->name('reservation.services');
Route::post('/mes-reservations', [ReservationController::class, 'selectServices'])
    ->name('reservation.selection');
Route::get('/mes-reservations', [ReservationController::class, 'index'])->name('reservation.index');
Route::get('/reservation', fn () => redirect()->route('reservation.index'))
    ->name('reservation.create');
Route::post('/reservation', [ReservationController::class, 'store'])->name('reservation.store');

// Authentication routes for guests.
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'auth'])->name('login');
    Route::post('/login', [AuthController::class, 'authenticate'])->name('authenticate');
    Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('showRegisterForm');
    Route::post('/register', [AuthController::class, 'register'])->name('register');
});

// Routes available to authenticated users.
Route::middleware('auth')->group(function () {
    // Dashboard and session.
    Route::get('/dashboard', [DashBoardController::class, 'index'])->name('dashboard');
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

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
