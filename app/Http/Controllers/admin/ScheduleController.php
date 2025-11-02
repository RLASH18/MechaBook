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
        return view('pages.admin.schedules.index', [
            'title' => 'MechaBook | Admin - Schedule Management'
        ]);
    }
}
