@extends('layouts.app')
@section('main')
    {{-- Header --}}
    <x-page-header title="Dashboard">
        Welcome back <strong class="text-blue-600">{{ auth()->user()->name }}</strong>!
    </x-page-header>


@endsection
