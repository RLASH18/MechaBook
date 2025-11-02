@extends('layouts.app')
@section('main')
    {{-- Header --}}
    <div class="flex items-center justify-between mb-4">
        <div>
            <x-page-header title="Add New Employee">
                Fill out the form below to register a new employee in the system.
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

    {{-- Status Info --}}
    <div class="bg-blue-50 border border-blue-200 rounded-lg p-4 mb-4">
        <div class="flex items-center">
            <svg class="w-5 h-5 text-blue-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
            <div>
                <h4 class="text-sm font-medium text-blue-900">Employee Account</h4>
                <p class="text-sm text-blue-700">This user will be created with employee privileges.</p>
            </div>
        </div>
    </div>

    {{-- Form Container --}}
    <x-form.container action="{{ route('admin.employee.store') }}">
        <div class="grid grid-cols-1 gap-6 lg:grid-cols-2">
            {{-- Left Column --}}
            <div class="space-y-6">
                {{-- Full Name --}}
                <div>
                    <x-form.label for="name">Full Name <span class="text-red-500">*</x-form.label>
                    <x-form.input id="name" name="name" type="text" placeholder="Enter employee's full name"
                        value="{{ old('name') }}" />
                    <x-form.error name="name" />
                </div>

                {{-- Email Address --}}
                <div>
                    <x-form.label for="email">Email Address <span class="text-red-500">*</x-form.label>
                    <x-form.input id="email" name="email" type="email" placeholder="Enter email address"
                        value="{{ old('email') }}" />
                    <x-form.error name="email" />
                </div>

                {{-- Phone Number --}}
                <div>
                    <x-form.label for="phone">Phone Number</x-form.label>
                    <x-form.input id="phone" name="phone" type="tel" placeholder="Enter phone number"
                        value="{{ old('phone') }}" />
                    <x-form.error name="phone" />
                </div>
            </div>

            {{-- Right Column --}}
            <div class="space-y-6">
                {{-- Password --}}
                <div>
                    <x-form.label for="password">Password <span class="text-red-500">*</x-form.label>
                    <x-form.input id="password" name="password" type="password" placeholder="Enter password" />
                    <x-form.error name="password" />
                    <p class="mt-1 text-sm text-gray-500">Password must be at least 8 characters long.</p>
                </div>

                {{-- Confirm Password --}}
                <div>
                    <x-form.label for="password_confirmation">Confirm Password <span class="text-red-500">*</x-form.label>
                    <x-form.input id="password_confirmation" name="password_confirmation" type="password"
                        placeholder="Confirm password" />
                    <x-form.error name="password_confirmation" />
                </div>
            </div>
        </div>

        {{-- Submit Button --}}
        <div class="mt-8 flex items-center justify-end space-x-4 pt-6 border-t border-gray-200">
            <x-button-link href="{{ route('admin.employee.index') }}" text="Cancel" />
            <x-form.button type="submit" text="Add Employee">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                </svg>
            </x-form.button>
        </div>
    </x-form.container>
@endsection
