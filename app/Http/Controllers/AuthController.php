<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\UserRole;
use Exception;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;

class AuthController extends Controller
{
    /**
     * Display the login form.
     */
    public function showLoginForm()
    {
        return view('pages.login', [
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
                return back()->with('auth_info', 'Please verify your email address before loging in.');
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
        return view('pages.register', [
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

        // Trigger email verification
        event(new Registered($user));

        return redirect()->route('login')
            ->with('auth_success', 'Account created! Please check your email to verify your account.');
    }

    /**
     * Redirect to Google OAuth.
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function googleRedirect()
    {
        return Socialite::driver('google')
            ->with([
                'prompt' => 'select_account',
                'hl' => 'en',
            ])
            ->redirect();
    }

    /**
     * Handle Google OAuth callback.
     * Automatically registers new users or logs in existing users.
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function googleCallback()
    {
        try {
            $googleUser = Socialite::driver('google')->user();

            // Check if user exists
            $user = User::where('email', $googleUser->getEmail())->first();

            $isNewUser = false;

            if (! $user) {
                // Create new user
                $user = User::create([
                    'name' => $googleUser->getName(),
                    'email' => $googleUser->getEmail(),
                    'password' => uniqid(),
                    'role' => UserRole::Customer,
                    'email_verified_at' => now(),
                ]);
                $isNewUser = true;
            }

            Auth::login($user);

            // Show notification only for new users
            if ($isNewUser) {
                notyf()->success('Account created successfully! Welcome to MechaBook.');
            }

            return $this->redirectBasedOnRole($user);
        } catch (Exception $e) {
            notyf()->error('Google authentication failed. Please try again.');
            return redirect()->route('login');
        }
    }

    /**
     * Handle email verification.
     *
     * @param  Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function verifyEmail(Request $request)
    {
        $user = User::findOrFail($request->route('id'));

        // Verify the hash matches
        if (! hash_equals((string) $request->route('hash'), sha1($user->getEmailForVerification()))) {
            abort(403, 'Invalid verification link.');
        }

        // Check if signature is valid
        if (! $request->hasValidSignature()) {
            abort(403, 'Verification link has expired.');
        }

        // Mark email as verified
        if (! $user->hasVerifiedEmail()) {
            $user->markEmailAsVerified();
        }

        // Log the user in
        Auth::login($user);
        notyf()->success('Email verified successfully!');

        return $this->redirectBasedOnRole($user);
    }

    /**
     * Redirect user based on their role.
     *
     * @param  User  $user
     * @return \Illuminate\Http\RedirectResponse
     */
    private function redirectBasedOnRole(User $user)
    {
        return match ($user->role) {
            UserRole::Admin => redirect()->route('admin.dashboard'),
            UserRole::Employee => redirect()->route('employee.dashboard'),
            UserRole::Customer => redirect()->route('customer.dashboard'),
            default => redirect()->route('customer.dashboard'),
        };
    }
}
