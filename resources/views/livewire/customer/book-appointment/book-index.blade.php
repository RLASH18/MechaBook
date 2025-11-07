<div>
    {{-- Search Bar --}}
    <div class="bg-white rounded-2xl p-6 border border-gray-200 mb-6">
        <div class="flex flex-col md:flex-row gap-4 items-center md:justify-between">
            {{-- Search Input --}}
            <div class="flex-1 max-w-md">
                <div class="relative">
                    <span class="absolute left-4 top-1/2 -translate-y-1/2 pointer-events-none text-blue-600 z-10">
                        <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                            <path
                                d="M18.031 16.6168L22.3137 20.8995L20.8995 22.3137L16.6168 18.031C15.0769 19.263 13.124 20 11 20C6.032 20 2 15.968 2 11C2 6.032 6.032 2 11 2C15.968 2 20 6.032 20 11C20 13.124 19.263 15.0769 18.031 16.6168ZM16.0247 15.8748C17.2475 14.6146 18 12.8956 18 11C18 7.1325 14.8675 4 11 4C7.1325 4 4 7.1325 4 11C4 14.8675 7.1325 18 11 18C12.8956 18 14.6146 17.2475 15.8748 16.0247L16.0247 15.8748Z" />
                        </svg>
                    </span>
                    <x-form.input name="search" wire:model.live="search" placeholder="Search Services..." class="pl-12 h-10 text-sm w-full xl:w-[300px]" />
                </div>
            </div>

            {{-- Status Filter --}}
            <div class="md:ml-auto">
                <x-form.select name="status" wire:model.live="status" class="h-10 text-sm w-auto justify-items-end">
                    <option value="all">All Category</option>
                    <option value="maintenance">Maintenance</option>
                    <option value="repair">Repair</option>
                    <option value="inspection">Inspection</option>
                    <option value="detailing">Detailing</option>
                    <option value="diagnostic">Diagnostic</option>
                </x-form.select>
            </div>
        </div>
    </div>

    {{-- Services Grid --}}
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
        @forelse ($services as $service)
            @php
                // Check if customer already has active appointment for this service
                $hasActiveAppointment = in_array($service->id, $activeAppointmentServiceIds);

                // Category color mapping
                $categoryColors = [
                    'Maintenance' => ['bg' => 'bg-blue-100', 'text' => 'text-blue-700', 'border' => 'border-blue-200',],
                    'Repair' => ['bg' => 'bg-red-100', 'text' => 'text-red-700', 'border' => 'border-red-200'],
                    'Inspection' => ['bg' => 'bg-purple-100', 'text' => 'text-purple-700', 'border' => 'border-purple-200',],
                    'Detailing' => [ 'bg' => 'bg-green-100','text' => 'text-green-700', 'border' => 'border-green-200',],
                    'Diagnostic' => ['bg' => 'bg-orange-100', 'text' => 'text-orange-700', 'border' => 'border-orange-200',],
                    'Other' => ['bg' => 'bg-gray-100', 'text' => 'text-gray-700','border' => 'border-gray-200'],
                ];
                $colors = $categoryColors[$service->category] ?? $categoryColors['Other'];
            @endphp

            <div
                class="bg-white rounded-2xl border border-gray-200 overflow-hidden hover:shadow-xl transition-all duration-300 group">
                {{-- Service Image --}}
                <div class="relative h-48 bg-gradient-to-br from-gray-100 to-gray-200 overflow-hidden">
                    @if ($service->service_img)
                        <img src="{{ asset('storage/' . $service->service_img) }}" alt="{{ $service->name }}"
                            class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-300">
                    @else
                        <div class="w-full h-full flex items-center justify-center">
                            <svg class="w-20 h-20 text-gray-400" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                            </svg>
                        </div>
                    @endif

                    {{-- Category Badge --}}
                    <div class="absolute top-3 right-3">
                        <span
                            class="px-3 py-1 rounded-full text-xs font-semibold {{ $colors['bg'] }} {{ $colors['text'] }} backdrop-blur-sm">
                            {{ $service->category }}
                        </span>
                    </div>

                    {{-- Active Appointment Badge --}}
                    @if($hasActiveAppointment)
                        <div class="absolute top-3 left-3">
                            <span class="px-3 py-1 rounded-full text-xs font-semibold bg-orange-500 text-white backdrop-blur-sm flex items-center gap-1">
                                <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd" />
                                </svg>
                                In Progress
                            </span>
                        </div>
                    @endif
                </div>

                {{-- Service Details --}}
                <div class="p-5">
                    {{-- Service ID --}}
                    <p class="text-xs text-gray-500 font-mono mb-2">
                        SRV-{{ str_pad($service->id, 4, '0', STR_PAD_LEFT) }}
                    </p>

                    {{-- Service Name --}}
                    <h3 class="font-bold text-gray-900 text-lg mb-2 line-clamp-2 min-h-[3.5rem]">
                        {{ $service->name }}
                    </h3>

                    {{-- Description --}}
                    @if ($service->description)
                        <p class="text-sm text-gray-600 mb-4 line-clamp-2">
                            {{ $service->description }}
                        </p>
                    @else
                        <p class="text-sm text-gray-400 italic mb-4">
                            No description available
                        </p>
                    @endif

                    {{-- Duration & Price --}}
                    <div class="flex items-center justify-between mb-4 pb-4 border-gray-200">
                        <div class="flex items-center text-sm text-gray-600">
                            <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            <span>{{ $service->duration_minutes }} min</span>
                        </div>
                        <div class="text-right">
                            <p class="text-2xl font-bold text-green-600">₱{{ number_format($service->price, 2) }}</p>
                        </div>
                    </div>

                    {{-- Action Buttons --}}
                    <div class="flex flex-col sm:grid sm:grid-cols-2 gap-2">
                        <button wire:click="$dispatch('openDetailsModal', { serviceId: {{ $service->id }} })"
                            class="flex items-center justify-center gap-1.5 px-3 py-2 text-xs sm:text-sm font-medium text-blue-700 bg-blue-50 hover:bg-blue-100 rounded-lg transition-colors border border-blue-200">
                            <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            <span class="whitespace-nowrap">Details</span>
                        </button>

                        @if($hasActiveAppointment)
                            <button disabled
                                class="flex items-center justify-center gap-1.5 px-3 py-2 text-xs sm:text-sm font-medium text-gray-400 bg-gray-100 rounded-lg cursor-not-allowed opacity-60"
                                title="You already have an active appointment for this service">
                                <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                                </svg>
                                <span class="whitespace-nowrap">Booked</span>
                            </button>
                        @else
                            <button wire:click="$dispatch('openBookModal', { serviceId: {{ $service->id }} })"
                                class="flex items-center justify-center gap-1.5 px-3 py-2 text-xs sm:text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 rounded-lg transition-colors shadow-sm hover:shadow-md">
                                <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                                </svg>
                                <span class="whitespace-nowrap">Book Now</span>
                            </button>
                        @endif
                    </div>
                </div>
            </div>
        @empty
            <div class="col-span-full text-center py-16">
                <svg class="w-20 h-20 mx-auto text-gray-400 mb-4" fill="none" stroke="currentColor"
                    viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                </svg>
                <p class="text-gray-500 text-xl font-medium mb-2">No services found</p>
                <p class="text-gray-400 text-sm">Try adjusting your search or add a new service</p>
            </div>
        @endforelse
    </div>

    <x-pagination :items="$services" />
</div>
