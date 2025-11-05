@extends('layouts.app')
@section('main')
    {{-- Header --}}
    <div class="flex items-center justify-between mb-4">
        <div>
            <x-page-header title="Dashboard">
                Welcome back <strong class="text-blue-600">{{ auth()->user()->name }}</strong>!
            </x-page-header>
        </div>
    </div>

@endsection
