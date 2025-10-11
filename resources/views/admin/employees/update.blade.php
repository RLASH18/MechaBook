@extends('layouts.admin-layout')
@section('main')
    {{-- Header --}}
    <div class="flex items-center justify-between mb-4">
        <div>
            <x-page-header title="Edit Employee">
                Update the employee's information using the form below.
            </x-page-header>
        </div>

        <div>
            <x-button-link href="{{ route('admin.employee.index') }}" text="Go back">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-5 h-5 mr-2">
                    <path
                        d="M7.82843 10.9999H20V12.9999H7.82843L13.1924 18.3638L11.7782 19.778L4 11.9999L11.7782 4.22168L13.1924 5.63589L7.82843 10.9999Z" />
                </svg>
            </x-button-link>
        </div>
    </div>

    {{-- Form Container --}}
    <x-form.container action="{{ route('admin.employee.update', $employee->id) }}" method="PUT">
        <div class="grid grid-cols-1 gap-6 lg:grid-cols-2">
            {{-- Left Column --}}
            <div class="space-y-6">
                {{-- Full Name --}}
                <div>
                    <x-form.label for="name">Full Name</x-form.label>
                    <x-form.input id="name" name="name" type="text" placeholder="Enter employee's full name"
                        value="{{ $employee->name ?? old('name') }}" />
                    <x-form.error name="name" />
                </div>

                {{-- Email Address --}}
                <div>
                    <x-form.label for="email">Email Address</x-form.label>
                    <x-form.input id="email" name="email" type="email" placeholder="Enter email address"
                        value="{{ $employee->email ?? old('email') }}" />
                    <x-form.error name="email" />
                </div>

                {{-- Phone Number --}}
                <div>
                    <x-form.label for="phone">Phone Number</x-form.label>
                    <x-form.input id="phone" name="phone" type="tel" placeholder="Enter phone number"
                        value="{{ $employee->phone ?? old('phone') }}" />
                    <x-form.error name="phone" />
                </div>
            </div>

            {{-- Right Column --}}
            <div class="space-y-6">
                {{-- Password --}}
                <div>
                    <x-form.label for="password">Password</x-form.label>
                    <x-form.input id="password" name="password" type="password" placeholder="Enter password" />
                    <x-form.error name="password" />
                    <p class="mt-1 text-sm text-gray-500">Password must be at least 8 characters long.</p>
                </div>

                {{-- Confirm Password --}}
                <div>
                    <x-form.label for="password_confirmation">Confirm Password</x-form.label>
                    <x-form.input id="password_confirmation" name="password_confirmation" type="password"
                        placeholder="Confirm password" />
                    <x-form.error name="password_confirmation" />
                </div>
            </div>
        </div>

        {{-- Submit Button --}}
        <div class="mt-8 flex items-center justify-end space-x-4 pt-6 border-t border-gray-200">
            <x-button-link href="{{ route('admin.employee.index') }}" text="Cancel" />
            <x-form.button type="submit" text="Edit Employee">
                <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                    <path
                        d="M6.41421 15.89L16.5563 5.74785L15.1421 4.33363L5 14.4758V15.89H6.41421ZM7.24264 17.89H3V13.6473L14.435 2.21231C14.8256 1.82179 15.4587 1.82179 15.8492 2.21231L18.6777 5.04074C19.0682 5.43126 19.0682 6.06443 18.6777 6.45495L7.24264 17.89ZM3 19.89H21V21.89H3V19.89Z" />
                </svg>
            </x-form.button>
        </div>
    </x-form.container>
@endsection
