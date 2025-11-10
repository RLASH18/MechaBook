<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    @include('partials.head')
    @livewireStyles
</head>

<body>
    <div class="bg-white">
        <div class="flex justify-center h-screen">
            {{-- Left Side Panel --}}
            @include('partials.auth.left-panel')

            {{-- Right Side Form --}}
            <div class="flex items-center w-full max-w-md px-6 mx-auto lg:w-2/5">
                <div class="flex-1">
                    <div class="text-center">
                        <div class="flex justify-center mx-auto">
                            <img class="w-auto h-18 sm:h-20" src="{{ asset('img/mecha-book-logo-removebg.png') }}"
                                alt="MechaBook Logo">
                        </div>

                        <p class="mt-3 text-gray-500">
                            @yield('header')
                        </p>
                    </div>

                    {{-- Google login/register Button --}}
                    @if (request()->routeIs('login') || request()->routeIs('register'))
                        @include('partials.auth.google-button')

                        {{-- Divider --}}
                        <div class="flex items-center mt-6 mb-6">
                            <div class="flex-1 border-t border-gray-300"></div>
                            <span class="px-4 text-sm text-gray-500">OR</span>
                            <div class="flex-1 border-t border-gray-300"></div>
                        </div>
                    @endif

                    <div class="mt-8">
                        {{-- Session Messages --}}
                        @include('partials.auth.session-messages')

                        @yield('form')
                    </div>
                </div>
            </div>
        </div>
    </div>

    @livewireScripts
</body>

</html>
