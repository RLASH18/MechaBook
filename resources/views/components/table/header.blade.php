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

        {{-- Filter Slot (if provided) --}}
        @if(isset($filter))
            {{ $filter }}
        @endif
    </div>
</div>
