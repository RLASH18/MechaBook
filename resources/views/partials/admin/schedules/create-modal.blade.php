<x-modal :show="$showCreateModal" title="Add New Schedule">
    <form wire:submit.prevent="createSchedule" class="space-y-4">
        {{-- Day of Week --}}
        <div>
            <x-form.label for="day_of_week">Day of Week</x-form.label>
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
            <x-form.label for="start_time">Start Time</x-form.label>
            <x-form.input type="time" name="start_time" wire:model="start_time" />
            <x-form.error name="start_time" />
        </div>

        {{-- End Time --}}
        <div>
            <x-form.label for="end_time">End Time</x-form.label>
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
