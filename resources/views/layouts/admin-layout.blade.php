<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    @include('partials.head')
    @livewireStyles
</head>

<body>
    <div class="flex h-screen">
        {{-- Sidebar --}}
        @include('partials.admin.sidebar')

        {{-- Main Content Area --}}
        <div class="flex flex-col flex-1">

            {{-- Navbar --}}
            @include('partials.navbar')

            {{-- Page Content --}}
            <main class="flex-1 p-6 bg-gray-50 overflow-y-auto text-gray-800">
                @yield('main')
            </main>

        </div>
    </div>

    {{-- Livewire Script --}}
    @livewireScripts
</body>
</html>
