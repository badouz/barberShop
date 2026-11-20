<?php

namespace Tests\Feature;

use App\Models\BarberMan;
use App\Models\BarberShop;
use App\Models\Reservation;
use App\Models\Service;
use App\Models\User;
use Database\Seeders\ChairClientSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ChairClientFlowTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed(ChairClientSeeder::class);
    }

    public function test_unauthenticated_user_redirected_to_login(): void
    {
        $response = $this->get(route('client.home'));
        $response->assertRedirect(route('login'));
    }

    public function test_authenticated_user_can_access_all_client_pages(): void
    {
        $client = User::where('email', 'james.wilson@email.com')->firstOrFail();
        $shop = BarberShop::where('name', 'The Modern Gentleman')->firstOrFail();
        $reservation = Reservation::where('user_id', $client->id)->firstOrFail();

        // 01 Home
        $this->actingAs($client)->get(route('client.home'))
            ->assertStatus(200)
            ->assertSee('Hello, Welcome Back!')
            ->assertSee('The Modern Gentleman');

        // 02 Shop details
        $this->actingAs($client)->get(route('client.shop', $shop->id))
            ->assertStatus(200)
            ->assertSee($shop->name)
            ->assertSee('Meet your barbers');

        // 03 Reservation form
        $this->actingAs($client)->get(route('client.reserve', $shop->id))
            ->assertStatus(200)
            ->assertSee('Make a reservation')
            ->assertSee('Choose your barber')
            ->assertSee('Select a package');

        // 04 Booking success
        $this->actingAs($client)->get(route('client.booking-success', $reservation->id))
            ->assertStatus(200)
            ->assertSee('You’re all booked!');

        // 05 My bookings
        $this->actingAs($client)->get(route('client.bookings'))
            ->assertStatus(200)
            ->assertSee('Your next good hair day.')
            ->assertSee('Upcoming')
            ->assertSee('Past');

        // 06 Reservation details
        $this->actingAs($client)->get(route('client.booking-detail', $reservation->id))
            ->assertStatus(200)
            ->assertSee('Cancellation policy')
            ->assertSee('#CH-');

        // 07 Settings
        $this->actingAs($client)->get(route('client.settings'))
            ->assertStatus(200)
            ->assertSee($client->name)
            ->assertSee('Language')
            ->assertSee('Notifications');
    }

    public function test_user_can_create_new_reservation(): void
    {
        $client = User::where('email', 'james.wilson@email.com')->firstOrFail();
        $shop = BarberShop::where('name', 'The Modern Gentleman')->firstOrFail();
        $barber = BarberMan::where('barbershop_id', $shop->id)->firstOrFail();
        $service = Service::where('barbershop_id', $shop->id)->firstOrFail();

        $postData = [
            'barberman_id' => $barber->id,
            'service_id' => $service->id,
            'date' => now()->addDays(3)->format('Y-m-d'),
            'time' => '14:00',
            'name' => 'James Wilson',
            'phone' => '+1 (555) 234-5678',
        ];

        $response = $this->actingAs($client)->post(route('client.store', $shop->id), $postData);

        $newReservation = Reservation::where('user_id', $client->id)
            ->where('dateReservation', $postData['date'])
            ->where('time', '14:00')
            ->first();

        $this->assertNotNull($newReservation);
        $response->assertRedirect(route('client.booking-success', $newReservation->id));
    }

    public function test_user_cannot_access_other_users_reservation(): void
    {
        $client = User::where('email', 'james.wilson@email.com')->firstOrFail();
        $otherUser = User::factory()->create();
        $reservation = Reservation::where('user_id', $client->id)->firstOrFail();

        $this->actingAs($otherUser)
            ->get(route('client.booking-detail', $reservation->id))
            ->assertStatus(403);
    }
}
