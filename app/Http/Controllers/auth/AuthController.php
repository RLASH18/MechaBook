<?php

namespace App\Http\Controllers\auth;

use App\Http\Controllers\Controller;
use App\Mail\VerifyEmail;
use App\Models\User;
use App\Traits\RedirectUser;
use App\UserRole;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Carbon;

class AuthController extends Controller
{
    use RedirectUser;

    /**
     * Display the login form.
     */
    public function showLoginForm()
    {
        return view('pages.auth.login', [
            'title' => 'MechaBook | Login'
        ]);
    }

    /**
     * Handle user login authentication.
     *
     * @param  Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:8'
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            // Check if email is verified
            if (! Auth::user()->hasVerifiedEmail()) {
                Auth::logout();
                return back()->with('auth_info', 'Please verify your email address before logging in.');
            }

            return $this->redirectBasedOnRole(Auth::user());
        }

        return back()->with('auth_error', 'Invalid email or password.');
    }

    /**
     * Display the regitser form.
     */
    public function showRegisterForm()
    {
        return view('pages.auth.register', [
            'title' => 'MechaBook | Register'
        ]);
    }

    /**
     * Handle user registration.
     *
     * @param  Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function register(Request $request)
    {
        $data = $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:8|confirmed'
        ]);

        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => $data['password'],
            'role' => UserRole::Customer,
        ]);

        // Send custom email verification
        $verificationUrl = URL::temporarySignedRoute(
            'verification.verify',
            Carbon::now()->addMinutes(60),
            ['id' => $user->id, 'hash' => sha1($user->email)]
        );

        Mail::to($user->email)->send(new VerifyEmail($verificationUrl, $user->name));

        return redirect()->route('login')
            ->with('auth_success', 'Account created! Please check your email to verify your account.');
    }
}
