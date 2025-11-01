@extends('layouts.app')
@section('main')
    <div class="flex items-center justify-between mb-4">
        <div>
            <x-page-header title="Appointmets">
                Manage customer appointments, assign employees, and update status
            </x-page-header>
        </div>
    </div>

    @livewire('admin.appointment.appointment-index')
@endsection
