<?php

namespace Database\Factories;

use App\Models\User;
use App\UserRole;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\ScheduleChangeRequest>
 */
class ScheduleChangeRequestFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $daysOfWeek = ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday'];

        return [
            'employee_id' => User::factory()->state(['role' => UserRole::Employee]),
            'request_type' => fake()->randomElement(['time_change', 'day_change', 'day_off']),
            'current_day_of_week' => fake()->randomElement($daysOfWeek),
            'current_start_time' => '09:00:00',
            'current_end_time' => '17:00:00',
            'requested_day_of_week' => fake()->randomElement($daysOfWeek),
            'requested_start_time' => '10:00:00',
            'requested_end_time' => '18:00:00',
            'reason' => fake()->sentence(),
            'status' => 'pending',
        ];
    }
}
