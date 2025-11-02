<div>
    <x-modal :show="$showModal" maxWidth="lg" title="Request Schedule Change">
        <form wire:submit.prevent="submitRequest" class="space-y-4">
            {{-- Select Day --}}
            <div>
                <x-form.label for="selectedDay">Select Day <span class="text-red-500">*</x-form.label>
                <x-form.select name="selectedDay" wire:model.live="selectedDay">
                    <option value="">Choose a day...</option>
                    @foreach ($schedules as $schedule)
                        <option value="{{ $schedule->day_of_week }}">
                            {{ $schedule->day_of_week }} ({{ date('g:i A', strtotime($schedule->start_time)) }} -
                            {{ date('g:i A', strtotime($schedule->end_time)) }})
                        </option>
                    @endforeach
                </x-form.select>
                <x-form.error name="selectedDay" />
            </div>

            {{-- Current Schedule Display --}}
            @if ($currentSchedule)
                <div class="p-3 bg-gray-50 rounded-lg">
                    <p class="text-xs text-gray-600 mb-1">Current Schedule</p>
                    <p class="text-sm font-medium text-gray-900">
                        {{ $currentSchedule->day_of_week }}:
                        {{ date('g:i A', strtotime($currentSchedule->start_time)) }} -
                        {{ date('g:i A', strtotime($currentSchedule->end_time)) }}
                    </p>
                </div>
            @endif

            {{-- Request Type --}}
            <div>
                <x-form.label>Request Type <span class="text-red-500">*</span></x-form.label>
                <div class="flex space-x-6">
                    <x-form.radio name="requestType" value="time_change" label="Change Time"
                        wire:model.live="requestType" />
                    <x-form.radio name="requestType" value="day_change" label="Change Day"
                        wire:model.live="requestType" />
                    <x-form.radio name="requestType" value="day_off" label="Request Day Off"
                        wire:model.live="requestType" />
                </div>
                <x-form.error name="requestType" />
            </div>

            {{-- Day Change Field --}}
            @if ($requestType === 'day_change')
                <div>
                    <x-form.label for="requestedDay">New Day <span class="text-red-500">*</span></x-form.label>
                    <x-form.select name="requestedDay" wire:model="requestedDay">
                        <option value="">Choose a new day...</option>
                        @foreach (['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'] as $day)
                            <option value="{{ $day }}" {{ $day === $selectedDay ? 'disabled' : '' }}>
                                {{ $day }} {{ $day === $selectedDay ? '(Current)' : '' }}
                            </option>
                        @endforeach
                    </x-form.select>
                    <x-form.error name="requestedDay" />
                </div>
            @endif

            {{-- Time Change Fields --}}
            @if ($requestType === 'time_change')
                <div class="grid grid-cols-2 gap-3">
                    <div>
                        <x-form.label for="requestedStartTime">New Start Time <span
                                class="text-red-500">*</x-form.label>
                        <x-form.input type="time" name="requestedStartTime" wire:model="requestedStartTime" />
                        <x-form.error name="requestedStartTime" />
                    </div>
                    <div>
                        <x-form.label for="requestedEndTime">New End Time <span class="text-red-500">*</x-form.label>
                        <x-form.input type="time" name="requestedEndTime" wire:model="requestedEndTime" />
                        <x-form.error name="requestedEndTime" />
                    </div>
                </div>
            @endif

            {{-- Reason --}}
            <div>
                <x-form.label for="reason">Reason <span class="text-red-500">*</x-form.label>
                <x-form.textarea name="reason" wire:model="reason" rows="3"
                    placeholder="Please provide a reason for this request (minimum 10 characters)..."></x-form.textarea>
                <x-form.error name="reason" />
            </div>

            {{-- Action Buttons --}}
            <div class="flex gap-3 pt-4">
                <button type="button" wire:click="closeModal"
                    class="flex-1 px-4 py-2 text-sm font-medium text-gray-700 bg-gray-100 hover:bg-gray-200 rounded-lg transition-colors">
                    Cancel
                </button>
                <button type="submit"
                    class="flex-1 px-4 py-2 text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 rounded-lg transition-colors">
                    Submit Request
                </button>
            </div>
        </form>
    </x-modal>
</div>
