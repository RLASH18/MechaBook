@extends('layouts.app')
@section('main')
    <div class="flex items-center justify-between mb-4">
        <div>
            <x-page-header title="Appointments">
                Manage customer appointments, assign employees, and update status
            </x-page-header>
        </div>
    </div>

    @livewire('admin.appointment.appointment-index')
    @livewire('admin.appointment.appointment-actions')
@endsection
