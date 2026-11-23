<?php

namespace Database\Factories;

use App\Models\BarberMan;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<BarberMan>
 */
class BarberManFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->name(),
            'barbershop_id'=> fake()->numberBetween(1, 10000),
        ];
    }
}
