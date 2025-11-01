<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Traits\LogoutHandler;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    use LogoutHandler;

    public function dashboard()
    {
        return view('pages.admin.dashboard', [
            'title' => 'MechaBook | Admin - Dashboard'
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
