{{-- Navbar --}}
<header class="flex items-center justify-between px-6 py-3 bg-white border-b border-gray-200">
    {{-- Left side --}}
    <button
        class="flex h-10 w-10 items-center justify-center rounded-lg text-gray-600 hover:bg-gray-100 hover:text-blue-600 transition cursor-pointer">
        <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
            <path d="M3 4H21V6H3V4ZM3 11H15V13H3V11ZM3 18H21V20H3V18Z" />
        </svg>
    </button>

    {{-- Right side --}}
    <div class="flex items-center space-x-5">
        {{-- Search --}}
        <div class="relative">
            <input type="text" placeholder="Search..."
                class="w-52 pl-3 pr-8 py-2 text-sm text-gray-700 placeholder-gray-400 bg-white border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-600 transition" />
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"
                class="w-4 h-4 absolute right-3 top-1/2 -translate-y-1/2 text-gray-400">
                <path
                    d="M18.031 16.6168L22.3137 20.8995L20.8995 22.3137L16.6168 18.031C15.0769 19.263 13.124 20 11 20C6.032 20 2 15.968 2 11C2 6.032 6.032 2 11 2C15.968 2 20 6.032 20 11C20 13.124 19.263 15.0769 18.031 16.6168ZM16.0247 15.8748C17.2475 14.6146 18 12.8956 18 11C18 7.1325 14.8675 4 11 4C7.1325 4 4 7.1325 4 11C4 14.8675 7.1325 18 11 18C12.8956 18 14.6146 17.2475 15.8748 16.0247L16.0247 15.8748Z" />
            </svg>
        </div>

        {{-- Notifications --}}
        <button class="relative text-gray-600 hover:text-blue-600 transition">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-6 h-6">
                <path
                    d="M20 17H22V19H2V17H4V10C4 5.58172 7.58172 2 12 2C16.4183 2 20 5.58172 20 10V17ZM18 17V10C18 6.68629 15.3137 4 12 4C8.68629 4 6 6.68629 6 10V17H18ZM9 21H15V23H9V21Z" />
            </svg>
            <span
                class="absolute top-0 right-0 inline-flex items-center justify-center w-2.5 h-2.5 text-xs font-bold text-white bg-red-500 rounded-full"></span>
        </button>

        {{-- Profile --}}
        <div class="flex items-center space-x-2 cursor-pointer hover:bg-gray-100 px-2 py-1 rounded-lg transition">
            <img class="w-9 h-9 rounded-full border border-gray-300" src="https://i.pravatar.cc/40" alt="User Avatar">
            <span class="text-gray-800 font-medium">{{ auth()->user()->name }}</span>
        </div>
    </div>
</header>
