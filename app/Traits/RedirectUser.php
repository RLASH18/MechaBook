<?php

namespace App\Traits;

use App\Models\User;
use App\UserRole;

trait RedirectUser
{
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
