{{-- Header --}}
<div class="flex flex-col gap-5 px-6 mb-4 sm:flex-row sm:items-center sm:justify-between">
    <h3 class="text-lg font-semibold text-gray-800">{{ $title }}</h3>

    <div class="flex flex-col gap-3 sm:flex-row sm:items-center">
        {{-- Search --}}
        <div class="relative">
            <span class="absolute left-4 top-1/2 -translate-y-1/2 pointer-events-none text-blue-600">
                <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                    <path
                        d="M18.031 16.6168L22.3137 20.8995L20.8995 22.3137L16.6168 18.031C15.0769 19.263 13.124 20 11 20C6.032 20 2 15.968 2 11C2 6.032 6.032 2 11 2C15.968 2 20 6.032 20 11C20 13.124 19.263 15.0769 18.031 16.6168ZM16.0247 15.8748C17.2475 14.6146 18 12.8956 18 11C18 7.1325 14.8675 4 11 4C7.1325 4 4 7.1325 4 11C4 14.8675 7.1325 18 11 18C12.8956 18 14.6146 17.2475 15.8748 16.0247L16.0247 15.8748Z" />
                </svg>
            </span>
            <input type="text" wire:model.live="search" placeholder="Search..."
                class="h-10 w-full xl:w-[300px] rounded-lg border border-gray-300 bg-white pl-[42px] pr-4 py-2.5 text-sm text-gray-700 placeholder:text-gray-400 focus:border-blue-600 focus:ring-2 focus:ring-blue-600 focus:outline-hidden">
        </div>

        {{-- Filter Button --}}
        <button
            class="inline-flex h-10 items-center gap-2 rounded-lg border border-gray-300 bg-white px-4 py-2.5 text-sm font-medium text-gray-700 hover:text-blue-600 hover:border-blue-400 hover:bg-blue-50">
            <svg class="stroke-current fill-white dark:fill-gray-800" width="20" height="20"
                viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                <path d="M2.29 5.904h15.417M17.708 14.096H2.291" stroke-width="1.5" stroke-linecap="round" />
                <circle cx="12.083" cy="5.904" r="2.167" stroke-width="1.5" />
                <circle cx="7.917" cy="14.096" r="2.167" stroke-width="1.5" />
            </svg>
            Filter
        </button>
    </div>
</div>
