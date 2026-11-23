<?php

namespace Database\Factories;

use App\Models\BarberShop;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<BarberShop>
 */
class BarberShopFactory extends Factory
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
            'address' => fake()->streetAddress(),
            'city' => fake()->city(),
            'zip' => fake()->postcode(),
            'latitude' => fake()->latitude(),
            'Longitude' => fake()->longitude(),
            'user_id' => 1,
        ];
    }
}
