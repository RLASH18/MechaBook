<?php

namespace App\Http\Requests\admin\schedule;

use App\UserRole;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class StoreScheduleRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return Auth::check() && Auth::user()->role === UserRole::Admin;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'employee_id' => 'required|exists:users,id',
            'day_of_week' => 'required|in:Mon,Tue,Wed,Thu,Fri,Sat,Sun',
            'start_time' => 'required|date_format:H:i',
            'end_time' => 'required|date_format:H:i|after:start_time',
        ];
    }

    /**
     * Get custom error messages for validation rules.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'employee_id.required' => 'Please select an employee.',
            'employee_id.exists' => 'The selected employee does not exist.',
            'day_of_week.required' => 'Please select a day of the week.',
            'day_of_week.in' => 'Invalid day of the week selected.',
            'start_time.required' => 'Please enter a start time.',
            'start_time.date_format' => 'Please enter a valid start time (e.g., 09:00 AM).',
            'end_time.required' => 'Please enter an end time.',
            'end_time.date_format' => 'Please enter a valid end time (e.g., 05:00 PM).',
            'end_time.after' => 'End time must be later than start time.',
        ];
    }
}
