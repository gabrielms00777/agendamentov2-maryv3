<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Appointment>
 */
class AppointmentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'client_name' => $this->faker->name,
            'client_phone' => '55119' . $this->faker->numerify('#######'),
            'date' => $this->faker->dateTimeBetween('now', '+30 days')->format('Y-m-d'),
            'time' => $this->faker->time('H:i'),
            'status' => $this->faker->randomElement(['scheduled', 'confirmed', 'canceled', 'completed']),
            'notes' => $this->faker->optional(0.3)->sentence,
        ];
    }
}
