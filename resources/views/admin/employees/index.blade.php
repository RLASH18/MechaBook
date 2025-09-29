@extends('layouts.admin-layout')
@section('main')
    {{-- Header --}}
    <div class="flex items-center justify-between mb-4">
        <div>
            <x-page-header title="Employee">
                Manage and view all registered employees here.
            </x-page-header>
        </div>

        <div>
            <x-button-link href="{{ route('admin.employee.create') }}" text="Add Employee" class="text-white bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-500">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                    stroke="currentColor" class="w-5 h-5 mr-2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                </svg>
            </x-button-link>
        </div>
    </div>

    @livewire('admin.employee-index')
@endsection
