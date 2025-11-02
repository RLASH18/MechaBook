<div>
    {{-- Create Modal Schedule --}}
    <x-modal :show="$showCreateModal" title="Add New Schedule">
        <form wire:submit.prevent="createSchedule" class="space-y-4">
            {{-- Day of Week --}}
            <div>
                <x-form.label for="day_of_week">Day of Week <span class="text-red-500">*</x-form.label>
                <x-form.select name="day_of_week" wire:model="day_of_week">
                    <option value="">Select Day</option>
                    @foreach ($daysOfWeek as $day)
                        <option value="{{ $day }}">{{ $day }}</option>
                    @endforeach
                </x-form.select>
                <x-form.error name="day_of_week" />
            </div>

            {{-- Start Time --}}
            <div>
                <x-form.label for="start_time">Start Time <span class="text-red-500">*</x-form.label>
                <x-form.input type="time" name="start_time" wire:model="start_time" />
                <x-form.error name="start_time" />
            </div>

            {{-- End Time --}}
            <div>
                <x-form.label for="end_time">End Time <span class="text-red-500">*</x-form.label>
                <x-form.input type="time" name="end_time" wire:model="end_time" />
                <x-form.error name="end_time" />
            </div>

            {{-- Action Buttons --}}
            <div class="flex gap-3 pt-4">
                <button type="button" wire:click="closeModal"
                    class="flex-1 px-4 py-2 text-sm font-medium text-gray-700 bg-gray-100 hover:bg-gray-200 rounded-lg transition-colors">
                    Cancel
                </button>
                <button type="submit"
                    class="flex-1 px-4 py-2 text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 rounded-lg transition-colors">
                    Create Schedule
                </button>
            </div>
        </form>
    </x-modal>

    {{-- Edit Modal Schedule --}}
    <x-modal :show="$showEditModal" title="Edit Schedule">
        <form wire:submit.prevent="updateSchedule" class="space-y-4">
            {{-- Day of Week --}}
            <div>
                <x-form.label for="day_of_week">Day of Week <span class="text-red-500">*</x-form.label>
                <x-form.select name="day_of_week" wire:model="day_of_week">
                    <option value="">Select Day</option>
                    @foreach ($daysOfWeek as $day)
                        <option value="{{ $day }}">{{ $day }}</option>
                    @endforeach
                </x-form.select>
                <x-form.error name="day_of_week" />
            </div>

            {{-- Start Time --}}
            <div>
                <x-form.label for="start_time">Start Time <span class="text-red-500">*</x-form.label>
                <x-form.input type="time" name="start_time" wire:model="start_time" />
                <x-form.error name="start_time" />
            </div>

            {{-- End Time --}}
            <div>
                <x-form.label for="end_time">End Time <span class="text-red-500">*</x-form.label>
                <x-form.input type="time" name="end_time" wire:model="end_time" />
                <x-form.error name="end_time" />
            </div>

            {{-- Action Buttons --}}
            <div class="flex gap-3 pt-4">
                <button type="button" wire:click="closeModal"
                    class="flex-1 px-4 py-2 text-sm font-medium text-gray-700 bg-gray-100 hover:bg-gray-200 rounded-lg transition-colors">
                    Cancel
                </button>
                <button type="submit"
                    class="flex-1 px-4 py-2 text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 rounded-lg transition-colors">
                    Update Schedule
                </button>
            </div>
        </form>
    </x-modal>

    {{-- Delete Modal Schedule --}}
    <x-modal :show="$showDeleteModal" title="Delete Schedule" maxWidth="md">
        <div class="space-y-6">
            {{-- Warning Message --}}
            <div class="flex items-start gap-3">
                <div class="flex-shrink-0">
                    <svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                    </svg>
                </div>
                <div>
                    <h4 class="text-sm font-medium text-gray-900 mb-1">Are you sure?</h4>
                    <p class="text-sm text-gray-600">
                        This will permanently delete this schedule. This action cannot be undone.
                    </p>
                </div>
            </div>

            {{-- Action Buttons --}}
            <div class="flex gap-3">
                <button type="button" wire:click="closeModal"
                    class="flex-1 px-4 py-2 text-sm font-medium text-gray-700 bg-gray-100 hover:bg-gray-200 rounded-lg transition-colors">
                    Cancel
                </button>
                <button wire:click="deleteSchedule"
                    class="flex-1 px-4 py-2 text-sm font-medium text-white bg-red-600 hover:bg-red-700 rounded-lg transition-colors">
                    Delete Schedule
                </button>
            </div>
        </div>
    </x-modal>
</div>
