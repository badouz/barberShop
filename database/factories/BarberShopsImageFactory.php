<?php

namespace Database\Factories;

use App\Models\BarberShopsImage;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<BarberShopsImage>
 */
class BarberShopsImageFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'path'=> fake()->url(),
            'is_primary'=> fake()->boolean(50),
            'barbershop_id'=> fake()->numberBetween(1, 10000),
        ];
    }
}
