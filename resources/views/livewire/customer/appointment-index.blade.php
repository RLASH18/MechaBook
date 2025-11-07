<div>
    {{-- Appointments Table --}}
    <div class="overflow-hidden rounded-2xl border border-gray-200 bg-white pt-4">
        <x-table.header title="My Appointments" />

        {{-- Status Filter Tabs --}}
        <div class="px-6 py-4 bg-gray-50 border-y border-gray-200">
            <div class="flex flex-wrap gap-2">
                <button wire:click="$set('status', 'all')"
                    class="px-3 py-1.5 rounded-lg text-xs font-medium transition-all {{ $status === 'all' ? 'bg-indigo-600 text-white shadow-sm' : 'bg-white text-gray-700 hover:bg-gray-100 border border-gray-200' }}">
                    All ({{ $statusCounts['all'] }})
                </button>
                <button wire:click="$set('status', 'pending')"
                    class="px-3 py-1.5 rounded-lg text-xs font-medium transition-all {{ $status === 'pending' ? 'bg-yellow-500 text-white shadow-sm' : 'bg-white text-yellow-700 hover:bg-yellow-50 border border-yellow-200' }}">
                    Pending ({{ $statusCounts['pending'] }})
                </button>
                <button wire:click="$set('status', 'approved')"
                    class="px-3 py-1.5 rounded-lg text-xs font-medium transition-all {{ $status === 'approved' ? 'bg-green-500 text-white shadow-sm' : 'bg-white text-green-700 hover:bg-green-50 border border-green-200' }}">
                    Approved ({{ $statusCounts['approved'] }})
                </button>
                <button wire:click="$set('status', 'started')"
                    class="px-3 py-1.5 rounded-lg text-xs font-medium transition-all {{ $status === 'started' ? 'bg-blue-500 text-white shadow-sm' : 'bg-white text-blue-700 hover:bg-blue-50 border border-blue-200' }}">
                    Started ({{ $statusCounts['started'] }})
                </button>
                <button wire:click="$set('status', 'completed')"
                    class="px-3 py-1.5 rounded-lg text-xs font-medium transition-all {{ $status === 'completed' ? 'bg-purple-500 text-white shadow-sm' : 'bg-white text-purple-700 hover:bg-purple-50 border border-purple-200' }}">
                    Completed ({{ $statusCounts['completed'] }})
                </button>
                <button wire:click="$set('status', 'rejected')"
                    class="px-3 py-1.5 rounded-lg text-xs font-medium transition-all {{ $status === 'rejected' ? 'bg-red-500 text-white shadow-sm' : 'bg-white text-red-700 hover:bg-red-50 border border-red-200' }}">
                    Rejected ({{ $statusCounts['rejected'] }})
                </button>
                <button wire:click="$set('status', 'cancelled')"
                    class="px-3 py-1.5 rounded-lg text-xs font-medium transition-all {{ $status === 'cancelled' ? 'bg-gray-500 text-white shadow-sm' : 'bg-white text-gray-700 hover:bg-gray-100 border border-gray-200' }}">
                    Cancelled ({{ $statusCounts['cancelled'] }})
                </button>
            </div>
        </div>

        {{-- Table --}}
        <div class="max-w-full overflow-x-auto custom-scrollbar">
            <x-table.table>

                {{-- Head --}}
                <x-table.thead :headers="['Appointment ID', 'Service', 'Date & Time', 'Employee', 'Status']" />

                {{-- Body --}}
                <x-table.tbody>
                    @forelse ($appointments as $appointment)
                        <tr class="hover:bg-gray-50 transition-colors">
                            {{-- Appointment ID --}}
                            <x-table.td>
                                <span class="font-semibold text-gray-900 text-sm">
                                    {{ 'APT-' . str_pad($appointment->id, 4, '0', STR_PAD_LEFT) }}
                                </span>
                            </x-table.td>

                            {{-- Service --}}
                            <x-table.td>
                                <div>
                                    <p class="font-medium text-gray-900 text-sm mb-1 truncate max-w-[200px]"
                                        title="{{ $appointment->service->name }}">{{ $appointment->service->name }}
                                    </p>
                                    @php
                                        $categoryColors = [
                                            'Maintenance' => 'bg-green-100 text-green-800',
                                            'Repair' => 'bg-blue-100 text-blue-800',
                                            'Inspection' => 'bg-yellow-100 text-yellow-800',
                                            'Detailing' => 'bg-purple-100 text-purple-800',
                                            'Diagnostic' => 'bg-pink-100 text-pink-800',
                                        ];
                                        $colorClass =
                                            $categoryColors[$appointment->service->category] ??
                                            'bg-gray-100 text-gray-800';
                                    @endphp
                                    <span
                                        class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium {{ $colorClass }}">
                                        {{ $appointment->service->category }}
                                    </span>
                                </div>
                            </x-table.td>

                            {{-- Date & Time --}}
                            <x-table.td>
                                <div>
                                    <p class="font-medium text-gray-900 text-sm">
                                        {{ \Carbon\Carbon::parse($appointment->appointment_date)->format('M d, Y') }}
                                    </p>
                                    <p class="text-xs text-gray-500 mt-0.5">
                                        {{ \Carbon\Carbon::parse($appointment->start_time)->format('h:i A') }} -
                                        {{ \Carbon\Carbon::parse($appointment->end_time)->format('h:i A') }}
                                    </p>
                                </div>
                            </x-table.td>

                            {{-- Employee --}}
                            <x-table.td>
                                @if ($appointment->employee)
                                    <div class="flex items-center gap-2.5">
                                        @php
                                            $empNameParts = explode(' ', $appointment->employee->name);
                                            $empFirstName = $empNameParts[0] ?? '';
                                            $empLastName = end($empNameParts) ?? '';
                                            $empInitials = strtoupper(
                                                substr($empFirstName, 0, 1) . substr($empLastName, 0, 1),
                                            );
                                        @endphp
                                        <div
                                            class="w-9 h-9 bg-gradient-to-br from-green-400 to-green-600 rounded-full flex items-center justify-center flex-shrink-0">
                                            <span class="text-white font-semibold text-xs">{{ $empInitials }}</span>
                                        </div>
                                        <span
                                            class="text-sm text-gray-900 font-medium">{{ $appointment->employee->name }}</span>
                                    </div>
                                @else
                                    <span class="text-xs text-gray-400">Not assigned yet</span>
                                @endif
                            </x-table.td>

                            {{-- Status --}}
                            <x-table.td>
                                @php
                                    $statusConfig = [
                                        'pending' => ['bg' => 'bg-yellow-50', 'text' => 'text-yellow-600', 'dot' => 'bg-yellow-500',],
                                        'approved' => ['bg' => 'bg-green-50', 'text' => 'text-green-600','dot' => 'bg-green-500',],
                                        'rejected' => ['bg' => 'bg-red-50', 'text' => 'text-red-600', 'dot' => 'bg-red-500',],
                                        'cancelled' => ['bg' => 'bg-gray-50', 'text' => 'text-gray-600', 'dot' => 'bg-gray-500',],
                                        'started' => ['bg' => 'bg-blue-50', 'text' => 'text-blue-600', 'dot' => 'bg-blue-500',],
                                        'completed' => ['bg' => 'bg-purple-50', 'text' => 'text-purple-600','dot' => 'bg-purple-500',],
                                    ];
                                    $config = $statusConfig[$appointment->status] ?? [
                                        'bg' => 'bg-gray-50',
                                        'text' => 'text-gray-600',
                                        'dot' => 'bg-gray-500',
                                    ];
                                @endphp
                                <span
                                    class="inline-flex items-center gap-1.5 px-2 py-0.5 rounded-full text-xs font-medium {{ $config['bg'] }} {{ $config['text'] }}">
                                    <span class="w-1.5 h-1.5 rounded-full {{ $config['dot'] }}"></span>
                                    {{ ucfirst($appointment->status) }}
                                </span>
                            </x-table.td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-12">
                                <div class="text-center">
                                    <svg class="w-16 h-16 mx-auto text-gray-400 mb-4" fill="none"
                                        stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                    </svg>
                                    <p class="text-gray-500 text-lg font-medium">No appointments found</p>
                                    <p class="text-gray-400 text-sm mt-1">Try adjusting your search or filters</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </x-table.tbody>
            </x-table.table>
        </div>

        {{-- Pagination --}}
        <x-pagination :items="$appointments" />
    </div>
</div>
