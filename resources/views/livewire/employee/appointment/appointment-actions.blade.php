<div>
    {{-- Start Appointment Modal --}}
    <x-modal :show="$showStartModal" title="Start Appointment">
        @if ($appointment)
            <form wire:submit.prevent="startAppointment" class="space-y-4">
                {{-- Appointment Details --}}
                <div class="p-4 bg-blue-50 rounded-lg">
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

                {{-- Proof Image Upload --}}
                <div>
                    <x-form.label for="proofImage" class="mb-3 flex items-center gap-2">
                        <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>
                        Upload Proof Image <span class="text-red-500">*
                    </x-form.label>

                    @if (!$proofImage)
                        {{-- Drag and Drop Area --}}
                        <label for="proofImageInput"
                            class="flex flex-col items-center justify-center w-full h-48 border-2 border-blue-300 border-dashed rounded-xl cursor-pointer bg-gradient-to-br from-blue-50 to-indigo-50 hover:from-blue-100 hover:to-indigo-100 transition-all duration-200 group">
                            <div class="flex flex-col items-center justify-center pt-5 pb-6">
                                <svg class="w-12 h-12 mb-3 text-blue-500 group-hover:text-blue-600 transition-colors"
                                    fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12" />
                                </svg>
                                <p class="mb-2 text-sm text-gray-700 font-medium">
                                    <span class="text-blue-600 font-semibold">Click to upload</span> or drag and drop
                                </p>
                                <p class="text-xs text-gray-500">PNG, JPG, JPEG (MAX. 2MB)</p>
                                <div class="mt-3 flex items-center gap-2 text-xs text-blue-600">
                                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd"
                                            d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z"
                                            clip-rule="evenodd" />
                                    </svg>
                                    <span>Take a photo to prove you're starting the work</span>
                                </div>
                            </div>
                            <input id="proofImageInput" type="file" wire:model="proofImage" accept="image/*"
                                class="hidden" />
                        </label>
                    @else
                        {{-- Image Preview with Actions --}}
                        <div class="relative group">
                            <div class="relative overflow-hidden rounded-xl border-2 border-blue-200 shadow-lg">
                                <img src="{{ $proofImage->temporaryUrl() }}" class="w-full h-64 object-cover">
                                <div
                                    class="absolute inset-0 bg-gradient-to-t from-black/60 via-transparent to-transparent">
                                </div>
                                <div class="absolute bottom-0 left-0 right-0 p-4">
                                    <div class="flex items-center justify-between">
                                        <div class="flex items-center gap-2 text-white">
                                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd"
                                                    d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                                    clip-rule="evenodd" />
                                            </svg>
                                            <span class="text-sm font-medium">Image Ready</span>
                                        </div>
                                        <button type="button" wire:click="$set('proofImage', null)"
                                            class="flex items-center gap-1 px-3 py-1.5 text-xs font-medium text-white bg-red-500 hover:bg-red-600 rounded-lg transition-colors">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                            </svg>
                                            Remove
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif

                    <x-form.error name="proofImage" class="mt-2" />
                </div>

                {{-- Action Buttons --}}
                <div class="flex gap-3 pt-4">
                    <button type="button" wire:click="closeModal"
                        class="flex-1 px-4 py-2 text-sm font-medium text-gray-700 bg-gray-100 hover:bg-gray-200 rounded-lg transition-colors">
                        Cancel
                    </button>
                    <button type="submit"
                        class="flex-1 px-4 py-2 text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 rounded-lg transition-colors">
                        Start Appointment
                    </button>
                </div>
            </form>
        @endif
    </x-modal>

    {{-- Complete Appointment Modal --}}
    <x-modal :show="$showCompleteModal" title="Complete Appointment">
        @if ($appointment)
            <form wire:submit.prevent="completeAppointment" class="space-y-4">
                {{-- Appointment Details --}}
                <div class="p-4 bg-green-50 rounded-lg">
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

                {{-- Proof Image Upload --}}
                <div>
                    <x-form.label for="proofImageComplete" class="mb-3 flex items-center gap-2">
                        <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        Upload Completion Proof <span class="text-red-500">*
                    </x-form.label>

                    @if (!$proofImage)
                        {{-- Drag and Drop Area --}}
                        <label for="proofImageCompleteInput"
                            class="flex flex-col items-center justify-center w-full h-48 border-2 border-green-300 border-dashed rounded-xl cursor-pointer bg-gradient-to-br from-green-50 to-emerald-50 hover:from-green-100 hover:to-emerald-100 transition-all duration-200 group">
                            <div class="flex flex-col items-center justify-center pt-5 pb-6">
                                <svg class="w-12 h-12 mb-3 text-green-500 group-hover:text-green-600 transition-colors"
                                    fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12" />
                                </svg>
                                <p class="mb-2 text-sm text-gray-700 font-medium">
                                    <span class="text-green-600 font-semibold">Click to upload</span> or drag and drop
                                </p>
                                <p class="text-xs text-gray-500">PNG, JPG, JPEG (MAX. 2MB)</p>
                                <div class="mt-3 flex items-center gap-2 text-xs text-green-600">
                                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd"
                                            d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z"
                                            clip-rule="evenodd" />
                                    </svg>
                                    <span>Take a photo of the completed work</span>
                                </div>
                            </div>
                            <input id="proofImageCompleteInput" type="file" wire:model="proofImage"
                                accept="image/*" class="hidden" />
                        </label>
                    @else
                        {{-- Image Preview with Actions --}}
                        <div class="relative group">
                            <div class="relative overflow-hidden rounded-xl border-2 border-green-200 shadow-lg">
                                <img src="{{ $proofImage->temporaryUrl() }}" class="w-full h-64 object-cover">
                                <div
                                    class="absolute inset-0 bg-gradient-to-t from-black/60 via-transparent to-transparent">
                                </div>
                                <div class="absolute bottom-0 left-0 right-0 p-4">
                                    <div class="flex items-center justify-between">
                                        <div class="flex items-center gap-2 text-white">
                                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd"
                                                    d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                                    clip-rule="evenodd" />
                                            </svg>
                                            <span class="text-sm font-medium">Image Ready</span>
                                        </div>
                                        <button type="button" wire:click="$set('proofImage', null)"
                                            class="flex items-center gap-1 px-3 py-1.5 text-xs font-medium text-white bg-red-500 hover:bg-red-600 rounded-lg transition-colors">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                            </svg>
                                            Remove
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif

                    <x-form.error name="proofImage" class="mt-2" />
                </div>

                {{-- Action Buttons --}}
                <div class="flex gap-3 pt-4">
                    <button type="button" wire:click="closeModal"
                        class="flex-1 px-4 py-2 text-sm font-medium text-gray-700 bg-gray-100 hover:bg-gray-200 rounded-lg transition-colors">
                        Cancel
                    </button>
                    <button type="submit"
                        class="flex-1 px-4 py-2 text-sm font-medium text-white bg-green-600 hover:bg-green-700 rounded-lg transition-colors">
                        Complete Appointment
                    </button>
                </div>
            </form>
        @endif
    </x-modal>
</div>
