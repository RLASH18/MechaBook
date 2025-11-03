<?php

namespace Database\Seeders;

use App\Models\EmployeeSchedule;
use App\Models\User;
use App\UserRole;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class EmployeeScheduleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $employees = User::where('role', UserRole::Employee)->get();

        if ($employees->isEmpty()) {
            $this->command->warn('No employees found. Please seed employees first.');
            return;
        }

        $workDays = ['Mon', 'Tue', 'Wed', 'Thu', 'Fri'];

        // Create schedules for each employee
        foreach ($employees as $employee) {
            foreach ($workDays as $day) {
                EmployeeSchedule::create([
                    'employee_id' => $employee->id,
                    'day_of_week' => $day,
                    'start_time' => '09:00:00',
                    'end_time' => '17:00:00',
                ]);
            }
        }
    }
}
