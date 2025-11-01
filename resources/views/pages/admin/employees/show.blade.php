@extends('layouts.app')
@section('main')
    {{-- Header --}}
    <div class="flex items-center justify-between mb-4">
        <div>
            <x-page-header title="Employee Details">
                View detailed information about this employee.
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

    {{-- Employee Status Info --}}
    <div class="bg-green-50 border border-green-200 rounded-lg p-4 mb-4">
        <div class="flex items-center">
            <svg class="w-5 h-5 text-green-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
            </svg>
            <div>
                <h4 class="text-sm font-medium text-green-900">Employee Account</h4>
                <p class="text-sm text-green-700">This user has employee privileges and access to the system.</p>
            </div>
        </div>
    </div>

    <div class="overflow-hidden rounded-2xl border border-gray-200 bg-white shadow">
        <div class="p-6">
            <div class="grid grid-cols-1 gap-6 lg:grid-cols-2">
                {{-- Left Column --}}
                <div class="space-y-6">
                    {{-- Full Name --}}
                    <div>
                        <x-form.label>Full Name</x-form.label>
                        <div class="block w-full px-4 py-2 text-gray-900 bg-gray-50 border border-gray-300 rounded-lg">
                            {{ $employee->name }}
                        </div>
                    </div>

                    {{-- Email Address --}}
                    <div>
                        <x-form.label>Email Address</x-form.label>
                        <div class="block w-full px-4 py-2 text-gray-900 bg-gray-50 border border-gray-300 rounded-lg">
                            {{ $employee->email }}
                        </div>
                    </div>

                    {{-- Phone Number --}}
                    <div>
                        <x-form.label>Phone Number</x-form.label>
                        <div class="block w-full px-4 py-2 text-gray-900 bg-gray-50 border border-gray-300 rounded-lg">
                            {{ $employee->phone ?? 'Not provided' }}
                        </div>
                    </div>
                </div>

                {{-- Right Column --}}
                <div class="space-y-6">
                    {{-- Employee ID --}}
                    <div>
                        <x-form.label>Employee ID</x-form.label>
                        <div class="block w-full px-4 py-2 text-gray-900 bg-gray-50 border border-gray-300 rounded-lg">
                            EMP-{{ str_pad($employee->id, 4, '0', STR_PAD_LEFT) }}
                        </div>
                    </div>

                    {{-- Role --}}
                    <div>
                        <x-form.label>Role</x-form.label>
                        <div class="block w-full px-4 py-2 text-gray-900 bg-gray-50 border border-gray-300 rounded-lg">
                            <span
                                class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                {{ $employee->role }}
                            </span>
                        </div>
                    </div>

                    {{-- Account Created --}}
                    <div>
                        <x-form.label>Account Created</x-form.label>
                        <div class="block w-full px-4 py-2 text-gray-900 bg-gray-50 border border-gray-300 rounded-lg">
                            {{ $employee->created_at->format('M d, Y \a\t g:i A') }}
                        </div>
                    </div>
                </div>
            </div>

            {{-- Additional Information --}}
            <div class="mt-8 pt-6 border-t border-gray-200">
                <h3 class="text-lg font-medium text-gray-900 mb-4">Additional Information</h3>
                <div class="grid grid-cols-1 gap-6 lg:grid-cols-2">
                    {{-- Last Updated --}}
                    <div>
                        <x-form.label>Last Updated</x-form.label>
                        <div class="block w-full px-4 py-2 text-gray-900 bg-gray-50 border border-gray-300 rounded-lg">
                            {{ $employee->updated_at->format('M d, Y \a\t g:i A') }}
                        </div>
                    </div>

                    {{-- Email Verification --}}
                    <div>
                        <x-form.label>Email Verification</x-form.label>
                        <div class="block w-full px-4 py-2 text-gray-900 bg-gray-50 border border-gray-300 rounded-lg">
                            @if ($employee->email_verified_at)
                                <span
                                    class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                    Verified on {{ $employee->email_verified_at->format('M d, Y') }}
                                </span>
                            @else
                                <span
                                    class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                                    Not Verified
                                </span>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            {{-- Action Buttons --}}
            <div class="mt-8 flex items-center justify-end space-x-4 pt-6 border-t border-gray-200">
                <form action="{{ route('admin.employee.destroy', $employee->id) }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <x-form.button type="submit" text="Delete Employee"
                        class="!bg-red-600 hover:!bg-red-700 focus:!ring-red-500">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16">
                            </path>
                        </svg>
                    </x-form.button>
                </form>
                <x-button-link href="{{ route('admin.employee.edit', $employee->id) }}" text="Edit Employee"
                    class="!bg-green-600 hover:!bg-green-700 focus:!ring-green-500 focus:!border-green-600 focus-visible:!ring-green-600 active:!ring-green-600 text-white">
                    <svg class="w-4 h-4 mr-2" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                        <path
                            d="M6.41421 15.89L16.5563 5.74785L15.1421 4.33363L5 14.4758V15.89H6.41421ZM7.24264 17.89H3V13.6473L14.435 2.21231C14.8256 1.82179 15.4587 1.82179 15.8492 2.21231L18.6777 5.04074C19.0682 5.43126 19.0682 6.06443 18.6777 6.45495L7.24264 17.89ZM3 19.89H21V21.89H3V19.89Z" />
                    </svg>
                </x-button-link>
            </div>
        </div>
    </div>
@endsection
