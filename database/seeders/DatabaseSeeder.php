<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    public function run(): void 
    {
        $this->call([
            CreatesuperAdminSeeder::class,
            BarberShopSeeder::class,
            BarberManSeeder::class,
            BarberShopsImageSeeder::class,
            ServiceSeeder::class,
            ServicesImageSeeder::class,
            ReservationSeeder::class,
        ]);
    }
    // use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    // public function run(): void
    // {
    //     // User::factory(10)->create();

    //     User::firstOrCreate(
    //         ['email' => 'test@example.com'],
    //         ['name' => 'Test User', 'password' => Hash::make(Str::random(40))]
    //     );

    //     $this->call(BarberShopServicesSeeder::class);
    // }
}
