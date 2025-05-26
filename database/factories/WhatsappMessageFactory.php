<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\WhatsappMessage>
 */
class WhatsappMessageFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'from_number' => '5511' . fake()->numerify('9########'),
            'to_number' => '5511' . fake()->numerify('9########'),
            'direction' => fake()->randomElement(['inbound', 'outbound']),
            'content' => fake()->sentence,
            'message_id' => fake()->uuid,
            'type' => fake()->randomElement(['text', 'image']),
            'timestamp' => fake()->dateTimeThisYear,
        ];
    }
}
