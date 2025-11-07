<div>
    {{-- Search & Filter Bar --}}
    <div class="bg-white rounded-2xl p-6 border border-gray-200 mb-6">
        <div class="flex flex-col md:flex-row gap-4 items-start md:items-center justify-between">
            {{-- Search Input --}}
            <div class="flex-1 w-full md:max-w-md">
                <div class="relative">
                    <span class="absolute left-4 top-1/2 -translate-y-1/2 pointer-events-none text-blue-600 z-10">
                        <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                            <path
                                d="M18.031 16.6168L22.3137 20.8995L20.8995 22.3137L16.6168 18.031C15.0769 19.263 13.124 20 11 20C6.032 20 2 15.968 2 11C2 6.032 6.032 2 11 2C15.968 2 20 6.032 20 11C20 13.124 19.263 15.0769 18.031 16.6168ZM16.0247 15.8748C17.2475 14.6146 18 12.8956 18 11C18 7.1325 14.8675 4 11 4C7.1325 4 4 7.1325 4 11C4 14.8675 7.1325 18 11 18C12.8956 18 14.6146 17.2475 15.8748 16.0247L16.0247 15.8748Z" />
                        </svg>
                    </span>
                    <x-form.input name="search" wire:model.live="search" placeholder="Search by customer, email, or service..."
                        class="pl-[42px] pr-4 h-10 text-sm w-full xl:w-[350px]" />
                </div>
            </div>

            {{-- Status Filter Tabs --}}
            <div class="flex flex-wrap gap-2 w-full md:w-auto justify-end">
                <button wire:click="$set('status', 'all')"
                    class="px-4 py-2 rounded-lg text-sm font-medium transition-all {{ $status === 'all' ? 'bg-indigo-600 text-white shadow-sm' : 'bg-gray-100 text-gray-700 hover:bg-gray-200' }}">
                    All ({{ $statusCounts['all'] }})
                </button>
                <button wire:click="$set('status', 'approved')"
                    class="px-4 py-2 rounded-lg text-sm font-medium transition-all {{ $status === 'approved' ? 'bg-green-500 text-white shadow-sm' : 'bg-green-50 text-green-700 hover:bg-green-100 border border-green-200' }}">
                    Approved ({{ $statusCounts['approved'] }})
                </button>
                <button wire:click="$set('status', 'started')"
                    class="px-4 py-2 rounded-lg text-sm font-medium transition-all {{ $status === 'started' ? 'bg-blue-500 text-white shadow-sm' : 'bg-blue-50 text-blue-700 hover:bg-blue-100 border border-blue-200' }}">
                    Started ({{ $statusCounts['started'] }})
                </button>
                <button wire:click="$set('status', 'completed')"
                    class="px-4 py-2 rounded-lg text-sm font-medium transition-all {{ $status === 'completed' ? 'bg-purple-500 text-white shadow-sm' : 'bg-purple-50 text-purple-700 hover:bg-purple-100 border border-purple-200' }}">
                    Completed ({{ $statusCounts['completed'] }})
                </button>
            </div>
        </div>
    </div>

    {{-- Appointments List --}}
    <div class="space-y-4">
        @forelse($appointments as $appointment)
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-4 hover:shadow-md transition-shadow">
                <div class="flex items-start justify-between">
                    {{-- Appointment Info --}}
                    <div class="flex-1">
                        <div class="flex items-center gap-3 mb-2">
                            <h3 class="text-lg font-semibold text-gray-900">{{ $appointment->service->name }}</h3>
                            @php
                                $statusConfig = [
                                    'approved' => [
                                        'bg' => 'bg-green-50',
                                        'text' => 'text-green-700',
                                        'dot' => 'bg-green-500',
                                    ],
                                    'started' => [
                                        'bg' => 'bg-blue-50',
                                        'text' => 'text-blue-700',
                                        'dot' => 'bg-blue-500',
                                    ],
                                    'completed' => [
                                        'bg' => 'bg-purple-50',
                                        'text' => 'text-purple-700',
                                        'dot' => 'bg-purple-500',
                                    ],
                                ];
                                $config = $statusConfig[$appointment->status] ?? [
                                    'bg' => 'bg-gray-50',
                                    'text' => 'text-gray-700',
                                    'dot' => 'bg-gray-500',
                                ];
                            @endphp
                            <span
                                class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full text-xs font-medium {{ $config['bg'] }} {{ $config['text'] }}">
                                <span class="w-1.5 h-1.5 rounded-full {{ $config['dot'] }}"></span>
                                {{ ucfirst($appointment->status) }}
                            </span>
                        </div>

                        <div class="grid grid-cols-2 gap-3 text-sm">
                            <div>
                                <p class="text-gray-600">Customer:</p>
                                <p class="font-medium text-gray-900">{{ $appointment->customer->name }}</p>
                            </div>
                            <div>
                                <p class="text-gray-600">Date:</p>
                                <p class="font-medium text-gray-900">
                                    {{ \Carbon\Carbon::parse($appointment->appointment_date)->format('M d, Y') }}
                                </p>
                            </div>
                            <div>
                                <p class="text-gray-600">Time:</p>
                                <p class="font-medium text-gray-900">
                                    {{ \Carbon\Carbon::parse($appointment->start_time)->format('h:i A') }} -
                                    {{ \Carbon\Carbon::parse($appointment->end_time)->format('h:i A') }}
                                </p>
                            </div>
                            <div>
                                <p class="text-gray-600">Category:</p>
                                <p class="font-medium text-gray-900">{{ $appointment->service->category }}</p>
                            </div>
                        </div>
                    </div>

                    {{-- Action Buttons --}}
                    <div class="ml-4">
                        @if ($appointment->status === 'approved')
                            <button wire:click="$dispatch('openStartModal', { appointmentId: {{ $appointment->id }} })"
                                class="px-4 py-2 text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 rounded-lg transition-colors">
                                Start
                            </button>
                        @elseif($appointment->status === 'started')
                            <button
                                wire:click="$dispatch('openCompleteModal', { appointmentId: {{ $appointment->id }} })"
                                class="px-4 py-2 text-sm font-medium text-white bg-green-600 hover:bg-green-700 rounded-lg transition-colors">
                                Complete
                            </button>
                        @endif
                    </div>
                </div>
            </div>
        @empty
            <div class="col-span-full bg-white rounded-2xl border border-gray-200 p-12">
                <div class="text-center">
                    <svg class="w-16 h-16 mx-auto text-gray-400 mb-4" fill="none" stroke="currentColor"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                    </svg>
                    <p class="text-gray-500 text-lg font-medium">No appointments found</p>
                    <p class="text-gray-400 text-sm mt-1">
                        @if ($search || $status !== 'all')
                            Try adjusting your search or filters to find what you're looking for.
                        @else
                            You don't have any assigned appointments at the moment.
                        @endif
                    </p>
                </div>
            </div>
        @endforelse
    </div>

    <x-pagination :items="$appointments" />
</div>
