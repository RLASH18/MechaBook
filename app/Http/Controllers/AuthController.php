<?php

namespace App\Http\Controllers;

use App\UserRole;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    /**
     * Display the signin form.
     */
    public function showSigninForm()
    {
        return view('signin', [
            'title' => 'MechaBook | Signin'
        ]);
    }

    /**
     * Handle user signin authentication.
     *
     * @param  Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function signin(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:8'
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            // Redirect based on user role
            return match (Auth::user()->role) {
                UserRole::Admin => redirect()->route('admin.dashboard'),
                UserRole::Employee => redirect()->route('employee.dashboard'),
                UserRole::Customer => redirect()->route('customer.dashboard')
            };
        }

        return back()->with('auth_error', 'Invalid email or password.');
    }

    /**
     * Display the signup form.
     */
    public function showSignupForm()
    {
        return view('signup', [
            'title' => 'MechaBook | Signup'
        ]);
    }

    /**
     * Handle user signup registration.
     *
     * @param  Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function signup(Request $request)
    {
        //
    }
}
