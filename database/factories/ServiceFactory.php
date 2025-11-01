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
        $categories = ['Maintenance', 'Repair', 'Inspection', 'Detailing', 'Diagnostic', 'Other'];

        return [
            'name' => fake()->words(3, true),
            'description' => fake()->paragraph(),
            'category' => fake()->randomElement($categories),
            'duration_minutes' => fake()->numberBetween(15, 180),
            'price' => fake()->randomFloat(2, 100, 5000),
            'service_img' => null,
        ];
    }
}
