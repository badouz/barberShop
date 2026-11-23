<?php

namespace Database\Factories;

use App\Models\Reservation;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Reservation>
 */
class ReservationFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id'=> 1,
            'dateReservation'=> fake()->date(),
            'time'=> fake()->time(),
            'price'=> fake()->randomFloat(2, 5, 300),
            'barbermans_id'=> fake()->numberBetween(1, 10000),
            'name'=> fake()->name(),
            'phone'=> fake()->phoneNumber(),
            'status'=> fake()->randomElement(['pending', 'confirmed', 'cancelled']),
        ];
    }
}
