<?php

namespace App\Http\Controllers\employee;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AppointmentController extends Controller
{
    /**
     * Display employee's appointment page
     */
    public function index()
    {
        return view('pages.employee.appointments', [
            'title' => 'MechaBook | Employee - Appointments',
        ]);
    }
}
