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
            <div class="hidden lg:flex lg:w-3/5 relative overflow-hidden animated-bg">
                {{-- Enhanced Overlay --}}
                <div class="absolute inset-0 bg-gradient-to-br from-blue-900/30 via-transparent to-black/40"></div>

                {{-- Floating Elements --}}
                <div class="absolute top-20 left-20 w-32 h-32 bg-white/10 rounded-full blur-xl floating"></div>
                <div class="absolute bottom-32 right-16 w-24 h-24 bg-blue-300/20 rounded-lg rotate-45 floating"
                    style="animation-delay: -2s;"></div>

                {{-- Your existing content with enhancements --}}
                <div class="relative flex items-center justify-center w-full px-12 lg:px-16 xl:px-20">
                    <div class="max-w-lg text-center lg:text-left">
                        {{-- Glowing Title --}}
                        <h1
                            class="text-4xl lg:text-5xl xl:text-6xl font-bold text-white mb-4 leading-tight drop-shadow-2xl">
                            <span
                                class="block bg-gradient-to-r from-white via-blue-100 to-white bg-clip-text">MechaBook</span>
                        </h1>

                        {{-- Subtitle with underline --}}
                        <div class="mb-6">
                            <h2 class="text-xl lg:text-2xl font-semibold text-blue-100">
                                Car Repair Appointment System
                            </h2>
                            <div class="mt-2 h-1 w-24 bg-gradient-to-r from-blue-400 to-white rounded-full"></div>
                        </div>

                        {{-- Glassmorphism description --}}
                        <p
                            class="text-base lg:text-lg text-blue-50 mb-8 leading-relaxed backdrop-blur-sm bg-white/5 p-4 rounded-lg border border-white/10">
                            MechaBook is a web-based scheduling platform designed for car repair shops to manage
                            mechanics, services, and customer appointments efficiently.
                        </p>

                        {{-- Features List --}}
                        <div class="space-y-4 text-left">
                            <div class="flex items-center space-x-3">
                                <div
                                    class="w-3 h-3 bg-gradient-to-r from-blue-400 to-blue-200 rounded-full group-hover:scale-125 transition-transform duration-300">
                                </div>
                                <span class="text-blue-100">Online service booking and scheduling</span>
                            </div>
                            <div class="flex items-center space-x-3">
                                <div
                                    class="w-3 h-3 bg-gradient-to-r from-blue-400 to-blue-200 rounded-full group-hover:scale-125 transition-transform duration-300">
                                </div>
                                <span class="text-blue-100">Real-time mechanic availability</span>
                            </div>
                            <div class="flex items-center space-x-3">
                                <div
                                    class="w-3 h-3 bg-gradient-to-r from-blue-400 to-blue-200 rounded-full group-hover:scale-125 transition-transform duration-300">
                                </div>
                                <span class="text-blue-100">Complete admin control & service records</span>
                            </div>
                            <div class="flex items-center space-x-3">
                                <div
                                    class="w-3 h-3 bg-gradient-to-r from-blue-400 to-blue-200 rounded-full group-hover:scale-125 transition-transform duration-300">
                                </div>
                                <span class="text-blue-100">Streamlined customer experience</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Right Side Form --}}
            <div class="flex items-center w-full max-w-md px-6 mx-auto lg:w-2/5">
                <div class="flex-1">
                    <div class="text-center">
                        <div class="flex justify-center mx-auto">
                            <img class="w-auto h-18 sm:h-20" src="{{ asset('img/mecha-book-logo-removebg.png') }}"
                                alt="MechaBook Logo">
                        </div>

                        @if (request()->is('login'))
                            <p class="mt-3 text-gray-500">Login to access your account</p>
                        @else
                            <p class="mt-3 text-gray-500">Register to create your account</p>
                        @endif
                    </div>

                    {{-- Google login/register Button --}}
                    <a href="{{ route('google.redirect') }}"
                        class="flex items-center justify-center w-full px-4 py-3 mt-6 text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-blue-50 hover:border-blue-400 hover:shadow-md transition-all duration-200 group">
                        <svg class="w-5 h-5 mr-3" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path
                                d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z"
                                fill="#4285F4" />
                            <path
                                d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z"
                                fill="#34A853" />
                            <path
                                d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l2.85-2.22.81-.62z"
                                fill="#FBBC05" />
                            <path
                                d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z"
                                fill="#EA4335" />
                        </svg>
                        <span class="font-medium group-hover:text-blue-600 transition-colors">
                            {{ request()->is('login') ? 'Login with Google' : 'Register with Google' }}
                        </span>
                    </a>

                    {{-- Divider --}}
                    <div class="flex items-center mt-6 mb-6">
                        <div class="flex-1 border-t border-gray-300"></div>
                        <span class="px-4 text-sm text-gray-500">OR</span>
                        <div class="flex-1 border-t border-gray-300"></div>
                    </div>

                    <div class="mt-8">
                        {{-- Session Messages --}}
                        @if (session('auth_success'))
                            <div class="mt-4 flex items-center p-3 text-sm text-green-700 bg-green-100 rounded-lg shadow-sm">
                                <svg class="w-5 h-5 mr-2 flex-shrink-0" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M5 13l4 4L19 7" />
                                </svg>
                                <span>{{ session('auth_success') }}</span>
                            </div>
                        @endif
                        @if (session('auth_error'))
                            <div class="mt-4 flex items-center p-3 text-sm text-red-700 bg-red-100 rounded-lg shadow-sm">
                                <svg class="w-5 h-5 mr-2 flex-shrink-0" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M6 18L18 6M6 6l12 12" />
                                </svg>
                                <span>{{ session('auth_error') }}</span>
                            </div>
                        @endif
                        @if (session('auth_info'))
                            <div class="mt-4 flex items-center p-3 text-sm text-blue-700 bg-blue-100 rounded-lg shadow-sm">
                                <svg class="w-5 h-5 mr-2 flex-shrink-0" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M6 18L18 6M6 6l12 12" />
                                </svg>
                                <span>{{ session('auth_info') }}</span>
                            </div>
                        @endif

                        @yield('form')
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Livewire Script --}}
    @livewireScripts
</body>

</html>
