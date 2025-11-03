<div>
    {{-- Appointments Table --}}
    <div class="overflow-hidden rounded-2xl border border-gray-200 bg-white pt-4">
        <x-table.header title="Appointments List" />

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
                <x-table.thead :headers="['Appointment ID', 'Customer', 'Service', 'Date & Time', 'Employee', 'Status', 'Actions']" />

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

                            {{-- Customer --}}
                            <x-table.td>
                                <div class="flex items-center gap-3">
                                    @php
                                        $nameParts = explode(' ', $appointment->customer->name);
                                        $firstName = $nameParts[0] ?? '';
                                        $lastName = end($nameParts) ?? '';
                                        $initials = strtoupper(substr($firstName, 0, 1) . substr($lastName, 0, 1));
                                    @endphp
                                    <div
                                        class="w-10 h-10 bg-gradient-to-br from-indigo-500 to-indigo-600 rounded-full flex items-center justify-center flex-shrink-0">
                                        <span class="text-white font-semibold text-sm">{{ $initials }}</span>
                                    </div>
                                    <div class="min-w-0">
                                        <p class="font-medium text-gray-900 text-sm">{{ $appointment->customer->name }}
                                        </p>
                                        <p class="text-xs text-gray-500 truncate">{{ $appointment->customer->email }}
                                        </p>
                                    </div>
                                </div>
                            </x-table.td>

                            {{-- Service --}}
                            <x-table.td>
                                <div>
                                    <p class="font-medium text-gray-900 text-sm mb-1 truncate max-w-[150px]"
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
                                    <span class="text-xs text-gray-400">Not assigned</span>
                                @endif
                            </x-table.td>

                            {{-- Status --}}
                            <x-table.td>
                                @php
                                    $statusConfig = [
                                        'pending' => [
                                            'bg' => 'bg-yellow-50',
                                            'text' => 'text-yellow-600',
                                            'dot' => 'bg-yellow-500',
                                        ],
                                        'approved' => [
                                            'bg' => 'bg-green-50',
                                            'text' => 'text-green-600',
                                            'dot' => 'bg-green-500',
                                        ],
                                        'rejected' => [
                                            'bg' => 'bg-red-50',
                                            'text' => 'text-red-600',
                                            'dot' => 'bg-red-500',
                                        ],
                                        'cancelled' => [
                                            'bg' => 'bg-gray-50',
                                            'text' => 'text-gray-600',
                                            'dot' => 'bg-gray-500',
                                        ],
                                        'started' => [
                                            'bg' => 'bg-blue-50',
                                            'text' => 'text-blue-600',
                                            'dot' => 'bg-blue-500',
                                        ],
                                        'completed' => [
                                            'bg' => 'bg-purple-50',
                                            'text' => 'text-purple-600',
                                            'dot' => 'bg-purple-500',
                                        ],
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

                            {{-- Actions --}}
                            <x-table.td>
                                <div class="flex items-center gap-4">
                                    {{-- Show/View Button - Available for all statuses --}}
                                    <button
                                        wire:click="$dispatch('openShowModal', {appointmentId: {{ $appointment->id }}})"
                                        title="View Details">
                                        <svg class="w-5 h-5 cursor-pointer fill-gray-700 hover:fill-indigo-600"
                                            xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                                            <path
                                                d="M12.0003 3C17.3924 3 21.8784 6.87976 22.8189 12C21.8784 17.1202 17.3924 21 12.0003 21C6.60812 21 2.12215 17.1202 1.18164 12C2.12215 6.87976 6.60812 3 12.0003 3ZM12.0003 19C16.2359 19 19.8603 16.052 20.7777 12C19.8603 7.94803 16.2359 5 12.0003 5C7.7646 5 4.14022 7.94803 3.22278 12C4.14022 16.052 7.7646 19 12.0003 19ZM12.0003 16.5C9.51498 16.5 7.50026 14.4853 7.50026 12C7.50026 9.51472 9.51498 7.5 12.0003 7.5C14.4855 7.5 16.5003 9.51472 16.5003 12C16.5003 14.4853 14.4855 16.5 12.0003 16.5ZM12.0003 14.5C13.381 14.5 14.5003 13.3807 14.5003 12C14.5003 10.6193 13.381 9.5 12.0003 9.5C10.6196 9.5 9.50026 10.6193 9.50026 12C9.50026 13.3807 10.6196 14.5 12.0003 14.5Z" />
                                        </svg>
                                    </button>

                                    {{-- Pending: Approve or Reject --}}
                                    @if ($appointment->status === 'pending')
                                        <button
                                            wire:click="$dispatch('openApproveModal', {appointmentId: {{ $appointment->id }}})"
                                            title="Approve">
                                            <svg class="w-5 h-5 cursor-pointer fill-gray-700 hover:fill-green-600"
                                                xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"
                                                fill="currentColor">
                                                <path
                                                    d="M10.0007 15.1709L19.1931 5.97852L20.6073 7.39273L10.0007 17.9993L3.63672 11.6354L5.05093 10.2212L10.0007 15.1709Z" />
                                            </svg>
                                        </button>
                                        <button
                                            wire:click="$dispatch('openRejectModal', {appointmentId: {{ $appointment->id }}})"
                                            title="Reject">
                                            <svg class="w-5 h-5 cursor-pointer fill-gray-700 hover:fill-red-600"
                                                xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"
                                                fill="currentColor">
                                                <path
                                                    d="M11.9997 10.5865L16.9495 5.63672L18.3637 7.05093L13.4139 12.0007L18.3637 16.9504L16.9495 18.3646L11.9997 13.4149L7.04996 18.3646L5.63574 16.9504L10.5855 12.0007L5.63574 7.05093L7.04996 5.63672L11.9997 10.5865Z" />
                                            </svg>
                                        </button>

                                        {{-- Approved: Start Service or Reassign --}}
                                    @elseif($appointment->status === 'approved')
                                        <button
                                            wire:click="$dispatch('updateStatus', {appointmentId: {{ $appointment->id }}, status: 'started'})"
                                            title="Start Service">
                                            <svg class="w-5 h-5 cursor-pointer fill-gray-700 hover:fill-blue-600"
                                                xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"
                                                fill="currentColor">
                                                <path
                                                    d="M19.376 12.4158L8.77735 19.4816C8.54759 19.6348 8.23715 19.5727 8.08397 19.3429C8.02922 19.2608 8 19.1643 8 19.0656V4.93408C8 4.65794 8.22386 4.43408 8.5 4.43408C8.59871 4.43408 8.69522 4.4633 8.77735 4.51806L19.376 11.5838C19.6057 11.737 19.6678 12.0474 19.5146 12.2772C19.478 12.3321 19.4309 12.3792 19.376 12.4158Z" />
                                            </svg>
                                        </button>
                                        @if ($appointment->employee)
                                            <button
                                                wire:click="$dispatch('openApproveModal', {appointmentId: {{ $appointment->id }}})"
                                                title="Reassign Employee">
                                                <svg class="w-5 h-5 cursor-pointer fill-gray-700 hover:fill-indigo-600"
                                                    xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"
                                                    fill="currentColor">
                                                    <path
                                                        d="M14 14.252V16.3414C13.3744 16.1203 12.7013 16 12 16C8.68629 16 6 18.6863 6 22H4C4 17.5817 7.58172 14 12 14C12.6906 14 13.3608 14.0875 14 14.252ZM12 13C8.685 13 6 10.315 6 7C6 3.685 8.685 1 12 1C15.315 1 18 3.685 18 7C18 10.315 15.315 13 12 13ZM12 11C14.21 11 16 9.21 16 7C16 4.79 14.21 3 12 3C9.79 3 8 4.79 8 7C8 9.21 9.79 11 12 11ZM18 17V14H20V17H23V19H20V22H18V19H15V17H18Z" />
                                                </svg>
                                            </button>
                                        @endif

                                        {{-- Started: Complete Service --}}
                                    @elseif($appointment->status === 'started')
                                        <button
                                            wire:click="$dispatch('updateStatus', {appointmentId: {{ $appointment->id }}, status: 'completed'})"
                                            title="Complete Service">
                                            <svg class="w-5 h-5 cursor-pointer fill-gray-700 hover:fill-purple-600"
                                                xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"
                                                fill="currentColor">
                                                <path
                                                    d="M9.9997 15.1709L19.1921 5.97852L20.6063 7.39273L9.9997 17.9993L3.63574 11.6354L5.04996 10.2212L9.9997 15.1709ZM8.99966 15.1709L5.04996 11.2212L3.63574 12.6354L8.99966 17.9993L20.6063 6.39273L19.1921 4.97852L8.99966 15.1709Z" />
                                            </svg>
                                        </button>
                                    @endif
                                </div>
                            </x-table.td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-6 py-12">
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
