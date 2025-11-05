<?php

namespace App\Http\Controllers\customer;

use App\Http\Controllers\Controller;
use App\Traits\LogoutHandler;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CustomerController extends Controller
{
    use LogoutHandler;

    public function dashboard()
    {
        return view('pages.customer.dashboard', [
            'title' => 'MechaBook | Customer - Dashboard',
        ]);
    }

    public function settings()
    {
        $user = Auth::user();

        return view('pages.settings', [
            'title' => 'MechaBook | Customer - Settings',
            'user' => $user
        ]);
    }
}
