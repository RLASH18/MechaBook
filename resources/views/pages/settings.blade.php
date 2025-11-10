@extends('layouts.app')
@section('main')
    {{-- Page Header --}}
    <div class="flex items-center justify-between mb-4">
        <div>
            <x-page-header title="Settings">
                Update your account information and preferences.
            </x-page-header>
        </div>
    </div>

    {{-- Livewire Modals --}}
    @livewire('settings.edit-social-links-modal')
    @livewire('settings.edit-profile-modal')
    @livewire('settings.edit-password-modal')
    @livewire('settings.delete-account-modal')

    {{-- Settings Container --}}
    <div class="overflow-hidden rounded-2xl border border-gray-200 bg-white p-5 lg:p-6">
        <h3 class="mb-5 text-lg font-semibold text-gray-800 lg:mb-7">
            Profile
        </h3>

        <div class="mb-6 rounded-2xl border border-gray-200 p-5 lg:p-6">
            <div class="flex flex-col gap-5 xl:flex-row xl:items-center xl:justify-between">
                <div class="flex w-full flex-col items-center gap-6 xl:flex-row">
                    {{-- Profile Avatar --}}
                    <div
                        class="h-20 w-20 overflow-hidden rounded-full border border-blue-600 bg-blue-100 flex items-center justify-center">
                        <span class="text-2xl font-bold text-blue-600">{{ strtoupper(substr($user->name, 0, 1)) }}</span>
                    </div>

                    {{-- User Info --}}
                    <div class="order-3 xl:order-2">
                        <h4 class="mb-2 text-center text-lg font-semibold text-gray-800 xl:text-left">
                            {{ $user->name }}
                        </h4>
                        <div class="flex flex-col items-center gap-1 text-center xl:flex-row xl:gap-3 xl:text-left">
                            <p class="text-sm text-gray-500">
                                {{ ucfirst($user->role->value) }}
                            </p>
                            <div class="hidden h-3.5 w-px bg-gray-300 xl:block"></div>
                            <p class="text-sm text-gray-500">
                                {{ $user->email }}
                            </p>
                        </div>
                    </div>

                    {{-- Social Media Links --}}
                    <div class="order-2 flex grow items-center gap-3 xl:order-3 xl:justify-end">
                        @php
                            $socialLinks = $user->activeSocialLinks->keyBy('platform');
                            $platforms = [
                                'facebook' => ['color' => 'text-blue-600', 'icon' => 'fab fa-facebook-f'],
                                'twitter' => ['color' => 'text-blue-400', 'icon' => 'fab fa-twitter'],
                                'linkedin' => ['color' => 'text-blue-700', 'icon' => 'fab fa-linkedin-in'],
                                'instagram' => ['color' => 'text-pink-600', 'icon' => 'fab fa-instagram'],
                                'youtube' => ['color' => 'text-red-600', 'icon' => 'fab fa-youtube'],
                                'github' => ['color' => 'text-gray-800', 'icon' => 'fab fa-github'],
                                'website' => ['color' => 'text-green-600', 'icon' => 'fas fa-globe']
                            ];
                        @endphp

                        @foreach($platforms as $platform => $config)
                            @php
                                $socialLink = $socialLinks->get($platform);
                            @endphp
                            @if($socialLink)
                                <a href="{{ $socialLink->url }}" target="_blank" rel="noopener noreferrer"
                                    class="flex h-11 w-11 items-center justify-center rounded-full border border-gray-300 bg-white {{ $config['color'] }} transition-all hover:border-gray-400 hover:bg-gray-50 hover:scale-105"
                                    title="Visit {{ ucfirst($platform) }}">
                                    <i class="{{ $config['icon'] }} text-lg"></i>
                                </a>
                            @else
                                <div class="flex h-11 w-11 items-center justify-center rounded-full border border-gray-200 bg-gray-50 text-gray-300"
                                    title="No {{ ucfirst($platform) }} link">
                                    <i class="{{ $config['icon'] }} text-lg"></i>
                                </div>
                            @endif
                        @endforeach
                    </div>
                </div>

                {{-- Update Links Button --}}
                <button onclick="Livewire.dispatch('openEditSocialLinksModal')"
                    class="shadow-theme-xs inline-flex items-center justify-center gap-1.5 rounded-full border border-blue-600 bg-blue-600 px-4 py-2 text-sm font-medium text-white cursor-pointer hover:bg-blue-700 transition-colors whitespace-nowrap">
                    <svg class="fill-current" width="15" height="15" xmlns="http://www.w3.org/2000/svg"
                        viewBox="0 0 24 24" fill="currentColor">
                        <path
                            d="M13.0607 8.11097L14.4749 9.52518C17.2086 12.2589 17.2086 16.691 14.4749 19.4247L14.1214 19.7782C11.3877 22.5119 6.95555 22.5119 4.22188 19.7782C1.48821 17.0446 1.48821 12.6124 4.22188 9.87874L5.6361 11.293C3.68348 13.2456 3.68348 16.4114 5.6361 18.364C7.58872 20.3166 10.7545 20.3166 12.7072 18.364L13.0607 18.0105C15.0133 16.0578 15.0133 12.892 13.0607 10.9394L11.6465 9.52518L13.0607 8.11097ZM19.7782 14.1214L18.364 12.7072C20.3166 10.7545 20.3166 7.58872 18.364 5.6361C16.4114 3.68348 13.2456 3.68348 11.293 5.6361L10.9394 5.98965C8.98678 7.94227 8.98678 11.1081 10.9394 13.0607L12.3536 14.4749L10.9394 15.8891L9.52518 14.4749C6.79151 11.7413 6.79151 7.30911 9.52518 4.57544L9.87874 4.22188C12.6124 1.48821 17.0446 1.48821 19.7782 4.22188C22.5119 6.95555 22.5119 11.3877 19.7782 14.1214Z" />
                    </svg>
                    Update Links
                </button>
            </div>
        </div>

        {{-- Personal Information Card --}}
        <div class="mb-6 rounded-2xl border border-gray-200 p-5 lg:p-6 ">
            <div class="flex flex-col gap-6 lg:flex-row lg:items-start lg:justify-between">
                <div>
                    <h4 class="text-lg font-semibold text-gray-800 lg:mb-6">
                        Personal Information
                    </h4>

                    <div class="grid grid-cols-1 gap-4 lg:grid-cols-2 lg:gap-7 2xl:gap-x-32">
                        <div>
                            <p class="mb-2 text-xs leading-normal text-gray-500">
                                Full Name
                            </p>
                            <p class="text-sm font-medium text-gray-800">
                                {{ $user->name }}
                            </p>
                        </div>

                        <div>
                            <p class="mb-2 text-xs leading-normal text-gray-500">
                                Role
                            </p>
                            <p class="text-sm font-medium text-gray-800">
                                {{ ucfirst($user->role->value) }}
                            </p>
                        </div>

                        <div>
                            <p class="mb-2 text-xs leading-normal text-gray-500">
                                Email address
                            </p>
                            <p class="text-sm font-medium text-gray-800">
                                {{ $user->email }}
                            </p>
                        </div>

                        <div>
                            <p class="mb-2 text-xs leading-normal text-gray-500">
                                Phone
                            </p>
                            <p class="text-sm font-medium text-gray-800">
                                {{ $user->phone ?? 'Not provided' }}
                            </p>
                        </div>
                    </div>
                </div>

                {{-- Edit Profile Button --}}
                <button onclick="Livewire.dispatch('openEditProfileModal')"
                    class="shadow-theme-xs inline-flex items-center justify-center gap-1.5 rounded-full border border-blue-600 bg-blue-600 px-4 py-2 text-sm font-medium text-white cursor-pointer hover:bg-blue-700 transition-colors whitespace-nowrap">
                    <svg class="fill-current" width="15" height="15" xmlns="http://www.w3.org/2000/svg"
                        viewBox="0 0 24 24" fill="currentColor">
                        <path
                            d="M4 22C4 17.5817 7.58172 14 12 14C16.4183 14 20 17.5817 20 22H18C18 18.6863 15.3137 16 12 16C8.68629 16 6 18.6863 6 22H4ZM12 13C8.685 13 6 10.315 6 7C6 3.685 8.685 1 12 1C15.315 1 18 3.685 18 7C18 10.315 15.315 13 12 13ZM12 11C14.21 11 16 9.21 16 7C16 4.79 14.21 3 12 3C9.79 3 8 4.79 8 7C8 9.21 9.79 11 12 11Z" />
                    </svg>
                    Edit Profile
                </button>
            </div>
        </div>

        {{-- Account Information Card --}}
        <div class="rounded-2xl border border-gray-200 p-5 lg:p-6 ">
            <div class="flex flex-col gap-6 lg:flex-row lg:items-start lg:justify-between">
                <div>
                    <h4 class="text-lg font-semibold text-gray-800 lg:mb-6">
                        Account Information
                    </h4>

                    <div class="grid grid-cols-1 gap-4 lg:grid-cols-2 lg:gap-7 2xl:gap-x-32">
                        <div>
                            <p class="mb-2 text-xs leading-normal text-gray-500">
                                User ID
                            </p>
                            <p class="text-sm font-medium text-gray-800">
                                #{{ $user->id }}
                            </p>
                        </div>

                        <div>
                            <p class="mb-2 text-xs leading-normal text-gray-500">
                                Account Created
                            </p>
                            <p class="text-sm font-medium text-gray-800">
                                {{ $user->created_at->format('M d, Y') }}
                            </p>
                        </div>

                        <div>
                            <p class="mb-2 text-xs leading-normal text-gray-500">
                                Last Updated
                            </p>
                            <p class="text-sm font-medium text-gray-800">
                                {{ $user->updated_at->format('M d, Y') }}
                            </p>
                        </div>

                        <div>
                            <p class="mb-2 text-xs leading-normal text-gray-500">
                                Status
                            </p>
                            <p class="text-sm font-medium text-blue-600">
                                Active
                            </p>
                        </div>
                    </div>
                </div>

                {{-- Action Buttons --}}
                <div class="flex flex-row gap-2">
                    {{-- Change Password Button --}}
                    <button onclick="Livewire.dispatch('openEditPasswordModal')"
                        class="shadow-theme-xs inline-flex items-center justify-center gap-1.5 rounded-full border border-blue-600 bg-blue-600 px-4 py-2 text-sm font-medium text-white cursor-pointer hover:bg-blue-700 transition-colors whitespace-nowrap">
                        <svg class="fill-current" width="15" height="15" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                            <path
                                d="M19 10H20C20.5523 10 21 10.4477 21 11V21C21 21.5523 20.5523 22 20 22H4C3.44772 22 3 21.5523 3 21V11C3 10.4477 3.44772 10 4 10H5V9C5 5.13401 8.13401 2 12 2C15.866 2 19 5.13401 19 9V10ZM5 12V20H19V12H5ZM11 14H13V18H11V14ZM17 10V9C17 6.23858 14.7614 4 12 4C9.23858 4 7 6.23858 7 9V10H17Z" />
                        </svg>
                        Change Password
                    </button>

                    {{-- Delete Account Button --}}
                    <button onclick="Livewire.dispatch('openDeleteAccountModal')"
                        class="shadow-theme-xs inline-flex items-center justify-center gap-1.5 rounded-full border border-red-600 bg-red-600 px-4 py-2 text-sm font-medium text-white cursor-pointer hover:bg-red-700 transition-colors whitespace-nowrap">
                        <svg class="fill-current" width="15" height="15" viewBox="0 0 18 18" fill="none"
                            xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd" clip-rule="evenodd"
                                d="M7.5 1.5C7.10218 1.5 6.72064 1.65804 6.43934 1.93934C6.15804 2.22064 6 2.60218 6 3V3.75H3.75C3.33579 3.75 3 4.08579 3 4.5C3 4.91421 3.33579 5.25 3.75 5.25H4.5V13.5C4.5 14.2956 4.81607 15.0587 5.37868 15.6213C5.94129 16.1839 6.70435 16.5 7.5 16.5H10.5C11.2956 16.5 12.0587 16.1839 12.6213 15.6213C13.1839 15.0587 13.5 14.2956 13.5 13.5V5.25H14.25C14.6642 5.25 15 4.91421 15 4.5C15 4.08579 14.6642 3.75 14.25 3.75H12V3C12 2.60218 11.842 2.22064 11.5607 1.93934C11.2794 1.65804 10.8978 1.5 10.5 1.5H7.5ZM7.5 6.75C7.91421 6.75 8.25 7.08579 8.25 7.5V12C8.25 12.4142 7.91421 12.75 7.5 12.75C7.08579 12.75 6.75 12.4142 6.75 12V7.5C6.75 7.08579 7.08579 6.75 7.5 6.75ZM10.5 6.75C10.9142 6.75 11.25 7.08579 11.25 7.5V12C11.25 12.4142 10.9142 12.75 10.5 12.75C10.0858 12.75 9.75 12.4142 9.75 12V7.5C9.75 7.08579 10.0858 6.75 10.5 6.75Z"
                                fill=""></path>
                        </svg>
                        Delete Account
                    </button>
                </div>
            </div>
        </div>
    </div>
@endsection
