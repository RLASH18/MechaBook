@extends('layouts.auth-layout')
@section('header', 'Set a new password for your account')
@section('form')
    <form action="{{ route('password.update') }}" method="POST">
        @csrf

        <x-form.input id="email" name="token" type="hidden" placeholder="Enter your email" value="{{ $token }}" />
        <x-form.input id="email" name="email" type="hidden" placeholder="Enter your email" value="{{ $email }}" />

        <div class="mt-4">
            <x-form.label for="password">New Password</x-form.label>
            <x-form.input id="password" name="password" type="password" placeholder="Enter your new password" />
        </div>

        <div class="mt-4">
            <x-form.label for="password_confirmation">Confirm new password</x-form.label>
            <x-form.input id="password_confirmation" name="password_confirmation" type="password" placeholder="Enter your new confirm password" />
        </div>

        <div class="mt-6">
            <x-form.button type="submit" text="Reset Password" class="w-full" />
        </div>
    </form>
@endsection
