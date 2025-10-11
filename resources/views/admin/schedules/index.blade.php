@extends('layouts.admin-layout')
@section('main')
    {{-- Header --}}
    <div class="flex items-center justify-between mb-6">
        <div>
            <x-page-header title="Schedule">
                View, add, and edit employee work schedules efficiently.
            </x-page-header>
        </div>
    </div>

    @livewire('admin.schedule.schedule-index')
@endsection
