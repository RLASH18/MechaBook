<aside class="flex flex-col w-64 flex-shrink-0 px-5 py-8 overflow-y-auto bg-blue-600">
    {{-- Logo Section --}}
    <div class="flex items-center justify-center mb-2 -mt-4">
        <a wire:navigate href="{{ route('customer.dashboard') }}" class="block">
            <img class="w-auto h-16" src="{{ asset('img/mecha-book-icon-removebg.png') }}" alt="MechaBook">
        </a>
    </div>

    <div class="flex flex-col justify-between flex-1 mt-6">
        <nav class="-mx-3 space-y-6 ">
            <div class="space-y-3">
                <label class="px-3 text-xs text-blue-200 uppercase dark:text-gray-400">analytics</label>

                {{-- Dashboard --}}
                <a wire:navigate href="{{ route('customer.dashboard') }}"
                    class="flex items-center px-3 py-2 rounded-lg transition-colors duration-300 transform {{ request()->routeIs('customer.dashboard') ? 'bg-white text-blue-600' : 'text-gray-300 hover:bg-gray-400 hover:text-gray-900' }}">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-5 h-5">
                        <path
                            d="M14 21C13.4477 21 13 20.5523 13 20V12C13 11.4477 13.4477 11 14 11H20C20.5523 11 21 11.4477 21 12V20C21 20.5523 20.5523 21 20 21H14ZM4 13C3.44772 13 3 12.5523 3 12V4C3 3.44772 3.44772 3 4 3H10C10.5523 3 11 3.44772 11 4V12C11 12.5523 10.5523 13 10 13H4ZM9 11V5H5V11H9ZM4 21C3.44772 21 3 20.5523 3 20V16C3 15.4477 3.44772 15 4 15H10C10.5523 15 11 15.4477 11 16V20C11 20.5523 10.5523 21 10 21H4ZM5 19H9V17H5V19ZM15 19H19V13H15V19ZM13 4C13 3.44772 13.4477 3 14 3H20C20.5523 3 21 3.44772 21 4V8C21 8.55228 20.5523 9 20 9H14C13.4477 9 13 8.55228 13 8V4ZM15 5V7H19V5H15Z" />
                    </svg>
                    <span class="mx-2 text-sm font-medium">Dashboard</span>
                </a>
            </div>

            <div class="space-y-3">
                <label class="px-3 text-xs text-blue-200 uppercase dark:text-gray-400">Management</label>

                {{-- Boook Appointment --}}
                <a wire:navigate href="{{ route('customer.appointments.book') }}"
                    class="flex items-center px-3 py-2 rounded-lg transition-colors duration-300 transform {{ request()->routeIs('customer.appointments.book') ? 'bg-white text-blue-600' : 'text-gray-300 hover:bg-gray-400 hover:text-gray-900' }}">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                        class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                        class="lucide lucide-notebook-pen-icon lucide-notebook-pen">
                        <path d="M13.4 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2v-7.4" /><path d="M2 6h4" /><path d="M2 10h4" />
                        <path d="M2 14h4" /><path d="M2 18h4" />
                        <path
                            d="M21.378 5.626a1 1 0 1 0-3.004-3.004l-5.01 5.012a2 2 0 0 0-.506.854l-.837 2.87a.5.5 0 0 0 .62.62l2.87-.837a2 2 0 0 0 .854-.506z" />
                    </svg>
                    <span class="mx-2 text-sm font-medium">Book Appointment</span>
                </a>

                {{-- Appointment --}}
                <a wire:navigate href="{{ route('customer.appointments.index') }}"
                    class="flex items-center px-3 py-2 rounded-lg transition-colors duration-300 transform {{ request()->routeIs('customer.appointments.index') ? 'bg-white text-blue-600' : 'text-gray-300 hover:bg-gray-400 hover:text-gray-900' }}">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" class="w-5 h-5"
                        fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                        class="lucide lucide-list-icon lucide-list">
                        <path d="M3 5h.01" /><path d="M3 12h.01" /><path d="M3 19h.01" /><path d="M8 5h13" />
                        <path d="M8 12h13" /><path d="M8 19h13" />
                    </svg>
                    <span class="mx-2 text-sm font-medium">My Appointments</span>
                </a>
            </div>

            <div class="space-y-3">
                <label class="px-3 text-xs text-blue-200 uppercase dark:text-gray-400">Configuration</label>

                {{-- Settings --}}
                <a wire:navigate href="{{ route('customer.settings') }}"
                    class="flex items-center px-3 py-2 rounded-lg transition-colors duration-300 transform {{ request()->routeIs('customer.settings') ? 'bg-white text-blue-600' : 'text-gray-300 hover:bg-gray-400 hover:text-gray-900' }}">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-5 h-5">
                        <path
                            d="M8.68637 4.00008L11.293 1.39348C11.6835 1.00295 12.3167 1.00295 12.7072 1.39348L15.3138 4.00008H19.0001C19.5524 4.00008 20.0001 4.4478 20.0001 5.00008V8.68637L22.6067 11.293C22.9972 11.6835 22.9972 12.3167 22.6067 12.7072L20.0001 15.3138V19.0001C20.0001 19.5524 19.5524 20.0001 19.0001 20.0001H15.3138L12.7072 22.6067C12.3167 22.9972 11.6835 22.9972 11.293 22.6067L8.68637 20.0001H5.00008C4.4478 20.0001 4.00008 19.5524 4.00008 19.0001V15.3138L1.39348 12.7072C1.00295 12.3167 1.00295 11.6835 1.39348 11.293L4.00008 8.68637V5.00008C4.00008 4.4478 4.4478 4.00008 5.00008 4.00008H8.68637ZM6.00008 6.00008V9.5148L3.5148 12.0001L6.00008 14.4854V18.0001H9.5148L12.0001 20.4854L14.4854 18.0001H18.0001V14.4854L20.4854 12.0001L18.0001 9.5148V6.00008H14.4854L12.0001 3.5148L9.5148 6.00008H6.00008ZM12.0001 16.0001C9.79094 16.0001 8.00008 14.2092 8.00008 12.0001C8.00008 9.79094 9.79094 8.00008 12.0001 8.00008C14.2092 8.00008 16.0001 9.79094 16.0001 12.0001C16.0001 14.2092 14.2092 16.0001 12.0001 16.0001ZM12.0001 14.0001C13.1047 14.0001 14.0001 13.1047 14.0001 12.0001C14.0001 10.8955 13.1047 10.0001 12.0001 10.0001C10.8955 10.0001 10.0001 10.8955 10.0001 12.0001C10.0001 13.1047 10.8955 14.0001 12.0001 14.0001Z" />
                    </svg>
                    <span class="mx-2 text-sm font-medium">Settings</span>
                </a>

                {{-- Logout --}}
                <form action="{{ route('customer.logout') }}" method="POST">
                    @csrf
                    <button type="submit"
                        class="flex items-center px-3 py-2 text-gray-300 rounded-lg w-full hover:bg-gray-400 hover:text-gray-900 transition-colors duration-300 cursor-pointer">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-5 h-5">
                            <path
                                d="M4 18H6V20H18V4H6V6H4V3C4 2.44772 4.44772 2 5 2H19C19.5523 2 20 2.44772 20 3V21C20 21.5523 19.5523 22 19 22H5C4.44772 22 4 21.5523 4 21V18ZM6 11H13V13H6V16L1 12L6 8V11Z" />
                        </svg>
                        <span class="mx-2 text-sm font-medium">Logout</span>
                    </button>
                </form>
            </div>
        </nav>
    </div>
</aside>
