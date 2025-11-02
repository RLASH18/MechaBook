@extends('layouts.app')
@section('main')
    {{-- Header --}}
    <div class="flex items-center justify-between mb-4">
        <div>
            <x-page-header title="My Schedule">
                View your personal work schedule and upcoming shifts.
            </x-page-header>
        </div>
    </div>

    {{-- Today's Shift Card --}}
    <div class="bg-gradient-to-br from-blue-500 to-blue-600 rounded-2xl p-5 mb-6 text-white shadow-lg">
        <div class="flex items-center justify-between">
            <div>
                <div class="flex items-center gap-2 mb-2">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <h2 class="text-lg font-semibold">Today's Shift</h2>
                </div>
                <p class="text-blue-100 text-sm mb-4">{{ now()->format('l, F j, Y') }}</p>
                @if ($todaySchedule)
                    <div class="flex items-center gap-4">
                        <div>
                            <p class="text-blue-100 text-xs mb-1">Start Time</p>
                            <p class="text-2xl font-bold">{{ date('g:i A', strtotime($todaySchedule->start_time)) }}</p>
                        </div>
                        <div class="text-3xl font-light">-</div>
                        <div>
                            <p class="text-blue-100 text-xs mb-1">End Time</p>
                            <p class="text-2xl font-bold">{{ date('g:i A', strtotime($todaySchedule->end_time)) }}</p>
                        </div>
                    </div>
                    @php
                        $start = strtotime($todaySchedule->start_time);
                        $end = strtotime($todaySchedule->end_time);
                        $hours = ($end - $start) / 3600;
                    @endphp
                    <p class="text-blue-100 text-sm mt-3">Duration: {{ number_format($hours, 1) }} hours</p>
                @else
                    <div class="flex items-center gap-3">
                        <svg class="w-12 h-12 text-blue-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4" />
                        </svg>
                        <div>
                            <p class="text-xl font-semibold">No Shift Today</p>
                            <p class="text-blue-100 text-sm">Enjoy your day off!</p>
                        </div>
                    </div>
                @endif
            </div>
            <div class="hidden md:block">
                <svg class="w-32 h-32 text-blue-400 opacity-20" fill="currentColor" viewBox="0 0 24 24">
                    <path
                        d="M19 4h-1V2h-2v2H8V2H6v2H5c-1.11 0-1.99.9-1.99 2L3 20c0 1.1.89 2 2 2h14c1.1 0 2-.9 2-2V6c0-1.1-.9-2-2-2zm0 16H5V10h14v10zM9 14H7v-2h2v2zm4 0h-2v-2h2v2zm4 0h-2v-2h2v2zm-8 4H7v-2h2v2zm4 0h-2v-2h2v2zm4 0h-2v-2h2v2z" />
                </svg>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-6">
        {{-- Weekly Schedule Stats --}}
        <div class="bg-white rounded-2xl p-6 border border-gray-200">
            <div class="flex items-center justify-between mb-4">
                <h3 class="font-semibold text-gray-900">Weekly Overview</h3>
                <div class="w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center">
                    <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                    </svg>
                </div>
            </div>
            <div class="space-y-3">
                <div class="flex items-center justify-between">
                    <span class="text-sm text-gray-600">Working Days</span>
                    <span class="text-lg font-bold text-gray-900">{{ $schedules->count() }}/7</span>
                </div>
                <div class="flex items-center justify-between">
                    <span class="text-sm text-gray-600">Total Hours</span>
                    <span class="text-lg font-bold text-gray-900">{{ number_format($totalHours, 1) }}h</span>
                </div>
                <div class="flex items-center justify-between">
                    <span class="text-sm text-gray-600">Avg. Hours/Day</span>
                    <span class="text-lg font-bold text-gray-900">{{ number_format($averageHours, 1) }}h</span>
                </div>
            </div>
        </div>

        {{-- Quick Actions --}}
        <div class="bg-white rounded-2xl p-6 border border-gray-200">
            <div class="flex items-center justify-between mb-4">
                <h3 class="font-semibold text-gray-900">Quick Actions</h3>
                <div class="w-10 h-10 bg-green-100 rounded-lg flex items-center justify-center">
                    <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M13 10V3L4 14h7v7l9-11h-7z" />
                    </svg>
                </div>
            </div>
            <div class="space-y-2">
                <button onclick="Livewire.dispatch('openRequestChangeModal')"
                    class="w-full px-4 py-3 text-left text-sm font-medium text-gray-700 bg-gray-50 hover:bg-gray-100 rounded-lg transition-colors flex items-center justify-between group">
                    <span class="flex items-center gap-2">
                        <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4" />
                        </svg>
                        Request Schedule Change
                    </span>
                    <svg class="w-5 h-5 text-gray-400 group-hover:text-gray-600" fill="none" stroke="currentColor"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                    </svg>
                </button>
                <button onclick="Livewire.dispatch('openCalendarModal')"
                    class="w-full px-4 py-3 text-left text-sm font-medium text-gray-700 bg-gray-50 hover:bg-gray-100 rounded-lg transition-colors flex items-center justify-between group">
                    <span class="flex items-center gap-2">
                        <svg class="w-5 h-5 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>
                        View Full Calendar
                    </span>
                    <svg class="w-5 h-5 text-gray-400 group-hover:text-gray-600" fill="none" stroke="currentColor"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                    </svg>
                </button>
            </div>
        </div>

        {{-- Next Shift --}}
        <div class="bg-white rounded-2xl p-6 border border-gray-200">
            <div class="flex items-center justify-between mb-4">
                <h3 class="font-semibold text-gray-900">Next Shift</h3>
                <div class="w-10 h-10 bg-orange-100 rounded-lg flex items-center justify-center">
                    <svg class="w-6 h-6 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6" />
                    </svg>
                </div>
            </div>
            @if ($nextSchedule)
                <div class="space-y-3">
                    <div class="flex items-center justify-between">
                        <span class="text-sm text-gray-600">Day</span>
                        <span
                            class="text-base font-semibold text-gray-900">{{ $daysOfWeek[$nextSchedule->day_of_week] }}</span>
                    </div>
                    <div class="flex items-center justify-between">
                        <span class="text-sm text-gray-600">Time</span>
                        <span class="text-base font-semibold text-gray-900">
                            {{ date('g:i A', strtotime($nextSchedule->start_time)) }}
                        </span>
                    </div>
                    <div class="pt-3 border-t border-gray-200">
                        <p class="text-xs text-gray-500 text-center">
                            {{ date('g:i A', strtotime($nextSchedule->start_time)) }} -
                            {{ date('g:i A', strtotime($nextSchedule->end_time)) }}
                        </p>
                    </div>
                </div>
            @else
                <div class="text-center py-4">
                    <p class="text-sm text-gray-500">No upcoming shifts</p>
                </div>
            @endif
        </div>
    </div>

    {{-- Weekly Schedule Calendar --}}
    <div class="bg-white rounded-2xl p-6 border border-gray-200">
        <div class="flex items-center justify-between mb-6">
            <h3 class="text-lg font-semibold text-gray-900">Weekly Schedule</h3>
            <div class="flex items-center gap-2">
                <span class="text-sm text-gray-500">Week {{ now()->format('W') }}</span>
            </div>
        </div>

        @if ($schedules->count() > 0)
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-4">
                @foreach ($daysOfWeek as $dayShort => $dayFull)
                    @php
                        $daySchedule = $schedules->where('day_of_week', $dayShort)->first();
                        $isToday = $currentDay === $dayShort;
                    @endphp
                    <div
                        class="p-4 rounded-xl border-2 transition-all {{ $isToday ? 'border-blue-500 bg-blue-50' : ($daySchedule ? 'border-gray-200 bg-white hover:border-blue-300' : 'border-gray-200 bg-gray-50') }}">
                        <div class="flex items-center justify-between mb-3">
                            <div>
                                <h4 class="font-semibold {{ $isToday ? 'text-blue-700' : 'text-gray-900' }}">
                                    {{ $dayFull }}
                                </h4>
                                <p class="text-xs {{ $isToday ? 'text-blue-600' : 'text-gray-500' }}">
                                    {{ $dayShort }}
                                </p>
                            </div>
                            @if ($isToday)
                                <span
                                    class="px-2 py-1 text-xs font-medium text-blue-700 bg-blue-200 rounded-full">Today</span>
                            @endif
                        </div>

                        @if ($daySchedule)
                            <div class="space-y-2">
                                <div class="flex items-center gap-2 text-sm">
                                    <svg class="w-4 h-4 {{ $isToday ? 'text-blue-600' : 'text-gray-500' }}"
                                        fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                    <span class="{{ $isToday ? 'text-blue-700 font-medium' : 'text-gray-700' }}">
                                        {{ date('g:i A', strtotime($daySchedule->start_time)) }}
                                    </span>
                                </div>
                                <div class="flex items-center gap-2 text-sm">
                                    <svg class="w-4 h-4 {{ $isToday ? 'text-blue-600' : 'text-gray-500' }}"
                                        fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                    <span class="{{ $isToday ? 'text-blue-700 font-medium' : 'text-gray-700' }}">
                                        {{ date('g:i A', strtotime($daySchedule->end_time)) }}
                                    </span>
                                </div>
                                @php
                                    $start = strtotime($daySchedule->start_time);
                                    $end = strtotime($daySchedule->end_time);
                                    $hours = ($end - $start) / 3600;
                                @endphp
                                <div class="pt-2 mt-2 border-t {{ $isToday ? 'border-blue-200' : 'border-gray-200' }}">
                                    <p class="text-xs {{ $isToday ? 'text-blue-600' : 'text-gray-500' }}">
                                        Duration: {{ number_format($hours, 1) }} hours
                                    </p>
                                </div>
                            </div>
                        @else
                            <div class="text-center py-4">
                                <svg class="w-8 h-8 mx-auto text-gray-300 mb-2" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4" />
                                </svg>
                                <p class="text-xs text-gray-400">Day Off</p>
                            </div>
                        @endif
                    </div>
                @endforeach
            </div>
        @else
            <div class="text-center py-12">
                <svg class="w-16 h-16 mx-auto text-gray-300 mb-4" fill="none" stroke="currentColor"
                    viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                </svg>
                <h3 class="text-lg font-semibold text-gray-900 mb-2">No Schedule Assigned</h3>
                <p class="text-gray-500">Your work schedule hasn't been set up yet. Please contact your administrator.</p>
            </div>
        @endif
    </div>

    @livewire('employee.schedule.request-change-modal')
    @livewire('employee.schedule.calendar-modal')
@endsection
