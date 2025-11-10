<?php

namespace App\Http\Controllers\auth;

use App\Http\Controllers\Controller;
use App\Mail\VerifyEmail;
use App\Models\User;
use App\Traits\RedirectUser;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\URL;

class VerifyEmailController extends Controller
{
    use RedirectUser;

    /**
     * Handle email verification.
     *
     * @param  Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function verify(Request $request)
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

        Auth::login($user);
        notyf()->success('Email verified successfully!');

        return $this->redirectBasedOnRole($user);
    }

    /**
     * Show the resend verification form.
     *
     * @return \Illuminate\View\View
     */
    public function showResendForm()
    {
        return view('pages.auth.resend-verification', [
            'title' => 'MechaBook | Resend Verification'
        ]);
    }

    /**
     * Resend the email verification notification by email address (for unauthenticated users).
     *
     * @param  Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function resendByEmail(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:users,email'
        ]);

        $user = User::where('email', $request->email)->first();

        if ($user->hasVerifiedEmail()) {
            return back()->with('auth_info', 'This email address is already verified. You can log in now.');
        }

        // Create verification URL
        $verificationUrl = URL::temporarySignedRoute(
            'verification.verify',
            Carbon::now()->addMinutes(60),
            ['id' => $user->id, 'hash' => sha1($user->email)]
        );

        // Send verification email
        Mail::to($user->email)->send(new VerifyEmail($verificationUrl, $user->name));

        return back()->with('auth_success', 'Verification link sent!');
    }
}
