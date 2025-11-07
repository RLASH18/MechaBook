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
                    <x-form.input name="search" wire:model.live="search" placeholder="Search Employee..." class="pl-12 h-10 text-sm w-full xl:w-[300px]" />
                </div>
            </div>

            {{-- Status Filter --}}
            <div class="md:ml-auto">
                <x-form.select name="status" wire:model.live="status" class="h-10 text-sm w-auto justify-items-end">
                    <option value="all">All Status</option>
                    <option value="active">Active</option>
                    <option value="idle">Idle</option>
                    <option value="inactive">Inactive</option>
                </x-form.select>
            </div>
        </div>
    </div>

    {{-- Employee Cards Grid --}}
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
        @forelse ($employees as $employee)
            @php
                $nameParts = explode(' ', $employee->name);
                $firstName = $nameParts[0] ?? '';
                $lastName = end($nameParts) ?? '';
                $initials = strtoupper(substr($firstName, 0, 1) . substr($lastName, 0, 1));
                $todaySchedule = $employee->employeeSchedules->where('day_of_week', now()->format('D'))->first();
            @endphp

            <div class="bg-white rounded-2xl p-6 border border-gray-200 hover:shadow-lg transition-shadow duration-200 flex flex-col">
                {{-- Employee Header --}}
                <div class="flex items-center mb-4">
                    <div
                        class="w-12 h-12 bg-gradient-to-br from-blue-400 to-blue-600 rounded-full flex items-center justify-center flex-shrink-0">
                        <span class="text-white font-semibold text-lg">{{ $initials }}</span>
                    </div>
                    <div class="ml-3 flex-1 min-w-0">
                        <h3 class="font-semibold text-gray-900 truncate">{{ $employee->name }}</h3>
                        <p class="text-sm text-gray-500">EMP-{{ str_pad($employee->id, 4, '0', STR_PAD_LEFT) }}</p>
                    </div>
                </div>

                {{-- Contact Info --}}
                <div class="mb-4 space-y-2">
                    <div class="flex items-center text-sm text-gray-600">
                        <svg class="w-4 h-4 mr-2 flex-shrink-0" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M3 8l7.89 4.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z">
                            </path>
                        </svg>
                        <span class="truncate">{{ $employee->email }}</span>
                    </div>
                    <div class="flex items-center text-sm text-gray-600">
                        <svg class="w-4 h-4 mr-2 flex-shrink-0" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z">
                            </path>
                        </svg>
                        {{ $employee->phone ?? 'N/A' }}
                    </div>
                </div>

                {{-- Today's Schedule --}}
                <div class="mb-4 p-3 bg-gray-50 rounded-lg">
                    <div class="flex items-center justify-between text-sm">
                        <span class="text-gray-600">Today's Shift:</span>
                        <span class="font-medium text-gray-900">
                            @if ($todaySchedule)
                                {{ date('g:i A', strtotime($todaySchedule->start_time)) }} -
                                {{ date('g:i A', strtotime($todaySchedule->end_time)) }}
                            @else
                                <span class="text-gray-400">No schedule</span>
                            @endif
                        </span>
                    </div>
                </div>

                {{-- Weekly Schedule Indicator --}}
                @if ($employee->employeeSchedules->count() > 0)
                    <div class="mb-4">
                        <div class="flex items-center justify-between mb-2">
                            <span class="text-xs font-medium text-gray-600">Weekly Schedule</span>
                            <span class="text-xs text-gray-500">{{ $employee->employeeSchedules->count() }} days</span>
                        </div>
                        <div class="flex gap-1">
                            @foreach (['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'] as $day)
                                @php
                                    $hasSchedule =
                                        $employee->employeeSchedules->where('day_of_week', $day)->count() > 0;
                                @endphp
                                <div class="flex-1 h-2 rounded-full {{ $hasSchedule ? 'bg-blue-500' : 'bg-gray-200' }}"
                                    title="{{ $day }}"></div>
                            @endforeach
                        </div>
                    </div>
                @endif

                {{-- Schedule List with Edit/Delete --}}
                @if ($employee->employeeSchedules->count() > 0)
                    <div class="pt-4 border-t border-gray-200 flex-grow flex flex-col">
                        <div class="space-y-2 mb-3 flex-grow">
                            @foreach ($employee->employeeSchedules as $schedule)
                                <div
                                    class="flex items-center justify-between p-2 hover:bg-gray-50 rounded-lg transition-colors">
                                    <div class="flex items-center gap-2 flex-1 min-w-0">
                                        <span
                                            class="font-medium text-gray-700 text-xs w-8 flex-shrink-0">{{ $schedule->day_of_week }}</span>
                                        <span class="text-gray-600 text-xs truncate">
                                            {{ date('g:i A', strtotime($schedule->start_time)) }} -
                                            {{ date('g:i A', strtotime($schedule->end_time)) }}
                                        </span>
                                    </div>
                                    <div class="flex gap-1 flex-shrink-0">
                                        <button
                                            wire:click="$dispatch('openEditModal', {scheduleId: {{ $schedule->id }}})"
                                            class="p-1.5 text-blue-600 hover:bg-blue-50 rounded transition-colors"
                                            title="Edit">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                            </svg>
                                        </button>
                                        <button
                                            wire:click="$dispatch('openDeleteModal', {scheduleId: {{ $schedule->id }}})"
                                            class="p-1.5 text-red-600 hover:bg-red-50 rounded transition-colors"
                                            title="Delete">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                            </svg>
                                        </button>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        {{-- Add More Schedule Button --}}
                        <button wire:click="$dispatch('openCreateModal', {employeeId: {{ $employee->id }}})"
                            class="w-full px-3 py-2 text-sm font-medium text-blue-600 bg-blue-50 hover:bg-blue-100 rounded-lg transition-colors">
                            <svg class="w-4 h-4 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 4v16m8-8H4" />
                            </svg>
                            Add Schedule
                        </button>
                    </div>
                @else
                    <div class="pt-4 border-t border-gray-200 text-center">
                        <p class="text-sm text-gray-500 mb-3">No schedules yet</p>
                        <button wire:click="$dispatch('openCreateModal', {employeeId: {{ $employee->id }}})"
                            class="w-full px-3 py-2 text-sm font-medium text-blue-600 bg-blue-50 hover:bg-blue-100 rounded-lg transition-colors">
                            <svg class="w-4 h-4 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 4v16m8-8H4" />
                            </svg>
                            Add First Schedule
                        </button>
                    </div>
                @endif
            </div>
        @empty
            <div class="col-span-full text-center py-12">
                <svg class="w-16 h-16 mx-auto text-gray-400 mb-4" fill="none" stroke="currentColor"
                    viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4" />
                </svg>
                <p class="text-gray-500 text-lg">No employees found</p>
            </div>
        @endforelse
    </div>

    <x-pagination :items="$employees" />
</div>
