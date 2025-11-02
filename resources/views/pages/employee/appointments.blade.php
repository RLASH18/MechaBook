@extends('layouts.app')
@section('main')
    <div class="flex items-center justify-between mb-4">
        <div>
            <x-page-header title="Appointmets">
                Manage your assigned appointments and update their status
            </x-page-header>
        </div>
    </div>

    @livewire('employee.appointment.appointment-index')
    @livewire('employee.appointment.appointment-actions')
@endsection
