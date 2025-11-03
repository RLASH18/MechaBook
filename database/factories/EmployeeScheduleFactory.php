<?php

namespace Database\Factories;

use App\Models\User;
use App\UserRole;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\EmployeeSchedule>
 */
class EmployeeScheduleFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $startHour = fake()->numberBetween(8, 10);

        return [
            'employee_id' => User::factory()->state(['role' => UserRole::Employee]),
            'day_of_week' => fake()->randomElement(['Mon', 'Tue', 'Wed', 'Thu', 'Fri']),
            'start_time' => sprintf('%02d:00:00', $startHour),
            'end_time' => sprintf('%02d:00:00', $startHour + 8),
        ];
    }
}
