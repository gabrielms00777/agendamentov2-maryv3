<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Company>
 */
class CompanyFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            // 'user_id' => User::factory(),
            'name' => fake()->company,
            'email' => fake()->unique()->safeEmail,
            'phone' => '55' . fake()->numerify('119########'),
            'document' => fake()->numerify('##############'),
        ];
    }
}
