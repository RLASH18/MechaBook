<?php

namespace App\Http\Controllers\customer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AppointmentController extends Controller
{
    public function book()
    {
        return view('pages.customer.appointments.book', [
            'title' => 'MechaBook | Customer - Book Appointment',
        ]);
    }

    public function index()
    {
        return view('pages.customer.appointments.index', [
            'title' => 'MechaBook | Customer - Appointments',
        ]);
    }
}
