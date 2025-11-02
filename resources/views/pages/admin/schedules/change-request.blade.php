@extends('layouts.app')
@section('main')
    {{-- Header --}}
    <div class="flex items-center justify-between mb-6">
        <div>
            <x-page-header title="Schedule Change Requests">
                Review and manage employee schedule change requests.
            </x-page-header>
        </div>
    </div>

    @livewire('admin.schedule-change-request.request-index')
@endsection
