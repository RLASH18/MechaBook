<div>
    {{-- Service Details Modal --}}
    <x-modal :show="$showDetailsModal" title="Service Details">
        @if ($service)
            <div class="space-y-4">
                {{-- Service Image --}}
                @if ($service->service_img)
                    <div class="relative h-64 rounded-xl overflow-hidden">
                        <img src="{{ asset('storage/' . $service->service_img) }}" alt="{{ $service->name }}"
                            class="w-full h-full object-cover">
                    </div>
                @endif

                {{-- Service Information --}}
                <div class="space-y-3">
                    <div>
                        <p class="text-xs text-gray-500 font-mono mb-1">Service ID</p>
                        <p class="font-medium text-gray-800">SRV-{{ str_pad($service->id, 4, '0', STR_PAD_LEFT) }}</p>
                    </div>

                    <div>
                        <p class="text-xs text-gray-500 mb-1">Service Name</p>
                        <p class="font-bold text-gray-900 text-lg">{{ $service->name }}</p>
                    </div>

                    <div>
                        <p class="text-xs text-gray-500 mb-1">Category</p>
                        <span
                            class="inline-block px-3 py-1 rounded-full text-xs font-semibold bg-blue-100 text-blue-700">
                            {{ $service->category }}
                        </span>
                    </div>

                    <div>
                        <p class="text-xs text-gray-500 mb-1">Description</p>
                        <p class="text-sm text-gray-700">
                            {{ $service->description ?? 'No description available' }}
                        </p>
                    </div>

                    <div class="grid grid-cols-2 gap-4 pt-3 border-t">
                        <div>
                            <p class="text-xs text-gray-500 mb-1">Duration</p>
                            <div class="flex items-center text-gray-800">
                                <svg class="w-5 h-5 mr-1.5 text-blue-600" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                <span class="font-medium">{{ $service->duration_minutes }} minutes</span>
                            </div>
                        </div>
                        <div>
                            <p class="text-xs text-gray-500 mb-1">Price</p>
                            <p class="text-2xl font-bold text-green-600">₱{{ number_format($service->price, 2) }}</p>
                        </div>
                    </div>
                </div>

                {{-- Close Button --}}
                <div class="flex gap-3 pt-4">
                    <button type="button" wire:click="closeModal"
                        class="flex-1 px-4 py-2 text-sm font-medium text-gray-700 bg-gray-100 hover:bg-gray-200 rounded-lg transition-colors">
                        Close
                    </button>
                </div>
            </div>
        @endif
    </x-modal>

    {{-- Book Appointment Modal --}}
    <x-modal :show="$showBookModal" title="Book Appointment" maxWidth="2xl">
        @if ($service)
            <form wire:submit.prevent="createAppointment" class="space-y-4">
                {{-- Service Summary --}}
                <div class="p-4 bg-blue-50 rounded-lg">
                    <div class="flex items-start gap-3">
                        @if ($service->service_img)
                            <img src="{{ asset('storage/' . $service->service_img) }}" alt="{{ $service->name }}"
                                class="w-16 h-16 rounded-lg object-cover">
                        @endif
                        <div class="flex-1">
                            <p class="font-bold text-gray-900">{{ $service->name }}</p>
                            <p class="text-sm text-gray-600">{{ $service->category }}</p>
                            <div class="flex items-center gap-4 mt-2">
                                <span class="text-xs text-gray-600">
                                    <svg class="w-4 h-4 inline mr-1" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                    {{ $service->duration_minutes }} min
                                </span>
                                <span class="text-sm font-bold text-green-600">
                                    ₱{{ number_format($service->price, 2) }}
                                </span>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Appointment Date --}}
                <div>
                    <x-form.label for="appointment_date" class="mb-2">
                        Appointment Date <span class="text-red-500">*</span>
                    </x-form.label>
                    <x-form.input type="date" name="appointment_date" wire:model="appointment_date"
                        min="{{ date('Y-m-d') }}" />
                    <x-form.error name="appointment_date" class="mt-1" />
                </div>

                {{-- Time Range --}}
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <x-form.label for="start_time" class="mb-2">
                            Start Time <span class="text-red-500">*</span>
                        </x-form.label>
                        <x-form.input type="time" name="start_time" wire:model="start_time" />
                        <x-form.error name="start_time" class="mt-1" />
                    </div>
                    <div>
                        <x-form.label for="end_time" class="mb-2">
                            End Time <span class="text-red-500">*</span>
                        </x-form.label>
                        <x-form.input type="time" name="end_time" wire:model="end_time" />
                        <x-form.error name="end_time" class="mt-1" />
                    </div>
                </div>

                {{-- Notes --}}
                <div>
                    <x-form.label for="notes" class="mb-2">
                        Additional Notes (Optional)
                    </x-form.label>
                    <x-form.textarea name="notes" wire:model="notes" rows="3" placeholder="Any special requests or information..." />
                    <x-form.error name="notes" class="mt-1" />
                    <p class="text-xs text-gray-500 mt-1">Maximum 500 characters</p>
                </div>

                {{-- Info Box --}}
                <div class="p-3 bg-yellow-50 border border-yellow-200 rounded-lg">
                    <div class="flex items-start gap-2">
                        <svg class="w-5 h-5 text-yellow-600 flex-shrink-0 mt-0.5" fill="currentColor"
                            viewBox="0 0 20 20">
                            <path fill-rule="evenodd"
                                d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z"
                                clip-rule="evenodd" />
                        </svg>
                        <p class="text-xs text-yellow-800">
                            Your appointment will be pending until approved by an admin. You will be notified once it's
                            confirmed.
                        </p>
                    </div>
                </div>

                {{-- Action Buttons --}}
                <div class="flex gap-3 pt-4">
                    <button type="button" wire:click="closeModal"
                        class="flex-1 px-4 py-2 text-sm font-medium text-gray-700 bg-gray-100 hover:bg-gray-200 rounded-lg transition-colors">
                        Cancel
                    </button>
                    <button type="submit"
                        class="flex-1 px-4 py-2 text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 rounded-lg transition-colors">
                        Book Appointment
                    </button>
                </div>
            </form>
        @endif
    </x-modal>
</div>
