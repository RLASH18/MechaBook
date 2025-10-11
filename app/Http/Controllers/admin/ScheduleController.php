<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;

class ScheduleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('admin.schedules.index', [
            'title' => 'MechaBook | Admin - Schedule Management'
        ]);
    }
}
