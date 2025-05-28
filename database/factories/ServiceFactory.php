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
            'company_id' => 1,
            'name' => $this->faker->randomElement([
                'Corte de Cabelo', 'Coloração', 'Manicure', 'Pedicure', 
                'Massagem', 'Depilação', 'Maquiagem', 'Barba'
            ]),
            'duration_minutes' => $this->faker->numberBetween(30, 120),
            'price' => $this->faker->numberBetween(30, 200),
        ];
    }
}
