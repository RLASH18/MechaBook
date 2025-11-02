<?php

namespace App\Http\Requests\employee;

use App\UserRole;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class StoreScheduleChangeRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return Auth::check() && Auth::user()->role === UserRole::Employee;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'selectedDay' => 'required|in:Mon,Tue,Wed,Thu,Fri,Sat,Sun',
            'requestType' => 'required|in:time_change,day_change,day_off',
            'requestedDay' => 'required_if:requestType,day_change|nullable|in:Mon,Tue,Wed,Thu,Fri,Sat,Sun|different:selectedDay',
            'requestedStartTime' => 'required_if:requestType,time_change|nullable|date_format:H:i',
            'requestedEndTime' => 'required_if:requestType,time_change|nullable|date_format:H:i|after:requestedStartTime',
            'reason' => 'required|string|min:10|max:500',
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
            'selectedDay.required' => 'Please select a day.',
            'selectedDay.in' => 'Invalid day selected.',
            'requestType.required' => 'Please select a request type.',
            'requestType.in' => 'Invalid request type selected.',
            'requestedDay.required_if' => 'Please select a new day.',
            'requestedDay.different' => 'The new day must be different from the current day.',
            'requestedStartTime.required_if' => 'Start time is required for time change requests.',
            'requestedStartTime.date_format' => 'Please enter a valid start time.',
            'requestedEndTime.required_if' => 'End time is required for time change requests.',
            'requestedEndTime.date_format' => 'Please enter a valid end time.',
            'requestedEndTime.after' => 'End time must be later than start time.',
            'reason.required' => 'Please provide a reason for your request.',
            'reason.min' => 'Reason must be at least 10 characters.',
            'reason.max' => 'Reason cannot exceed 500 characters.',
        ];
    }

    /**
     * Get custom attribute names for error messages.
     *
     * @return array<string, string>
     */
    public function attributes(): array
    {
        return [
            'selectedDay' => 'current day',
            'requestType' => 'request type',
            'requestedDay' => 'new day',
            'requestedStartTime' => 'start time',
            'requestedEndTime' => 'end time',
            'reason' => 'reason',
        ];
    }
}
