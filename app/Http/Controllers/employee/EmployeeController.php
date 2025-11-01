<?php

namespace App\Http\Controllers\employee;

use App\Http\Controllers\Controller;
use App\Traits\LogoutHandler;
use Illuminate\Support\Facades\Auth;

class EmployeeController extends Controller
{
    use LogoutHandler;

    public function dashboard()
    {
        return view('pages.employee.dashboard', [
            'title' => 'MechaBook | Employee - Dashboard',
        ]);
    }

    public function settings()
    {
        $user = Auth::user();

        return view('pages.settings', [
            'title' => 'MechaBook | Employee - Settings',
            'user' => $user
        ]);
    }

    public function logout()
    {
        return $this->logoutUser();
    }
}
