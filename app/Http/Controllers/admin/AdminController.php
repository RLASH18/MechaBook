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
        $data = [
            'title' => 'MechaBook | Admin - Dashboard'
        ];

        return view('admin.dashboard', $data);
    }

    public function settings()
    {
        $user = auth()->user();

        return view('admin.settings', [
            'title' => 'MechaBook | Admin - Settings',
            'user' => $user
        ]);
    }

    public function logout()
    {
        return $this->logoutUser();
    }
}
