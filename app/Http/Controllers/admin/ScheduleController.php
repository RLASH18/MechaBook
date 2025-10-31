<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;

class ScheduleController extends Controller
{
    /**
     * Display the admin schedule management page.
     */
    public function index()
    {
        return view('admin.schedules', [
            'title' => 'MechaBook | Admin - Schedule Management'
        ]);
    }
}
