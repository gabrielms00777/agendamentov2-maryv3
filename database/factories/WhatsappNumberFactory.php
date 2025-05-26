<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\WhatsappNumber>
 */
class WhatsappNumberFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'number' => '5511' . fake()->numerify('9########'),
            'provider' => fake()->randomElement(['Meta', 'Twilio']),
            'api_token' => fake()->uuid,
            'status' => fake()->randomElement(['connected', 'pending']),
        ];
    }
}
