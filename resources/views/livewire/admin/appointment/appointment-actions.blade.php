<div>
    {{-- Approve & Assign Employee Modal --}}
    <x-modal :show="$showApproveModal" title="Approve & Assign Employee">
        @if ($appointment)
            <form wire:submit.prevent="approveAppointment" class="space-y-4">
                {{-- Appointment Details --}}
                <div class="p-4 bg-gray-50 rounded-lg">
                    <div class="grid grid-cols-2 gap-3">
                        <div>
                            <p class="text-xs text-gray-600 mb-1">Customer</p>
                            <p class="font-medium text-gray-800 text-sm">{{ $appointment->customer->name }}</p>
                        </div>
                        <div>
                            <p class="text-xs text-gray-600 mb-1">Service</p>
                            <p class="font-medium text-gray-800 text-sm">{{ $appointment->service->name }}</p>
                        </div>
                        <div>
                            <p class="text-xs text-gray-600 mb-1">Date</p>
                            <p class="font-medium text-gray-800 text-sm">
                                {{ \Carbon\Carbon::parse($appointment->appointment_date)->format('M d, Y') }}
                            </p>
                        </div>
                        <div>
                            <p class="text-xs text-gray-600 mb-1">Time</p>
                            <p class="font-medium text-gray-800 text-sm">
                                {{ \Carbon\Carbon::parse($appointment->start_time)->format('h:i A') }} -
                                {{ \Carbon\Carbon::parse($appointment->end_time)->format('h:i A') }}
                            </p>
                        </div>
                    </div>
                </div>

                {{-- Employee Selection --}}
                <div>
                    <x-form.label for="selectedEmployee">Assign Employee *</x-form.label>
                    <x-form.select name="selectedEmployee" wire:model="selectedEmployee">
                        <option value="">Choose an employee...</option>
                        @foreach ($employees as $employee)
                            <option value="{{ $employee->id }}">{{ $employee->name }}</option>
                        @endforeach
                    </x-form.select>
                    <x-form.error name="selectedEmployee" />
                </div>

                {{-- Action Buttons --}}
                <div class="flex gap-3 pt-4">
                    <button type="button" wire:click="closeModal"
                        class="flex-1 px-4 py-2 text-sm font-medium text-gray-700 bg-gray-100 hover:bg-gray-200 rounded-lg transition-colors">
                        Cancel
                    </button>
                    <button type="submit"
                        class="flex-1 px-4 py-2 text-sm font-medium text-white bg-green-600 hover:bg-green-700 rounded-lg transition-colors">
                        Approve & Assign
                    </button>
                </div>
            </form>
        @endif
    </x-modal>

    {{-- Reject Appointment Modal --}}
    <x-modal :show="$showRejectModal" title="Reject Appointment" maxWidth="md">
        @if ($appointment)
            <form wire:submit.prevent="rejectAppointment" class="space-y-4">
                {{-- Warning Message --}}
                <div class="flex items-start gap-3 p-4 bg-red-50 rounded-lg">
                    <div class="flex-shrink-0">
                        <svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                        </svg>
                    </div>
                    <div>
                        <h4 class="text-sm font-medium text-gray-900 mb-1">Reject this appointment?</h4>
                        <p class="text-sm text-gray-600">
                            Customer: <strong>{{ $appointment->customer->name }}</strong><br>
                            Service: <strong>{{ $appointment->service->name }}</strong><br>
                            Date:
                            <strong>{{ \Carbon\Carbon::parse($appointment->appointment_date)->format('M d, Y') }}</strong>
                        </p>
                    </div>
                </div>

                {{-- Rejection Notes --}}
                <div>
                    <x-form.label for="rejectNotes">Reason for Rejection (Optional)</x-form.label>
                    <x-form.textarea name="rejectNotes" wire:model="rejectNotes" rows="3"
                        placeholder="Enter reason for rejection..."></x-form.textarea>
                    <x-form.error name="rejectNotes" />
                </div>

                {{-- Action Buttons --}}
                <div class="flex gap-3">
                    <button type="button" wire:click="closeModal"
                        class="flex-1 px-4 py-2 text-sm font-medium text-gray-700 bg-gray-100 hover:bg-gray-200 rounded-lg transition-colors">
                        Cancel
                    </button>
                    <button type="submit"
                        class="flex-1 px-4 py-2 text-sm font-medium text-white bg-red-600 hover:bg-red-700 rounded-lg transition-colors">
                        Reject Appointment
                    </button>
                </div>
            </form>
        @endif
    </x-modal>

    {{-- Show/View Appointment Details Modal --}}
    <x-modal :show="$showShowModal" title="Appointment Details" maxWidth="2xl">
        @if ($appointment)
            <div class="space-y-4">
                {{-- Appointment ID & Status --}}
                <div class="flex items-center justify-between pb-3 border-b border-gray-200">
                    <div>
                        <p class="text-xs text-gray-500 mb-0.5">Appointment ID</p>
                        <p class="text-base font-semibold text-gray-900">
                            {{ 'APT-' . str_pad($appointment->id, 4, '0', STR_PAD_LEFT) }}
                        </p>
                    </div>
                    <div>
                        @php
                            $statusConfig = [
                                'pending' => ['bg' => 'bg-yellow-50', 'text' => 'text-yellow-700', 'dot' => 'bg-yellow-500'],
                                'approved' => ['bg' => 'bg-green-50', 'text' => 'text-green-700', 'dot' => 'bg-green-500'],
                                'rejected' => ['bg' => 'bg-red-50', 'text' => 'text-red-700', 'dot' => 'bg-red-500'],
                                'cancelled' => ['bg' => 'bg-gray-50', 'text' => 'text-gray-700', 'dot' => 'bg-gray-500'],
                                'started' => ['bg' => 'bg-blue-50', 'text' => 'text-blue-700', 'dot' => 'bg-blue-500'],
                                'completed' => ['bg' => 'bg-purple-50', 'text' => 'text-purple-700', 'dot' => 'bg-purple-500'],
                            ];
                            $config = $statusConfig[$appointment->status] ?? ['bg' => 'bg-gray-50', 'text' => 'text-gray-700', 'dot' => 'bg-gray-500'];
                        @endphp
                        <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-lg text-xs font-medium {{ $config['bg'] }} {{ $config['text'] }}">
                            <span class="w-1.5 h-1.5 rounded-full {{ $config['dot'] }}"></span>
                            {{ ucfirst($appointment->status) }}
                        </span>
                    </div>
                </div>

                {{-- Two Column Layout --}}
                <div class="grid grid-cols-2 gap-4">
                    {{-- Left Column --}}
                    <div class="flex flex-col gap-3">
                        {{-- Customer Information --}}
                        <div class="bg-gray-50 rounded-lg p-3">
                            <h3 class="text-xs font-semibold text-gray-900 mb-2 flex items-center gap-1.5">
                                <svg class="w-4 h-4 text-indigo-600" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M12 12C14.21 12 16 10.21 16 8C16 5.79 14.21 4 12 4C9.79 4 8 5.79 8 8C8 10.21 9.79 12 12 12ZM12 14C9.33 14 4 15.34 4 18V20H20V18C20 15.34 14.67 14 12 14Z"/>
                                </svg>
                                Customer Information
                            </h3>
                            <div class="space-y-2">
                                <div>
                                    <p class="text-xs text-gray-500 mb-0.5">Name</p>
                                    <p class="text-sm font-medium text-gray-900">{{ $appointment->customer->name }}</p>
                                </div>
                                <div>
                                    <p class="text-xs text-gray-500 mb-0.5">Email</p>
                                    <p class="text-sm font-medium text-gray-900">{{ $appointment->customer->email }}</p>
                                </div>
                            </div>
                        </div>

                        {{-- Schedule Information --}}
                        <div class="bg-gray-50 rounded-lg p-3 flex-1">
                            <h3 class="text-xs font-semibold text-gray-900 mb-2 flex items-center gap-1.5">
                                <svg class="w-4 h-4 text-green-600" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M19 4h-1V2h-2v2H8V2H6v2H5c-1.11 0-1.99.9-1.99 2L3 20c0 1.1.89 2 2 2h14c1.1 0 2-.9 2-2V6c0-1.1-.9-2-2-2zm0 16H5V10h14v10zM9 14H7v-2h2v2zm4 0h-2v-2h2v2zm4 0h-2v-2h2v2zm-8 4H7v-2h2v2zm4 0h-2v-2h2v2zm4 0h-2v-2h2v2z"/>
                                </svg>
                                Schedule
                            </h3>
                            <div class="space-y-2">
                                <div>
                                    <p class="text-xs text-gray-500 mb-0.5">Date</p>
                                    <p class="text-sm font-medium text-gray-900">
                                        {{ \Carbon\Carbon::parse($appointment->appointment_date)->format('D, M d, Y') }}
                                    </p>
                                </div>
                                <div>
                                    <p class="text-xs text-gray-500 mb-0.5">Time</p>
                                    <p class="text-sm font-medium text-gray-900">
                                        {{ \Carbon\Carbon::parse($appointment->start_time)->format('h:i A') }} - {{ \Carbon\Carbon::parse($appointment->end_time)->format('h:i A') }}
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Right Column --}}
                    <div class="flex flex-col gap-3">
                        {{-- Service Information --}}
                        <div class="bg-gray-50 rounded-lg p-3">
                            <h3 class="text-xs font-semibold text-gray-900 mb-2 flex items-center gap-1.5">
                                <svg class="w-4 h-4 text-blue-600" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                                </svg>
                                Service Details
                            </h3>
                            <div class="space-y-2">
                                <div>
                                    <p class="text-xs text-gray-500 mb-0.5">Service Name</p>
                                    <p class="text-sm font-medium text-gray-900">{{ $appointment->service->name }}</p>
                                </div>
                                <div>
                                    <p class="text-xs text-gray-500 mb-0.5">Category</p>
                                    @php
                                        $categoryColors = [
                                            'Maintenance' => 'bg-green-100 text-green-800',
                                            'Repair' => 'bg-blue-100 text-blue-800',
                                            'Inspection' => 'bg-yellow-100 text-yellow-800',
                                            'Detailing' => 'bg-purple-100 text-purple-800',
                                            'Diagnostic' => 'bg-pink-100 text-pink-800',
                                        ];
                                        $colorClass = $categoryColors[$appointment->service->category] ?? 'bg-gray-100 text-gray-800';
                                    @endphp
                                    <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium {{ $colorClass }}">
                                        {{ $appointment->service->category }}
                                    </span>
                                </div>
                                <div>
                                    <p class="text-xs text-gray-500 mb-0.5">Description</p>
                                    <p class="text-xs text-gray-700">{{ $appointment->service->description ?? 'No description available' }}</p>
                                </div>
                            </div>
                        </div>

                        {{-- Employee Information --}}
                        <div class="bg-gray-50 rounded-lg p-3 flex-1">
                            <h3 class="text-xs font-semibold text-gray-900 mb-2 flex items-center gap-1.5">
                                <svg class="w-4 h-4 text-purple-600" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M16 11c1.66 0 2.99-1.34 2.99-3S17.66 5 16 5s-3 1.34-3 3 1.34 3 3 3zm-8 0c1.66 0 2.99-1.34 2.99-3S9.66 5 8 5 5 6.34 5 8s1.34 3 3 3zm0 2c-2.33 0-7 1.17-7 3.5V19h14v-2.5c0-2.33-4.67-3.5-7-3.5zm8 0c-.29 0-.62.02-.97.05 1.16.84 1.97 1.97 1.97 3.45V19h6v-2.5c0-2.33-4.67-3.5-7-3.5z"/>
                                </svg>
                                Assigned Employee
                            </h3>
                            @if($appointment->employee)
                                <div class="flex items-center gap-2">
                                    @php
                                        $empNameParts = explode(' ', $appointment->employee->name);
                                        $empFirstName = $empNameParts[0] ?? '';
                                        $empLastName = end($empNameParts) ?? '';
                                        $empInitials = strtoupper(substr($empFirstName, 0, 1) . substr($empLastName, 0, 1));
                                    @endphp
                                    <div class="w-8 h-8 bg-gradient-to-br from-green-400 to-green-600 rounded-full flex items-center justify-center flex-shrink-0">
                                        <span class="text-white font-semibold text-xs">{{ $empInitials }}</span>
                                    </div>
                                    <div class="min-w-0">
                                        <p class="text-sm font-medium text-gray-900 truncate">{{ $appointment->employee->name }}</p>
                                        <p class="text-xs text-gray-600 truncate">{{ $appointment->employee->email }}</p>
                                    </div>
                                </div>
                            @else
                                <p class="text-xs text-gray-500 italic">No employee assigned yet</p>
                            @endif
                        </div>
                    </div>
                </div>

                {{-- Notes (if rejected) --}}
                @if($appointment->notes)
                    <div class="bg-red-50 border border-red-200 rounded-lg p-4">
                        <h3 class="text-sm font-semibold text-red-900 mb-2">Rejection Notes</h3>
                        <p class="text-sm text-red-700">{{ $appointment->notes }}</p>
                    </div>
                @endif

                {{-- Timestamps & Close Button --}}
                <div class="flex items-center justify-between pt-3 border-t border-gray-200">
                    <div class="flex gap-4 text-xs text-gray-500">
                        <span><span class="font-medium">Created:</span> {{ $appointment->created_at->format('M d, Y h:i A') }}</span>
                        <span><span class="font-medium">Updated:</span> {{ $appointment->updated_at->format('M d, Y h:i A') }}</span>
                    </div>
                    <button type="button" wire:click="closeModal"
                        class="px-4 py-1.5 text-xs font-medium text-white bg-indigo-600 hover:bg-indigo-700 rounded-lg transition-colors">
                        Close
                    </button>
                </div>
            </div>
        @endif
    </x-modal>
</div>
