<?php

namespace Database\Seeders;

use App\Models\Appointment;
use App\Models\Service;
use App\Models\User;
use App\UserRole;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AppointmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get existing customers and employees
        $customers = User::where('role', UserRole::Customer)->get();
        $employees = User::where('role', UserRole::Employee)->get();
        $services = Service::all();

        // Create 20 appointments with random assignments
        for ($i = 0; $i < 20; $i++) {
            Appointment::factory()->create([
                'customer_id' => $customers->random()->id,
                'employee_id' => $employees->random()->id,
                'service_id' => $services->random()->id
            ]);
        }
    }
}
