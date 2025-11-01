<div>
    <x-modal :show="$showModal" maxWidth="5xl" title="{{ \Carbon\Carbon::create($currentYear, $currentMonth, 1)->format('F Y') }} - Work Schedule">
        <div class="max-h-[calc(100vh-16rem)] overflow-y-auto">
            <div class="space-y-4">

            {{-- Navigation --}}
            <div class="flex items-center justify-between gap-2 mb-4">
                <button wire:click="previousMonth"
                    class="px-3 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 transition-colors">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                    </svg>
                </button>

                <button wire:click="goToToday"
                    class="px-4 py-2 text-sm font-medium text-blue-600 bg-blue-50 border border-blue-200 rounded-lg hover:bg-blue-100 transition-colors">
                    Today
                </button>

                <button wire:click="nextMonth"
                    class="px-3 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 transition-colors">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                    </svg>
                </button>
            </div>

            {{-- Calendar Grid --}}
            <div class="bg-white rounded-lg border border-gray-200 overflow-hidden">
                {{-- Day Headers --}}
                <div class="grid grid-cols-7 bg-gray-50 border-b border-gray-200">
                    @foreach (['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'] as $day)
                        <div class="py-2 text-center text-xs font-semibold text-gray-700">
                            {{ $day }}
                        </div>
                    @endforeach
                </div>

                {{-- Calendar Days --}}
                <div class="divide-y divide-gray-200">
                    @foreach ($calendarDays as $week)
                        <div class="grid grid-cols-7 divide-x divide-gray-200">
                            @foreach ($week as $day)
                                @if ($day === null)
                                    <div class="min-h-[70px] bg-gray-50"></div>
                                @else
                                    <div
                                        class="min-h-[70px] p-2 {{ $day['isToday'] ? 'bg-blue-50' : 'bg-white' }} hover:bg-gray-50 transition-colors">
                                        <div class="flex flex-col h-full">
                                            {{-- Day Number --}}
                                            <div class="flex items-center justify-between mb-1">
                                                <span
                                                    class="text-sm font-semibold {{ $day['isToday'] ? 'text-blue-600' : 'text-gray-900' }}">
                                                    {{ $day['day'] }}
                                                </span>
                                                @if ($day['isToday'])
                                                    <span
                                                        class="px-1.5 py-0.5 text-xs font-medium text-blue-700 bg-blue-200 rounded">
                                                        Today
                                                    </span>
                                                @endif
                                            </div>

                                            {{-- Schedule Info --}}
                                            @if ($day['schedule'])
                                                <div class="flex-1 mt-1">
                                                    <div class="p-2 bg-blue-100 rounded-lg border border-blue-200">
                                                        <div class="flex items-center gap-1 text-xs text-blue-900 mb-1">
                                                            <svg class="w-3 h-3" fill="none" stroke="currentColor"
                                                                viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                                    stroke-width="2"
                                                                    d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                            </svg>
                                                            <span class="font-medium">Work</span>
                                                        </div>
                                                        <div class="text-xs text-blue-800">
                                                            {{ date('g:i A', strtotime($day['schedule']->start_time)) }}
                                                        </div>
                                                        <div class="text-xs text-blue-800">
                                                            {{ date('g:i A', strtotime($day['schedule']->end_time)) }}
                                                        </div>
                                                    </div>
                                                </div>
                                            @else
                                                <div class="flex-1 flex items-center justify-center">
                                                    <span class="text-xs text-gray-400">Off</span>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                @endif
                            @endforeach
                        </div>
                    @endforeach
                </div>
            </div>

            {{-- Legend --}}
            <div class="flex items-center justify-center gap-6 mt-4 text-sm">
                <div class="flex items-center gap-2">
                    <div class="w-4 h-4 bg-blue-100 border border-blue-200 rounded"></div>
                    <span class="text-gray-600">Working Day</span>
                </div>
                <div class="flex items-center gap-2">
                    <div class="w-4 h-4 bg-white border border-gray-200 rounded"></div>
                    <span class="text-gray-600">Day Off</span>
                </div>
                <div class="flex items-center gap-2">
                    <div class="w-4 h-4 bg-blue-50 border border-blue-300 rounded"></div>
                    <span class="text-gray-600">Today</span>
                </div>
            </div>
            </div>
        </div>
    </x-modal>
</div>
