@extends('layouts.auth-layout')
@section('header', 'Enter your email to resend verification link')
@section('form')
    <form action="{{ route('verification.resend') }}" method="POST">
        @csrf

        <div class="mt-4">
            <x-form.label for="email">Email Address</x-form.label>
            <x-form.input id="email" name="email" type="email" placeholder="Enter your email" />
        </div>

        <div class="mt-6">
            <x-form.button type="submit" text="Send Verification Link" class="w-full" />
        </div>

        <p class="mt-6 text-sm text-center text-gray-400">Already verified? Log in to your account.
            <a wire:navigate href="{{ route('login') }}"
                class="text-blue-500 focus:outline-none focus:underline hover:underline">
                Login
            </a>
        </p>
    </form>
@endsection
