<?php

namespace App\Http\Controllers\auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Traits\RedirectUser;
use App\UserRole;
use Exception;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;

class OAuthController extends Controller
{
    use RedirectUser;

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
            return redirect()->route('login')
                ->with('auth_error', 'Google authentication failed. Please try again.');
        }
    }
}
