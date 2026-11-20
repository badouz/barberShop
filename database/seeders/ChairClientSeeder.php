<?php

namespace Database\Seeders;

use App\Models\BarberMan;
use App\Models\BarberShop;
use App\Models\BarberShopsImage;
use App\Models\Reservation;
use App\Models\Service;
use App\Models\ServicesImage;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class ChairClientSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Create or get James Wilson (Client from Capture 07)
        $client = User::updateOrCreate(
            ['email' => 'james.wilson@email.com'],
            [
                'name' => 'James Wilson',
                'password' => Hash::make('password'),
                'phone' => '+1 (555) 234-5678',
                'city' => 'New York',
                'address' => '45 Crosby St, SoHo',
                'zip' => '10012',
                'created_at' => Carbon::create(2026, 10, 15, 10, 0, 0),
            ]
        );

        // 2. Create or get Shop Owner
        $owner = User::firstOrCreate(
            ['email' => 'owner@themoderngentleman.com'],
            [
                'name' => 'The Modern Gentleman Owner',
                'password' => Hash::make('password'),
                'phone' => '+1 (555) 987-6543',
                'city' => 'New York',
                'address' => '142 Spring St, SoHo',
                'zip' => '10012',
            ]
        );

        // 3. Featured Shop: The Modern Gentleman (Captures 01, 02)
        $shop1 = BarberShop::updateOrCreate(
            ['name' => 'The Modern Gentleman'],
            [
                'address' => '142 Spring St, SoHo',
                'city' => 'SoHo, NY',
                'zip' => '10012',
                'latitude' => 40.7243,
                'Longitude' => -74.0018,
                'user_id' => $owner->id,
            ]
        );

        BarberShopsImage::updateOrCreate(
            ['barbershop_id' => $shop1->id, 'is_primary' => true],
            ['path' => 'https://images.unsplash.com/photo-1585747860715-2ba37e788b70?w=1200&q=85&auto=format&fit=crop']
        );

        // Barbers for Shop 1
        $barberAlex = BarberMan::updateOrCreate(
            ['name' => 'Alex Morgan', 'barbershop_id' => $shop1->id]
        );

        $barberMarcus = BarberMan::updateOrCreate(
            ['name' => 'Marcus Lee', 'barbershop_id' => $shop1->id]
        );

        // Services for Shop 1
        $svcHaircut = Service::updateOrCreate(
            ['name' => 'Basic Haircut', 'barbershop_id' => $shop1->id],
            [
                'description' => 'Precision cut & styled finish',
                'price' => 30,
                'duration' => 30,
            ]
        );

        $svcHaircutBeard = Service::updateOrCreate(
            ['name' => 'Haircut + Beard', 'barbershop_id' => $shop1->id],
            [
                'description' => 'Every detail, taken care of. Precision haircut & warm towel beard sculpt',
                'price' => 45,
                'duration' => 45,
            ]
        );

        $svcBeard = Service::updateOrCreate(
            ['name' => 'Beard Sculpt & Trim', 'barbershop_id' => $shop1->id],
            [
                'description' => 'Razor line-up, beard shaping and conditioning oil treatment',
                'price' => 25,
                'duration' => 20,
            ]
        );

        $svcFade = Service::updateOrCreate(
            ['name' => 'Precision Fade', 'barbershop_id' => $shop1->id],
            [
                'description' => 'Low, mid or high skin fade tailored to your head shape',
                'price' => 35,
                'duration' => 35,
            ]
        );

        // 4. Shop 2: Northside Barber Co.
        $shop2 = BarberShop::updateOrCreate(
            ['name' => 'Northside Barber Co.'],
            [
                'address' => '214 Bedford Ave',
                'city' => 'Williamsburg',
                'zip' => '11211',
                'latitude' => 40.7163,
                'Longitude' => -73.9586,
                'user_id' => $owner->id,
            ]
        );

        BarberShopsImage::updateOrCreate(
            ['barbershop_id' => $shop2->id, 'is_primary' => true],
            ['path' => 'https://images.unsplash.com/photo-1622286342621-4bd786c2447c?w=900&q=85&auto=format&fit=crop']
        );

        $barberDavid = BarberMan::updateOrCreate(
            ['name' => 'David Miller', 'barbershop_id' => $shop2->id]
        );

        Service::updateOrCreate(
            ['name' => 'Signature Cut', 'barbershop_id' => $shop2->id],
            [
                'description' => 'Classic gentleman cut with neck shave',
                'price' => 28,
                'duration' => 30,
            ]
        );

        // 5. Shop 3: Crown & Blade Studio
        $shop3 = BarberShop::updateOrCreate(
            ['name' => 'Crown & Blade Studio'],
            [
                'address' => '58 W 8th St',
                'city' => 'Greenwich',
                'zip' => '10011',
                'latitude' => 40.7328,
                'Longitude' => -73.9982,
                'user_id' => $owner->id,
            ]
        );

        BarberShopsImage::updateOrCreate(
            ['barbershop_id' => $shop3->id, 'is_primary' => true],
            ['path' => 'https://images.unsplash.com/photo-1621605815971-fbc98d665033?w=900&q=85&auto=format&fit=crop']
        );

        $barberJames = BarberMan::updateOrCreate(
            ['name' => 'James Thorne', 'barbershop_id' => $shop3->id]
        );

        Service::updateOrCreate(
            ['name' => 'Executive Cut', 'barbershop_id' => $shop3->id],
            [
                'description' => 'Full grooming experience with styling & massage',
                'price' => 35,
                'duration' => 40,
            ]
        );

        // 6. Shop 4: East Side Traditional Barbers
        $shop4 = BarberShop::updateOrCreate(
            ['name' => 'East Side Traditional Barbers'],
            [
                'address' => '112 Orchard St',
                'city' => 'Lower East',
                'zip' => '10002',
                'latitude' => 40.7188,
                'Longitude' => -73.9899,
                'user_id' => $owner->id,
            ]
        );

        BarberShopsImage::updateOrCreate(
            ['barbershop_id' => $shop4->id, 'is_primary' => true],
            ['path' => 'https://images.unsplash.com/photo-1512690459411-b9245aed614b?w=900&q=85&auto=format&fit=crop']
        );

        BarberMan::updateOrCreate(
            ['name' => 'Frankie Rossi', 'barbershop_id' => $shop4->id]
        );

        Service::updateOrCreate(
            ['name' => 'Classic Cut', 'barbershop_id' => $shop4->id],
            [
                'description' => 'Traditional barber cut with pomade finish',
                'price' => 25,
                'duration' => 30,
            ]
        );

        // 7. Demo Bookings for James Wilson (Matching Captures 04, 05, 06)
        // Upcoming appointment in ~1 day and 3 hours (matches "1 DAYS : 3 HOURS : 42 MINUTES")
        $upcomingDate = now()->addDays(1)->format('Y-m-d');
        $upcomingReservation = Reservation::updateOrCreate(
            [
                'user_id' => $client->id,
                'dateReservation' => $upcomingDate,
                'time' => '15:00',
            ],
            [
                'barbermans_id' => $barberAlex->id,
                'name' => $client->name,
                'phone' => $client->phone,
                'price' => 45,
                'status' => 'confirmed',
            ]
        );
        $upcomingReservation->services()->syncWithoutDetaching([$svcHaircutBeard->id]);

        // Past appointment (5 days ago)
        $pastDate = now()->subDays(5)->format('Y-m-d');
        $pastReservation = Reservation::updateOrCreate(
            [
                'user_id' => $client->id,
                'dateReservation' => $pastDate,
                'time' => '11:00',
            ],
            [
                'barbermans_id' => $barberAlex->id,
                'name' => $client->name,
                'phone' => $client->phone,
                'price' => 30,
                'status' => 'completed',
            ]
        );
        $pastReservation->services()->syncWithoutDetaching([$svcHaircut->id]);
    }
}
