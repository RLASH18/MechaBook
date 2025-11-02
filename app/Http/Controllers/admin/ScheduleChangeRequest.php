<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ScheduleChangeRequest extends Controller
{
    /**
     * Display the admin change schedule request page.
     */
    public function index()
    {
        return view('pages.admin.schedules.change-requests', [
            'title' => 'MechaBook | Admin - Employee Schedule Change Request'
        ]);
    }
}
