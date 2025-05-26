<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Service>
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
            'name' => 'Serviço ' . fake()->word,
            'duration_minutes' => fake()->randomElement([30, 60, 90]),
            'price' => fake()->randomFloat(2, 50, 200),
            'is_active' => true,
        ];
    }
}
