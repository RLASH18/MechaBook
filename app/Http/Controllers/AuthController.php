<?php

namespace App\Http\Controllers;

use App\UserRole;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function showSigninForm()
    {
        return view('signin', [
            'title' => 'MechaBook | Signin'
        ]);
    }

    public function signin(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:8'
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            // Redirect based on role
            return match(Auth::user()->role) {
                UserRole::Admin => redirect()->route('admin.dashboard'),
                UserRole::Employee => redirect()->route('employee.dashboard'),
                UserRole::Customer => redirect()->route('customer.dashboard')
            };
        }

        return back()->with('error', 'Invalid email or password.');
    }

    public function showSignupForm()
    {
        return view('signup', [
            'title' => 'MechaBook | Signup'
        ]);
    }

    public function signup(Request $request)
    {

    }
}
