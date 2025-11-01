@extends('layouts.app')
@section('main')
    {{-- Page Header --}}
    <x-page-header title="Settings">
        Update your account information and preferences.
    </x-page-header>

    {{-- Livewire Modals --}}
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
                        <button
                            class="flex h-11 w-11 items-center justify-center rounded-full border border-gray-300 bg-white text-gray-600 transition-all hover:border-gray-400 hover:bg-gray-50 hover:text-gray-800">
                            <svg class="fill-current" width="18" height="18" viewBox="0 0 20 20" fill="none"
                                xmlns="http://www.w3.org/2000/svg">
                                <path
                                    d="M11.6666 11.2503H13.7499L14.5833 7.91699H11.6666V6.25033C11.6666 5.39251 11.6666 4.58366 13.3333 4.58366H14.5833V1.78374C14.3118 1.7477 13.2858 1.66699 12.2023 1.66699C9.94025 1.66699 8.33325 3.04771 8.33325 5.58342V7.91699H5.83325V11.2503H8.33325V18.3337H11.6666V11.2503Z"
                                    fill=""></path>
                            </svg>
                        </button>

                        <button
                            class="flex h-11 w-11 items-center justify-center rounded-full border border-gray-300 bg-white text-gray-600 transition-all hover:border-gray-400 hover:bg-gray-50 hover:text-gray-800">
                            <svg class="fill-current" width="18" height="18" viewBox="0 0 20 20" fill="none"
                                xmlns="http://www.w3.org/2000/svg">
                                <path
                                    d="M15.1708 1.875H17.9274L11.9049 8.75833L18.9899 18.125H13.4424L9.09742 12.4442L4.12578 18.125H1.36745L7.80912 10.7625L1.01245 1.875H6.70078L10.6283 7.0675L15.1708 1.875ZM14.2033 16.475H15.7308L5.87078 3.43833H4.23162L14.2033 16.475Z"
                                    fill=""></path>
                            </svg>
                        </button>

                        <button
                            class="flex h-11 w-11 items-center justify-center rounded-full border border-gray-300 bg-white text-gray-600 transition-all hover:border-gray-400 hover:bg-gray-50 hover:text-gray-800">
                            <svg class="fill-current" width="18" height="18" viewBox="0 0 20 20" fill="none"
                                xmlns="http://www.w3.org/2000/svg">
                                <path
                                    d="M5.78381 4.16645C5.78351 4.84504 5.37181 5.45569 4.74286 5.71045C4.11391 5.96521 3.39331 5.81321 2.92083 5.32613C2.44836 4.83904 2.31837 4.11413 2.59216 3.49323C2.86596 2.87233 3.48886 2.47942 4.16715 2.49978C5.06804 2.52682 5.78422 3.26515 5.78381 4.16645ZM5.83381 7.06645H2.50048V17.4998H5.83381V7.06645ZM11.1005 7.06645H7.78381V17.4998H11.0672V12.0248C11.0672 8.97475 15.0422 8.69142 15.0422 12.0248V17.4998H18.3338V10.8914C18.3338 5.74978 12.4505 5.94145 11.0672 8.46642L11.1005 7.06645Z"
                                    fill=""></path>
                            </svg>
                        </button>

                        <button
                            class="flex h-11 w-11 items-center justify-center rounded-full border border-gray-300 bg-white text-gray-600 transition-all hover:border-gray-400 hover:bg-gray-50 hover:text-gray-800">
                            <svg class="fill-current" width="18" height="18" viewBox="0 0 20 20" fill="none"
                                xmlns="http://www.w3.org/2000/svg">
                                <path
                                    d="M10.8567 1.66699C11.7946 1.66854 12.2698 1.67351 12.6805 1.68573L12.8422 1.69102C13.0291 1.69766 13.2134 1.70599 13.4357 1.71641C14.3224 1.75738 14.9273 1.89766 15.4586 2.10391C16.0078 2.31572 16.4717 2.60183 16.9349 3.06503C17.3974 3.52822 17.6836 3.99349 17.8961 4.54141C18.1016 5.07197 18.2419 5.67753 18.2836 6.56433C18.2935 6.78655 18.3015 6.97088 18.3081 7.15775L18.3133 7.31949C18.3255 7.73011 18.3311 8.20543 18.3328 9.1433L18.3335 9.76463C18.3336 9.84055 18.3336 9.91888 18.3336 9.99972L18.3335 10.2348L18.333 10.8562C18.3314 11.794 18.3265 12.2694 18.3142 12.68L18.3089 12.8417C18.3023 13.0286 18.294 13.213 18.2836 13.4351C18.2426 14.322 18.1016 14.9268 17.8961 15.458C17.6842 16.0074 17.3974 16.4713 16.9349 16.9345C16.4717 17.397 16.0057 17.6831 15.4586 17.8955C14.9273 18.1011 14.3224 18.2414 13.4357 18.2831C13.2134 18.293 13.0291 18.3011 12.8422 18.3076L12.6805 18.3128C12.2698 18.3251 11.7946 18.3306 10.8567 18.3324L10.2353 18.333C10.1594 18.333 10.0811 18.333 10.0002 18.333H9.76516L9.14375 18.3325C8.20591 18.331 7.7306 18.326 7.31997 18.3137L7.15824 18.3085C6.97136 18.3018 6.78703 18.2935 6.56481 18.2831C5.67801 18.2421 5.07384 18.1011 4.5419 17.8955C3.99328 17.6838 3.5287 17.397 3.06551 16.9345C2.60231 16.4713 2.3169 16.0053 2.1044 15.458C1.89815 14.9268 1.75856 14.322 1.7169 13.4351C1.707 13.213 1.69892 13.0286 1.69238 12.8417L1.68714 12.68C1.67495 12.2694 1.66939 11.794 1.66759 10.8562L1.66748 9.1433C1.66903 8.20543 1.67399 7.73011 1.68621 7.31949L1.69151 7.15775C1.69815 6.97088 1.70648 6.78655 1.7169 6.56433C1.75786 5.67683 1.89815 5.07266 2.1044 4.54141C2.3162 3.9928 2.60231 3.52822 3.06551 3.06503C3.5287 2.60183 3.99398 2.31641 4.5419 2.10391C5.07315 1.89766 5.67731 1.75808 6.56481 1.71641C6.78703 1.70652 6.97136 1.69844 7.15824 1.6919L7.31997 1.68666C7.7306 1.67446 8.20591 1.6689 9.14375 1.6671L10.8567 1.66699ZM10.0002 5.83308C7.69781 5.83308 5.83356 7.69935 5.83356 9.99972C5.83356 12.3021 7.69984 14.1664 10.0002 14.1664C12.3027 14.1664 14.1669 12.3001 14.1669 9.99972C14.1669 7.69732 12.3006 5.83308 10.0002 5.83308ZM10.0002 7.49974C11.381 7.49974 12.5002 8.61863 12.5002 9.99972C12.5002 11.3805 11.3813 12.4997 10.0002 12.4997C8.6195 12.4997 7.50023 11.3809 7.50023 9.99972C7.50023 8.61897 8.61908 7.49974 10.0002 7.49974ZM14.3752 4.58308C13.8008 4.58308 13.3336 5.04967 13.3336 5.62403C13.3336 6.19841 13.8002 6.66572 14.3752 6.66572C14.9496 6.66572 15.4169 6.19913 15.4169 5.62403C15.4169 5.04967 14.9488 4.58236 14.3752 4.58308Z"
                                    fill=""></path>
                            </svg>
                        </button>
                    </div>
                </div>

                {{-- Update Links Button --}}
                <button onclick="Livewire.dispatch('openEditProfileModal')"
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
