<?php

namespace Database\Seeders;

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
        $employees = User::where('role', UserRole::Employee)->get();

        foreach ($employees->take(5) as $employee) {
            ScheduleChangeRequest::factory()->create([
                'employee_id' => $employee->id,
            ]);
        }
    }
}
