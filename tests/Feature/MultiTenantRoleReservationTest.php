<?php

namespace Tests\Feature;

use App\Models\BarberMan;
use App\Models\BarberShop;
use App\Models\Reservation;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class MultiTenantRoleReservationTest extends TestCase
{
    use RefreshDatabase;

    public function test_barbershop_isolation_for_reservations_and_resources(): void
    {
        // 1. Create two shop owners and an admin
        $ownerX = User::factory()->create(['role' => User::BARBER_SHOP]);
        $ownerY = User::factory()->create(['role' => User::BARBER_SHOP]);
        $admin  = User::factory()->create(['role' => User::ADMIN]);

        // 2. Create Shop X and Shop Y
        $shopX = BarberShop::create([
            'name'      => 'Salon X Test',
            'city'      => 'Rabat',
            'address'   => 'Agdal',
            'zip'       => '10000',
            'latitude'  => 34.0,
            'Longitude' => -6.8,
            'user_id'   => $ownerX->id,
        ]);

        $shopY = BarberShop::create([
            'name'      => 'Salon Y Test',
            'city'      => 'Casablanca',
            'address'   => 'Maarif',
            'zip'       => '20000',
            'latitude'  => 33.5,
            'Longitude' => -7.6,
            'user_id'   => $ownerY->id,
        ]);

        // 3. Create Barbers
        $barberX = BarberMan::create(['name' => 'Barber X', 'barbershop_id' => $shopX->id]);
        $barberY = BarberMan::create(['name' => 'Barber Y', 'barbershop_id' => $shopY->id]);

        // 4. Create Reservations
        $reservationX = Reservation::create([
            'dateReservation' => now()->toDateString(),
            'time'            => '10:00',
            'price'           => 100,
            'barbermans_id'   => $barberX->id,
            'name'            => 'Customer of X',
            'phone'           => '0611111111',
            'status'          => 'confirmed',
        ]);

        $reservationY = Reservation::create([
            'dateReservation' => now()->toDateString(),
            'time'            => '11:00',
            'price'           => 120,
            'barbermans_id'   => $barberY->id,
            'name'            => 'Customer of Y',
            'phone'           => '0622222222',
            'status'          => 'confirmed',
        ]);

        // Check Owner X: sees reservation X, does not see reservation Y
        $responseX = $this->actingAs($ownerX)->get(route('admin.reservations.index'));
        $responseX->assertStatus(200);
        $responseX->assertSee('Customer of X');
        $responseX->assertDontSee('Customer of Y');

        // Check Owner Y: sees reservation Y, does not see reservation X
        $responseY = $this->actingAs($ownerY)->get(route('admin.reservations.index'));
        $responseY->assertStatus(200);
        $responseY->assertSee('Customer of Y');
        $responseY->assertDontSee('Customer of X');

        // Check Admin: sees both
        $responseAdmin = $this->actingAs($admin)->get(route('admin.reservations.index'));
        $responseAdmin->assertStatus(200);
        $responseAdmin->assertSee('Customer of X');
        $responseAdmin->assertSee('Customer of Y');

        // Owner Y attempts to update status of Owner X's reservation -> 403 Forbidden
        $unauthorizedUpdate = $this->actingAs($ownerY)->patch(route('admin.reservations.status', $reservationX->id), [
            'status' => 'cancelled',
        ]);
        $unauthorizedUpdate->assertStatus(403);

        // Owner Y attempts to delete Owner X's reservation -> 403 Forbidden
        $unauthorizedDelete = $this->actingAs($ownerY)->delete(route('admin.reservations.destroy', $reservationX->id));
        $unauthorizedDelete->assertStatus(403);

        // Owner Y attempts to edit Owner X's barber -> 403 Forbidden
        $unauthorizedBarberEdit = $this->actingAs($ownerY)->get(route('barbermen.edit', $barberX->id));
        $unauthorizedBarberEdit->assertStatus(403);

        // Owner Y attempts to edit Owner X's barbershop -> 403 Forbidden
        $unauthorizedShopEdit = $this->actingAs($ownerY)->get(route('barbershop.edit', $shopX->id));
        $unauthorizedShopEdit->assertStatus(403);

        // Non-admin attempts to access /users -> 403 Forbidden
        $unauthorizedUsers = $this->actingAs($ownerY)->get(route('users.index'));
        $unauthorizedUsers->assertStatus(403);

        // Admin can access /users -> 200 OK
        $adminUsers = $this->actingAs($admin)->get(route('users.index'));
        $adminUsers->assertStatus(200);
    }

    public function test_setup_test_accounts_route_works(): void
    {
        $response = $this->get(route('setup.test.accounts'));
        $response->assertRedirect(route('login'));
        $response->assertSessionHas('success');

        $this->assertDatabaseHas('users', ['email' => 'ahmed@gmail.com', 'role' => User::BARBER_SHOP]);
        $this->assertDatabaseHas('users', ['email' => 'demo@barberchop.test', 'role' => User::BARBER_SHOP]);
        $this->assertDatabaseHas('users', ['email' => 'moustacharahmad@gmail.com', 'role' => User::ADMIN]);
    }

    public function test_dashboard_renders_with_tenant_stats(): void
    {
        $owner = User::factory()->create(['role' => User::BARBER_SHOP]);
        $shop = BarberShop::create([
            'name'      => 'Salon Test Stats',
            'city'      => 'Fes',
            'address'   => 'Centre',
            'zip'       => '30000',
            'latitude'  => 34.0,
            'Longitude' => -5.0,
            'user_id'   => $owner->id,
        ]);

        $response = $this->actingAs($owner)->get(route('dashboard'));
        $response->assertStatus(200);
        $response->assertSee('Salon Test Stats');
        $response->assertSee('Chiffre', false);
    }
}
