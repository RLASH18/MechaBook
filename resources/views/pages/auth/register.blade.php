@extends('layouts.auth-layout')
@section('header', 'Register to create your account')
@section('form')
    <form action="{{ route('register.store') }}" method="POST">
        @csrf

        {{-- Name Field --}}
        <div class="mt-4">
            <x-form.label for="name">Name</x-form.label>
            <x-form.input id="name" name="name" type="name" placeholder="Enter your name" />
            <x-form.error name="name" />
        </div>

        {{-- Email Field --}}
        <div class="mt-4">
            <x-form.label for="email">Email Address</x-form.label>
            <x-form.input id="email" name="email" type="email" placeholder="Enter your email" />
            <x-form.error name="email" />
        </div>

        {{-- Password Field --}}
        <div class="mt-4">
            <x-form.label for="password">Password</x-form.label>
            <x-form.input id="password" name="password" type="password" placeholder="Enter your password" />
            <x-form.error name="password" />
        </div>

        {{-- Password Confirmation Field --}}
        <div class="mt-4">
            <x-form.label for="password_confirmation">Confirm Password</x-form.label>
            <x-form.input id="password_confirmation" name="password_confirmation" type="password"
                placeholder="Enter your password again" />
            <x-form.error name="password_confirmation" />
        </div>

        {{-- Sign Up Button --}}
        <div class="mt-6">
            <x-form.button type="submit" text="Register" class="w-full" />
        </div>

        {{-- Footer --}}
        <p class="mt-6 text-sm text-center text-gray-400">Already have an account?
            <a wire:navigate href="{{ route('login') }}" class="text-blue-600 focus:outline-none focus:underline hover:underline">Login</a>.
        </p>
    </form>
@endsection
