<?php

namespace Database\Factories;

use App\Models\Service;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Service>
 */
class ServiceFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name'=> fake()->name(),
            'description'=> fake()->paragraph(),
            'price'=> fake()->randomFloat(2,5,500),
            'duration'=> fake()-> numberBetween(5,60),
            'barbershop_id'=> fake()->numberBetween(1, 10000),
        ];
    }
}
