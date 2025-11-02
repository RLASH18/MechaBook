<aside class="flex flex-col w-64 px-5 py-8 overflow-y-auto bg-blue-600">
    {{-- Logo Section --}}
    <div class="flex items-center justify-center mb-2 -mt-4">
        <a wire:navigate href="{{ route('admin.dashboard') }}" class="block">
            <img class="w-auto h-16" src="{{ asset('img/mecha-book-icon-removebg.png') }}" alt="MechaBook">
        </a>
    </div>

    <div class="flex flex-col justify-between flex-1 mt-6">
        <nav class="-mx-3 space-y-6 ">
            <div class="space-y-3">
                <label class="px-3 text-xs text-blue-200 uppercase dark:text-gray-400">analytics</label>

                {{-- Dashboard --}}
                <a wire:navigate href="{{ route('admin.dashboard') }}"
                    class="flex items-center px-3 py-2 rounded-lg transition-colors duration-300 transform {{ request()->routeIs('admin.dashboard') ? 'bg-white text-blue-600' : 'text-gray-300 hover:bg-gray-400 hover:text-gray-900' }}">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-5 h-5">
                        <path
                            d="M14 21C13.4477 21 13 20.5523 13 20V12C13 11.4477 13.4477 11 14 11H20C20.5523 11 21 11.4477 21 12V20C21 20.5523 20.5523 21 20 21H14ZM4 13C3.44772 13 3 12.5523 3 12V4C3 3.44772 3.44772 3 4 3H10C10.5523 3 11 3.44772 11 4V12C11 12.5523 10.5523 13 10 13H4ZM9 11V5H5V11H9ZM4 21C3.44772 21 3 20.5523 3 20V16C3 15.4477 3.44772 15 4 15H10C10.5523 15 11 15.4477 11 16V20C11 20.5523 10.5523 21 10 21H4ZM5 19H9V17H5V19ZM15 19H19V13H15V19ZM13 4C13 3.44772 13.4477 3 14 3H20C20.5523 3 21 3.44772 21 4V8C21 8.55228 20.5523 9 20 9H14C13.4477 9 13 8.55228 13 8V4ZM15 5V7H19V5H15Z" />
                    </svg>
                    <span class="mx-2 text-sm font-medium">Dashboard</span>
                </a>
            </div>

            <div class="space-y-3">
                <label class="px-3 text-xs text-blue-200 uppercase dark:text-gray-400">Management</label>

                {{-- Employee --}}
                <a wire:navigate href="{{ route('admin.employee.index') }}"
                    class="flex items-center px-3 py-2 rounded-lg transition-colors duration-300 transform {{ request()->routeIs('admin.employee.*') ? 'bg-white text-blue-600' : 'text-gray-300 hover:bg-gray-400 hover:text-gray-900' }}">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-5 h-5">
                        <path
                            d="M4 22C4 17.5817 7.58172 14 12 14C16.4183 14 20 17.5817 20 22H18C18 18.6863 15.3137 16 12 16C8.68629 16 6 18.6863 6 22H4ZM12 13C8.685 13 6 10.315 6 7C6 3.685 8.685 1 12 1C15.315 1 18 3.685 18 7C18 10.315 15.315 13 12 13ZM12 11C14.21 11 16 9.21 16 7C16 4.79 14.21 3 12 3C9.79 3 8 4.79 8 7C8 9.21 9.79 11 12 11Z" />
                    </svg>
                    <span class="mx-2 text-sm font-medium">Employees</span>
                </a>

                {{-- Schedule Dropdown --}}
                <div x-data="{ open: {{ request()->routeIs('admin.schedule.*') ? 'true' : 'false' }} }">
                    <button @click="open = !open" type="button"
                        class="flex items-center justify-between w-full px-3 py-2 rounded-lg transition-colors duration-300 transform {{ request()->routeIs('admin.schedule.*') ? 'bg-white text-blue-600' : 'text-gray-300 hover:bg-gray-400 hover:text-gray-900' }}">
                        <div class="flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"
                                class="w-5 h-5">
                                <path
                                    d="M9 1V3H15V1H17V3H21C21.5523 3 22 3.44772 22 4V20C22 20.5523 21.5523 21 21 21H3C2.44772 21 2 20.5523 2 20V4C2 3.44772 2.44772 3 3 3H7V1H9ZM20 11H4V19H20V11ZM7 5H4V9H20V5H17V7H15V5H9V7H7V5Z" />
                            </svg>
                            <span class="mx-2 text-sm font-medium">Schedules</span>
                        </div>
                        <svg :class="{ 'rotate-180': open }" class="w-4 h-4 transition-transform duration-200"
                            xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                        </svg>
                    </button>

                    <div x-show="open" x-collapse class="ml-5 mt-2 space-y-2 border-l-2 border-blue-500/70 pl-3">
                        <a wire:navigate href="{{ route('admin.schedule.index') }}"
                            class="flex items-center px-3 py-2 rounded-lg transition-colors duration-300 text-sm {{ request()->routeIs('admin.schedule.index') ? 'bg-blue-500 text-white' : 'text-gray-300 hover:bg-blue-500 hover:text-white' }}">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                stroke-width="2" stroke-linecap="round" class="w-4 h-4" stroke-linejoin="round" class="lucide lucide-calendar-days-icon lucide-calendar-days">
                                <path d="M8 2v4" /><path d="M16 2v4" /><rect width="18" height="18" x="3" y="4" rx="2" /><path d="M3 10h18" /><path d="M8 14h.01" />
                                <path d="M12 14h.01" /><path d="M16 14h.01" /><path d="M8 18h.01" /><path d="M12 18h.01" /><path d="M16 18h.01" />
                            </svg>
                            <span class="ml-2">Manage Schedules</span>
                        </a>
                        <a wire:navigate href="{{ route('admin.schedule.requests') }}"
                            class="flex items-center px-3 py-2 rounded-lg transition-colors duration-300 text-sm {{ request()->routeIs('admin.schedule.requests') ? 'bg-blue-500 text-white' : 'text-gray-300 hover:bg-blue-500 hover:text-white' }}">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                class="lucide lucide-calendar-clock-icon lucide-calendar-clock">
                                <path d="M16 14v2.2l1.6 1" /><path d="M16 2v4" /><path d="M21 7.5V6a2 2 0 0 0-2-2H5a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h3.5" />
                                <path d="M3 10h5" /><path d="M8 2v4" /><circle cx="16" cy="16" r="6" />
                            </svg>
                            <span class="ml-2">Change Requests</span>
                        </a>
                    </div>
                </div>

                {{-- Service --}}
                <a wire:navigate href="{{ route('admin.service.index') }}"
                    class="flex items-center px-3 py-2 rounded-lg transition-colors duration-300 transform {{ request()->routeIs('admin.service.*') ? 'bg-white text-blue-600' : 'text-gray-300 hover:bg-gray-400 hover:text-gray-900' }}">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-5 h-5">
                        <path
                            d="M3.16113 4.46875C5.58508 2.0448 9.44716 1.9355 12.0008 4.14085C14.5528 1.9355 18.4149 2.0448 20.8388 4.46875C23.2584 6.88836 23.3716 10.741 21.1785 13.2947L13.4142 21.0858C12.6686 21.8313 11.4809 21.8652 10.6952 21.1874L10.5858 21.0858L2.82141 13.2947C0.628282 10.741 0.741522 6.88836 3.16113 4.46875ZM4.57534 5.88296C2.86819 7.59011 2.81942 10.3276 4.42902 12.0937L4.57534 12.2469L12 19.6715L17.3026 14.3675L13.7677 10.8327L12.7071 11.8934C11.5355 13.0649 9.636 13.0649 8.46443 11.8934C7.29286 10.7218 7.29286 8.8223 8.46443 7.65073L10.5656 5.54823C8.85292 4.17713 6.37076 4.23993 4.7286 5.73663L4.57534 5.88296ZM13.0606 8.71139C13.4511 8.32086 14.0843 8.32086 14.4748 8.71139L18.7168 12.9533L19.4246 12.2469C21.1819 10.4896 21.1819 7.64032 19.4246 5.88296C17.7174 4.17581 14.9799 4.12704 13.2139 5.73663L13.0606 5.88296L9.87864 9.06494C9.51601 9.42757 9.49011 9.99942 9.80094 10.3919L9.87864 10.4792C10.2413 10.8418 10.8131 10.8677 11.2056 10.5569L11.2929 10.4792L13.0606 8.71139Z" />
                    </svg>
                    <span class="mx-2 text-sm font-medium">Services</span>
                </a>

                {{-- Appointment --}}
                <a wire:navigate href="{{ route('admin.appointment.index') }}"
                    class="flex items-center px-3 py-2 rounded-lg transition-colors duration-300 transform {{ request()->routeIs('admin.appointment.index') ? 'bg-white text-blue-600' : 'text-gray-300 hover:bg-gray-400 hover:text-gray-900' }}">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-5 h-5">
                        <path
                            d="M20 2C20.5523 2 21 2.44772 21 3V21C21 21.5523 20.5523 22 20 22H6C5.44772 22 5 21.5523 5 21V19H3V17H5V15H3V13H5V11H3V9H5V7H3V5H5V3C5 2.44772 5.44772 2 6 2H20ZM19 4H7V20H19V4ZM14 8V11H17V13H13.999L14 16H12L11.999 13H9V11H12V8H14Z" />
                    </svg>
                    <span class="mx-2 text-sm font-medium">Appointments</span>
                </a>
            </div>

            <div class="space-y-3">
                <label class="px-3 text-xs text-blue-200 uppercase dark:text-gray-400">Configuration</label>

                {{-- Settings --}}
                <a wire:navigate href="{{ route('admin.settings') }}"
                    class="flex items-center px-3 py-2 rounded-lg transition-colors duration-300 transform {{ request()->routeIs('admin.settings') ? 'bg-white text-blue-600' : 'text-gray-300 hover:bg-gray-400 hover:text-gray-900' }}">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-5 h-5">
                        <path
                            d="M8.68637 4.00008L11.293 1.39348C11.6835 1.00295 12.3167 1.00295 12.7072 1.39348L15.3138 4.00008H19.0001C19.5524 4.00008 20.0001 4.4478 20.0001 5.00008V8.68637L22.6067 11.293C22.9972 11.6835 22.9972 12.3167 22.6067 12.7072L20.0001 15.3138V19.0001C20.0001 19.5524 19.5524 20.0001 19.0001 20.0001H15.3138L12.7072 22.6067C12.3167 22.9972 11.6835 22.9972 11.293 22.6067L8.68637 20.0001H5.00008C4.4478 20.0001 4.00008 19.5524 4.00008 19.0001V15.3138L1.39348 12.7072C1.00295 12.3167 1.00295 11.6835 1.39348 11.293L4.00008 8.68637V5.00008C4.00008 4.4478 4.4478 4.00008 5.00008 4.00008H8.68637ZM6.00008 6.00008V9.5148L3.5148 12.0001L6.00008 14.4854V18.0001H9.5148L12.0001 20.4854L14.4854 18.0001H18.0001V14.4854L20.4854 12.0001L18.0001 9.5148V6.00008H14.4854L12.0001 3.5148L9.5148 6.00008H6.00008ZM12.0001 16.0001C9.79094 16.0001 8.00008 14.2092 8.00008 12.0001C8.00008 9.79094 9.79094 8.00008 12.0001 8.00008C14.2092 8.00008 16.0001 9.79094 16.0001 12.0001C16.0001 14.2092 14.2092 16.0001 12.0001 16.0001ZM12.0001 14.0001C13.1047 14.0001 14.0001 13.1047 14.0001 12.0001C14.0001 10.8955 13.1047 10.0001 12.0001 10.0001C10.8955 10.0001 10.0001 10.8955 10.0001 12.0001C10.0001 13.1047 10.8955 14.0001 12.0001 14.0001Z" />
                    </svg>
                    <span class="mx-2 text-sm font-medium">Settings</span>
                </a>

                {{-- Logout --}}
                <form action="{{ route('admin.logout') }}" method="POST">
                    @csrf
                    <button type="submit"
                        class="flex items-center px-3 py-2 text-gray-300 rounded-lg w-full hover:bg-gray-400 hover:text-gray-900 transition-colors duration-300 cursor-pointer">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"
                            class="w-5 h-5">
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
