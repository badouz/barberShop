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
Route::get('/setup-test-accounts', function () {
    $password = bcrypt('12345678');

    // 1. Admin
    $admin = \App\Models\User::firstOrNew(['email' => 'moustacharahmad@gmail.com']);
    $admin->name = $admin->name ?: 'Ahmed Admin';
    $admin->password = $password;
    $admin->role = \App\Models\User::ADMIN;
    $admin->save();

    // 2. Shop X (Demo)
    $userX = \App\Models\User::firstOrNew(['email' => 'demo@barberchop.test']);
    $userX->name = $userX->name ?: 'BarberChop Demo';
    $userX->password = $password;
    $userX->role = \App\Models\User::BARBER_SHOP;
    $userX->save();

    $shopX = \App\Models\BarberShop::firstOrCreate(
        ['name' => 'BarberChop Centre'],
        [
            'city' => 'Ben Guerir',
            'address' => 'Avenue Mohammed VI',
            'zip' => '43150',
            'latitude' => 32.2345,
            'Longitude' => -7.9543,
            'user_id' => $userX->id,
        ]
    );
    $shopX->user_id = $userX->id;
    $shopX->save();

    // 3. Shop Y (ahmed@gmail.com)
    $userY = \App\Models\User::firstOrNew(['email' => 'ahmed@gmail.com']);
    $userY->name = $userY->name ?: 'Picasso Shop Y';
    $userY->password = $password;
    $userY->role = \App\Models\User::BARBER_SHOP;
    $userY->save();

    $shopY = \App\Models\BarberShop::firstOrCreate(
        ['name' => 'BarberShop Y (Elite)'],
        [
            'city' => 'Casablanca',
            'address' => 'Boulevard d Anfa',
            'zip' => '20000',
            'latitude' => 33.5898,
            'Longitude' => -7.6038,
            'user_id' => $userY->id,
        ]
    );
    $shopY->user_id = $userY->id;
    $shopY->save();

    return redirect()->route('login')->with('success', 'Les mots de passe ont été réinitialisés à : 12345678');
})->name('setup.test.accounts');

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
    Route::get('/barbershop/{id?}/service', [ServiceController::class,'index'])->name("bareberservice");
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
    Route::resource('/shop-images', BarberShopsImagesController::class)
        ->parameters(['shop-images' => 'barberShopsImage'])
        ->except(['update']);
    Route::post('/shop-images/{barberShopsImage}', [BarberShopsImagesController::class, 'update'])
        ->name('shop-images.update');
});
