@extends('layouts.auth-layout')

@section('form')
    <form action="{{ route('login.store') }}" method="POST">
        @csrf

        {{-- Email Field --}}
        <div class="mt-4">
            <x-form.label for="email">Email Address</x-form.label>
            <x-form.input id="email" name="email" type="email" placeholder="Enter your email" />
            <x-form.error name="email" />
        </div>

        {{-- Password Field --}}
        <div class="mt-4">
            <div class="flex justify-between">
                <x-form.label for="password">Password</x-form.label>
                <a href="#" class="text-xs text-blue-600 hover:underline">Forgot Password?</a>
            </div>
            <x-form.input id="password" name="password" type="password" placeholder="Enter your password" />
            <x-form.error name="password" />
        </div>

        {{-- Sign In Button --}}
        <div class="mt-6">
            <x-form.button type="submit" text="Login" class="w-full" />
        </div>

        {{-- Footer --}}
        <p class="mt-6 text-sm text-center text-gray-400">Don&#x27;t have an account yet?
            <a wire:navigate href="{{ route('register') }}" class="text-blue-500 focus:outline-none focus:underline hover:underline">Signup</a>.
        </p>
    </form>
@endsection
