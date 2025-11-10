<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\UserRole;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable implements MustVerifyEmail
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'role',
        'password',
        'phone',
        'profile_image',
        'email_verified_at'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'role' => UserRole::class
        ];
    }

    /**
     * Get all of the Employee Schedules for the User
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function employeeSchedules(): HasMany
    {
        return $this->hasMany(EmployeeSchedule::class, 'employee_id');
    }

    /**
     * Get all of the customer appointments for the User
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function customerAppointments(): HasMany
    {
        return $this->hasMany(Appointment::class, 'customer_id');
    }

    /**
     * Get all of the employee ppointmens for the User
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function employeeAppointmens(): HasMany
    {
        return $this->hasMany(Appointment::class, 'employee_id');
    }

    /**
     * Get all schedule change requests made by the employee.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function scheduleChangeRequests(): HasMany
    {
        return $this->hasMany(ScheduleChangeRequest::class, 'employee_id');
    }

    /**
     * Get all schedule change requests reviewed by the admin.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function reviewedScheduleChangeRequests(): HasMany
    {
        return $this->hasMany(ScheduleChangeRequest::class, 'reviewed_by');
    }

    /**
     * Get all social links for the user.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function socialLinks(): HasMany
    {
        return $this->hasMany(UserSocialLink::class, 'user_id');
    }

    /**
     * Get active social links for the user.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function activeSocialLinks(): HasMany
    {
        return $this->hasMany(UserSocialLink::class)->where('is_active', true);
    }
}
