<?php

namespace Tests\Feature;

use App\Models\BarberMan;
use App\Models\BarberShop;
use App\Models\Reservation;
use App\Models\Service;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UnifiedReservationFlowTest extends TestCase
{
    use RefreshDatabase;

    public function test_full_unified_chair_reservation_flow_as_guest(): void
    {
        // 1. Arrange: Create Admin User, Shop, Barber, and Service
        $admin = User::factory()->create([
            'email' => 'admin@barbershop.test',
            'name'  => 'Admin Sami',
        ]);

        $shop = BarberShop::create([
            'name'      => 'BarberChop Centre',
            'city'      => 'Ben Guerir',
            'address'   => 'Avenue Mohammed VI',
            'zip'       => '43150',
            'latitude'  => 32.2345,
            'Longitude' => -7.9543,
            'user_id'   => $admin->id,
        ]);

        $barber = BarberMan::create([
            'name'          => 'Youssef El Amrani',
            'barbershop_id' => $shop->id,
        ]);

        $service = Service::create([
            'name'          => 'Coupe Royale & Barbe',
            'description'   => 'Coupe aux ciseaux et taille de barbe à l’ancienne.',
            'price'         => 80,
            'duration'      => 45,
            'barbershop_id' => $shop->id,
        ]);

        // 2. Test Home (/) - Displays the real shop and price in DH
        $homeResponse = $this->get(route('index'));
        $homeResponse->assertStatus(200);
        $homeResponse->assertSee('BarberChop Centre');
        $homeResponse->assertSee('80 DH');
        $homeResponse->assertDontSee('$30 / service');

        // 3. Test "Reserve" link: GET /reservation/services without shop_id
        $reserveResponse = $this->get(route('reservation.services'));
        $reserveResponse->assertStatus(200);
        $reserveResponse->assertSee('BarberChop Centre');
        $reserveResponse->assertSee('Coupe Royale & Barbe');
        $reserveResponse->assertSee('80.00 DH');

        // 4. Test "Book now" link: GET /reservation/services?shop_id={id}
        $bookNowResponse = $this->get(route('reservation.services', ['shop_id' => $shop->id]));
        $bookNowResponse->assertStatus(200);
        $bookNowResponse->assertSee('BarberChop Centre');
        $bookNowResponse->assertSee('Coupe Royale & Barbe');
        $bookNowResponse->assertSee('80.00 DH');

        // 5. Select service via POST /mes-reservations
        $selectResponse = $this->post(route('reservation.selection'), [
            'service_ids' => [$service->id],
            'shop_id'     => $shop->id,
        ]);
        $selectResponse->assertRedirect(route('reservation.index'));
        $this->assertEquals([$service->id], session('reservation_service_ids'));

        // 6. View booking form GET /mes-reservations
        $formResponse = $this->get(route('reservation.index'));
        $formResponse->assertStatus(200);
        $formResponse->assertSee('BarberChop Centre');
        $formResponse->assertSee('Coupe Royale & Barbe');
        $formResponse->assertSee('Youssef El Amrani');
        $formResponse->assertSee('80 DH');

        // 7. Submit booking as Guest via POST /reservation
        $bookingData = [
            'name'         => 'Karim Benani',
            'phone'        => '0612345678',
            'barberman_id' => $barber->id,
            'date'         => now()->addDays(2)->format('Y-m-d'),
            'time'         => '14:00',
        ];

        $storeResponse = $this->post(route('reservation.store'), $bookingData);

        // Verify Reservation was saved in database with correct total and guest info
        $reservation = Reservation::where('phone', '0612345678')->first();
        $this->assertNotNull($reservation);
        $this->assertEquals('Karim Benani', $reservation->name);
        $this->assertEquals(80, $reservation->price);
        $this->assertEquals('confirmed', $reservation->status);
        $this->assertEquals($barber->id, $reservation->barbermans_id);
        $this->assertTrue($reservation->services->contains($service->id));

        $storeResponse->assertRedirect(route('reservation.confirmation', $reservation->id));

        // 8. Test Confirmation Page GET /reservation/confirmation/{id}
        $confirmResponse = $this->get(route('reservation.confirmation', $reservation->id));
        $confirmResponse->assertStatus(200);
        $confirmResponse->assertSee('Votre réservation est confirmée !');
        $confirmResponse->assertSee('BarberChop Centre');
        $confirmResponse->assertSee('Youssef El Amrani');
        $confirmResponse->assertSee('Coupe Royale & Barbe');
        $confirmResponse->assertSee('80 DH');
        $confirmResponse->assertSee('Karim Benani');

        // 9. Verify that the reservation appears in Purple Admin -> Reservations
        $adminReservationsResponse = $this->actingAs($admin)->get(route('admin.reservations.index'));
        $adminReservationsResponse->assertStatus(200);
        $adminReservationsResponse->assertSee('Karim Benani');
        $adminReservationsResponse->assertSee('0612345678');
        $adminReservationsResponse->assertSee('BarberChop Centre');
        $adminReservationsResponse->assertSee('Youssef El Amrani');
        $adminReservationsResponse->assertSee('Coupe Royale & Barbe');
        $adminReservationsResponse->assertSee('80 DH');
        $adminReservationsResponse->assertSee('Confirmed');
    }
}
