@extends('layouts.app')
@section('main')
    {{-- Header --}}
    <div class="flex items-center justify-between mb-4">
        <div>
            <x-page-header title="Book Appointment">
                Let’s get your next service booked.
            </x-page-header>
        </div>
    </div>

    @livewire('customer.book-appointment.book-index')
    @livewire('customer.book-appointment.book-actions')
@endsection
