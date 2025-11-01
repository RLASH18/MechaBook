<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Appointment;
use App\Models\Service;
use App\Models\User;
use App\Traits\LogoutHandler;
use App\UserRole;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    use LogoutHandler;

    public function dashboard()
    {
        $customers = User::where('role', UserRole::Customer)->count();
        $appointments = Appointment::count();
        $services = Service::count();
        $employees = User::where('role', UserRole::Employee)->count();

        return view('pages.admin.dashboard', [
            'title' => 'MechaBook | Admin - Dashboard',
            'totalCustomers' => $customers,
            'totalAppointments' => $appointments,
            'allServices' => $services,
            'availableEmployees' => $employees
        ]);
    }

    public function settings()
    {
        $user = auth()->user();

        return view('pages.admin.settings', [
            'title' => 'MechaBook | Admin - Settings',
            'user' => $user
        ]);
    }

    public function logout()
    {
        return $this->logoutUser();
    }
}
