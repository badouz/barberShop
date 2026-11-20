<?php

namespace Tests\Feature;

use App\Models\BarberMan;
use App\Models\BarberShop;
use App\Models\Reservation;
use App\Models\Service;
use App\Models\ServicesImage;
use App\Models\User;
use Database\Seeders\BarberShopServicesSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ReservationFlowTest extends TestCase
{
    use RefreshDatabase;

    public function test_demo_seeder_creates_all_seven_services_with_details_and_images_idempotently(): void
    {
        $this->seed(BarberShopServicesSeeder::class);
        $this->seed(BarberShopServicesSeeder::class);

        $this->assertSame(7, Service::count());
        $this->assertSame(7, ServicesImage::count());
        $this->assertDatabaseHas('services', [
            'name' => 'Coupe Homme',
            'description' => 'Une coupe nette et personnalisée, du style classique au dégradé moderne.',
            'price' => 50,
            'duration' => 30,
        ]);
        $this->assertDatabaseHas('servicesimages', [
            'path' => 'https://images.unsplash.com/photo-1503951914875-452162b0f3f1?w=900&q=85',
            'is_primary' => true,
        ]);
    }

    public function test_customer_can_select_services_review_them_and_send_a_reservation(): void
    {
        $owner = User::factory()->create();
        $shop = BarberShop::create([
            'name' => 'BarberChop Centre',
            'city' => 'Ben Guerir',
            'user_id' => $owner->id,
        ]);
        $service = Service::create([
            'name' => 'Coupe Homme',
            'price' => 50,
            'duration' => 30,
            'barbershop_id' => $shop->id,
        ]);
        $extraService = Service::create([
            'name' => 'Taille de barbe',
            'price' => 30,
            'duration' => 20,
            'barbershop_id' => $shop->id,
        ]);
        $barber = BarberMan::create([
            'name' => 'Youssef',
            'barbershop_id' => $shop->id,
        ]);

        $this->get(route('reservation.services'))
            ->assertOk()
            ->assertSee('Coupe Homme')
            ->assertSee('50.00 DH')
            ->assertSee('images.unsplash.com');

        $this->post(route('reservation.selection'), [
            'service_ids' => [$service->id, $extraService->id],
        ])->assertRedirect(route('reservation.booking'));

        $this->get(route('reservation.services'))->assertSee('checked', false);
        $this->get(route('reservation.booking'))
            ->assertOk()
            ->assertSee('Coupe Homme')
            ->assertSee('Taille de barbe')
            ->assertSee('80.00 DH')
            ->assertSee('Envoyer ma réservation');

        $date = now()->addDay()->toDateString();

        $this->post(route('reservation.store'), [
            'name' => 'Test Client',
            'phone' => '0600000000',
            'barberman_id' => $barber->id,
            'date' => $date,
            'time' => '15:00',
        ])->assertRedirect(route('reservation.booking'));

        $reservation = Reservation::firstOrFail();
        $this->assertSame('80', (string) $reservation->price);
        $this->assertSame('15:00', $reservation->time);
        $this->assertDatabaseHas('reservationsservices', [
            'reservation_id' => $reservation->id,
            'service_id' => $service->id,
        ]);
        $this->assertDatabaseHas('reservationsservices', [
            'reservation_id' => $reservation->id,
            'service_id' => $extraService->id,
        ]);
        $this->get(route('reservation.booking'))
            ->assertOk()
            ->assertSee('Votre réservation a été envoyée avec succès.');
    }

    public function test_reservation_url_shows_monthly_reservation_table(): void
    {
        $owner = User::factory()->create();
        $shop = BarberShop::create([
            'name' => 'BarberChop Centre',
            'city' => 'Ben Guerir',
            'user_id' => $owner->id,
        ]);
        $service = Service::create([
            'name' => 'Coupe Homme',
            'price' => 50,
            'duration' => 30,
            'barbershop_id' => $shop->id,
        ]);
        $barber = BarberMan::create([
            'name' => 'Youssef',
            'barbershop_id' => $shop->id,
        ]);
        $reservation = Reservation::create([
            'dateReservation' => now()->toDateString(),
            'time' => '15:00',
            'price' => 50,
            'barbermans_id' => $barber->id,
            'name' => 'Ahmed Test',
            'phone' => '0600000000',
        ]);
        $reservation->services()->attach($service->id);

        $this->get(route('reservation.index'))
            ->assertOk()
            ->assertSee('Réservations du mois')
            ->assertSee('Ahmed Test')
            ->assertSee('Youssef')
            ->assertSee('Coupe Homme')
            ->assertSee('50.00 DH');
    }
}
