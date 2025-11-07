<div>
    {{-- Filters --}}
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
                    <x-form.input name="search" wire:model.live="search" placeholder="Search Employee..." class="pl-12 h-10 text-sm w-full xl:w-[300px]" />
                </div>
            </div>

            {{-- Status Filter --}}
            <div class="md:ml-auto">
                <x-form.select name="status" wire:model.live="status" class="h-10 text-sm w-auto justify-items-end">
                    <option value="all">All Status</option>
                    <option value="pending">Pending</option>
                    <option value="approved">Approved</option>
                    <option value="rejected">Rejected</option>
                </x-form.select>
            </div>
        </div>
    </div>

    {{-- Requests List --}}
    <div class="space-y-4">
        @forelse ($requests as $request)
            <div class="bg-white rounded-2xl p-6 border border-gray-200 hover:shadow-lg transition-shadow">
                <div class="flex flex-col lg:flex-row lg:items-center justify-between gap-4">
                    {{-- Left: Employee & Request Info --}}
                    <div class="flex-1">
                        <div class="flex items-start gap-4">
                            {{-- Employee Avatar --}}
                            <div
                                class="w-12 h-12 bg-gradient-to-br from-blue-400 to-blue-600 rounded-full flex items-center justify-center flex-shrink-0">
                                <span class="text-white font-semibold text-sm">
                                    {{ strtoupper(substr($request->employee->name, 0, 2)) }}
                                </span>
                            </div>

                            {{-- Request Details --}}
                            <div class="flex-1">
                                <div class="flex items-center gap-2 mb-1">
                                    <h3 class="font-semibold text-gray-900">{{ $request->employee->name }}</h3>
                                    <span
                                        class="px-2 py-1 text-xs font-medium rounded-full {{ $this->getStatusColor($request->status) }}">
                                        {{ ucfirst($request->status) }}
                                    </span>
                                    <span class="px-2 py-1 text-xs font-medium rounded-full bg-blue-100 text-blue-800">
                                        {{ $this->getRequestTypeLabel($request->request_type) }}
                                    </span>
                                </div>
                                <p class="text-sm text-gray-600 mb-2">{{ $request->employee->email }}</p>

                                {{-- Current Schedule --}}
                                <div class="text-sm mb-2">
                                    <span class="font-medium text-gray-700">Current:</span>
                                    <span class="text-gray-600">
                                        {{ $request->current_day_of_week }}
                                        @if ($request->current_start_time)
                                            ({{ date('g:i A', strtotime($request->current_start_time)) }} -
                                            {{ date('g:i A', strtotime($request->current_end_time)) }})
                                        @endif
                                    </span>
                                </div>

                                {{-- Requested Change --}}
                                <div class="text-sm mb-2">
                                    <span class="font-medium text-gray-700">Requested:</span>
                                    <span class="text-blue-600 font-medium">
                                        @if ($request->request_type === 'time_change')
                                            {{ $request->current_day_of_week }}
                                            ({{ date('g:i A', strtotime($request->requested_start_time)) }} -
                                            {{ date('g:i A', strtotime($request->requested_end_time)) }})
                                        @elseif($request->request_type === 'day_change')
                                            {{ $request->requested_day_of_week }} (Same time)
                                        @else
                                            Day Off
                                        @endif
                                    </span>
                                </div>

                                {{-- Reason --}}
                                <div class="text-sm">
                                    <span class="font-medium text-gray-700">Reason:</span>
                                    <p class="text-gray-600 mt-1">{{ $request->reason }}</p>
                                </div>

                                {{-- Admin Notes (if reviewed) --}}
                                @if ($request->admin_notes && $request->status !== 'pending')
                                    <div class="mt-3 p-3 bg-gray-50 rounded-lg">
                                        <span class="font-medium text-gray-700 text-sm">Admin Notes:</span>
                                        <p class="text-gray-600 text-sm mt-1">{{ $request->admin_notes }}</p>
                                    </div>
                                @endif

                                {{-- Request Date --}}
                                <p class="text-xs text-gray-500 mt-2">
                                    Requested {{ $request->created_at->diffForHumans() }}
                                </p>
                            </div>
                        </div>
                    </div>

                    {{-- Right: Actions --}}
                    @if ($request->status === 'pending')
                        <div class="flex gap-2 lg:flex-col">
                            <button wire:click="$dispatch('openApproveModal', { requestId: {{ $request->id }} })"
                                class="flex-1 lg:flex-none px-4 py-2 text-sm font-medium text-white bg-green-600 hover:bg-green-700 rounded-lg transition-colors">
                                Approve
                            </button>
                            <button wire:click="$dispatch('openRejectModal', { requestId: {{ $request->id }} })"
                                class="flex-1 lg:flex-none px-4 py-2 text-sm font-medium text-white bg-red-600 hover:bg-red-700 rounded-lg transition-colors">
                                Reject
                            </button>
                        </div>
                    @endif
                </div>
            </div>
        @empty
            <div class="bg-white rounded-2xl p-12 border border-gray-200 text-center">
                <svg class="w-16 h-16 mx-auto text-gray-400 mb-4" fill="none" stroke="currentColor"
                    viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4" />
                </svg>
                <p class="text-gray-500">No schedule change requests found.</p>
            </div>
        @endforelse
    </div>

    <x-pagination :items="$requests" />
</div>
