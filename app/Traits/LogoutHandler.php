<?php

namespace App\Traits;

use Illuminate\Support\Facades\Auth;

trait LogoutHandler
{
    /**
     * Logs out the current user and invalidates the session.
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function logoutUser()
    {
        Auth::logout();

        request()->session()->invalidate();
        request()->session()->regenerateToken();

        return redirect()->route('signin');
    }
}
