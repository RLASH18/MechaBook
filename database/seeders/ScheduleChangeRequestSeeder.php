<?php

namespace Database\Seeders;

use App\Models\EmployeeSchedule;
use App\Models\ScheduleChangeRequest;
use App\Models\User;
use App\UserRole;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ScheduleChangeRequestSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $schedules = EmployeeSchedule::with('employee')->get();

        if ($schedules->isEmpty()) {
            $this->command->warn('No employee schedules found. Please seed employee schedules first.');
            return;
        }

        // Create 10 change requests from existing schedules
        foreach ($schedules->random(10) as $schedule) {
            $requestType = fake()->randomElement(['time_change', 'day_change', 'day_off']);

            $data = [
                'employee_id' => $schedule->employee_id,
                'request_type' => $requestType,
                'current_day_of_week' => $schedule->day_of_week,
                'current_start_time' => $schedule->start_time,
                'current_end_time' => $schedule->end_time,
                'reason' => fake()->sentence(),
                'status' => 'pending',
            ];

            // Set requested fields based on type
            if ($requestType === 'time_change') {
                $data['requested_day_of_week'] = $schedule->day_of_week;
                $data['requested_start_time'] = '10:00:00';
                $data['requested_end_time'] = '18:00:00';
            } elseif ($requestType === 'day_change') {
                $daysOfWeek = ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'];
                $data['requested_day_of_week'] = fake()->randomElement(
                    array_diff($daysOfWeek, [$schedule->day_of_week])
                );
                $data['requested_start_time'] = $schedule->start_time;
                $data['requested_end_time'] = $schedule->end_time;
            } else { // day_off
                $data['requested_day_of_week'] = null;
                $data['requested_start_time'] = null;
                $data['requested_end_time'] = null;
            }

            ScheduleChangeRequest::create($data);
        }
    }
}
