<?php

namespace App\Http\Controllers\auth;

use App\Http\Controllers\Controller;
use App\Mail\ResetPassword;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class ResetPasswordController extends Controller
{
    /**
     * Display the forgot password form.
     *
     * @return \Illuminate\View\View
     */
    public function requestForm()
    {
        return view('pages.auth.forgot-password', [
            'title' => 'MechaBook | Forgot Password'
        ]);
    }

    /**
     * Send password reset link to user's email.
     *
     * @param  Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function sendResetLink(Request $request)
    {
        $request->validate(['email' => 'required|email']);

        $token = Str::random(64);

        // Store or update the reset token in database
        DB::table('password_reset_tokens')->updateOrInsert(
            ['email' => $request->email],
            ['token' => Hash::make($token), 'created_at' => Carbon::now()]
        );

        // Get user information
        $user = User::where('email', $request->email)->first();

        if (! $user) {
            return back()->withErrors(['email' => 'We can\'t find a user with that email address.']);
        }

        // Create the password reset URL
        $resetUrl = url('reset-password/' . $token . '?email=' . $request->email);

        // Send the reset email using the mailable
        Mail::to($request->email)->send(new ResetPassword($resetUrl, $user->name));

        return back()->with('auth_success', 'Reset link send.');
    }

    /**
     * Display the password reset form.
     *
     * @param  Request  $request
     * @param  string  $token
     * @return \Illuminate\View\View
     */
    public function resetForm(Request $request, string $token)
    {
        return view('pages.auth.reset-password', [
            'title' => 'MechaBook | Reset Password',
            'token' => $token,
            'email' => $request->email,
        ]);
    }

    /**
     * Handle password reset request.
     *
     * @param  Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function resetPassword(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:8|confirmed',
            'token' => 'required'
        ]);

        // Find the password reset record
        $record = DB::table('password_reset_tokens')->where('email', $request->email)->first();

        if (! $record || ! Hash::check($request->token, $record->token)) {
            return back()->withErrors(['email' => 'Invalid reset token.']);
        }

        User::where('email', $request->email)->update([
            'password' => Hash::make($request->password)
        ]);

        DB::table('password_reset_tokens')->where('email', $request->email)->delete();

        return redirect()->route('login')->with('auth_success', 'Password reset successfull.');
    }
}
