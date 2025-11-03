<?php

namespace Database\Factories;

use App\Models\Service;
use App\Models\User;
use App\UserRole;
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
        $date = fake()->dateTimeBetween('now', '+1 month');
        $startHour = fake()->numberBetween(9, 16);
        $status = ['approved', 'rejected', 'cancelled', 'started', 'completed'];

        return [
            'customer_id' => User::factory()->state(['role' => UserRole::Customer]),
            'employee_id' => User::factory()->state(['role' => UserRole::Employee]),
            'service_id' => Service::factory(),
            'appointment_date' => $date->format('Y-m-d'),
            'start_time' => sprintf('%02d:00:00', $startHour),
            'end_time' => sprintf('%02d:00:00', $startHour + 2),
            'status' =>  fake()->randomElement($status),
            'notes' => fake()->sentence()
        ];
    }
}
