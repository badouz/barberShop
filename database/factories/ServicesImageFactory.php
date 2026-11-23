<?php

namespace Database\Factories;

use App\Models\ServicesImage;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<ServicesImage>
 */
class ServicesImageFactory extends Factory
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
            'service_id'=> fake()->numberBetween(1, 10000),
        ];
    }
}
