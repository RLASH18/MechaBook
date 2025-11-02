<div>
    {{-- Approve Modal --}}
    @if ($request)
        <x-modal :show="$showApproveModal" maxWidth="lg" title="Approve Schedule Change Request">
            <form wire:submit.prevent="approveRequest" class="space-y-4">
                {{-- Request Summary --}}
                <div class="p-4 bg-green-50 rounded-lg border border-green-200">
                    <h4 class="font-semibold text-green-900 mb-2">Request Details</h4>
                    <div class="space-y-2 text-sm">
                        <div>
                            <span class="font-medium text-green-800">Employee:</span>
                            <span class="text-green-700">{{ $request->employee->name }}</span>
                        </div>
                        <div>
                            <span class="font-medium text-green-800">Type:</span>
                            <span class="text-green-700">
                                @if ($request->request_type === 'time_change')
                                    Time Change
                                @elseif($request->request_type === 'day_change')
                                    Day Change
                                @else
                                    Day Off
                                @endif
                            </span>
                        </div>
                        <div>
                            <span class="font-medium text-green-800">Current:</span>
                            <span class="text-green-700">
                                {{ $request->current_day_of_week }}
                                @if ($request->current_start_time)
                                    ({{ date('g:i A', strtotime($request->current_start_time)) }} -
                                    {{ date('g:i A', strtotime($request->current_end_time)) }})
                                @endif
                            </span>
                        </div>
                        <div>
                            <span class="font-medium text-green-800">Requested:</span>
                            <span class="text-green-700 font-semibold">
                                @if ($request->request_type === 'time_change')
                                    {{ $request->current_day_of_week }}
                                    ({{ date('g:i A', strtotime($request->requested_start_time)) }} -
                                    {{ date('g:i A', strtotime($request->requested_end_time)) }})
                                @elseif($request->request_type === 'day_change')
                                    {{ $request->requested_day_of_week }} (Same time)
                                @else
                                    Day Off
                                @endif
                            </span>
                        </div>
                    </div>
                </div>

                {{-- Admin Notes (Optional) --}}
                <div>
                    <x-form.label for="adminNotes">Admin Notes (Optional)</x-form.label>
                    <x-form.textarea name="adminNotes" wire:model="adminNotes" rows="3"
                        placeholder="Add any notes about this approval..."></x-form.textarea>
                    <x-form.error name="adminNotes" />
                </div>

                {{-- Warning --}}
                <div class="p-3 bg-yellow-50 border border-yellow-200 rounded-lg">
                    <p class="text-sm text-yellow-800">
                        <strong>Note:</strong> Approving this request will automatically update the employee's schedule.
                    </p>
                </div>

                {{-- Action Buttons --}}
                <div class="flex gap-3">
                    <button type="button" wire:click="closeModal"
                        class="flex-1 px-4 py-2 text-sm font-medium text-gray-700 bg-gray-100 hover:bg-gray-200 rounded-lg transition-colors">
                        Cancel
                    </button>
                    <button type="submit"
                        class="flex-1 px-4 py-2 text-sm font-medium text-white bg-green-600 hover:bg-green-700 rounded-lg transition-colors">
                        Approve Request
                    </button>
                </div>
            </form>
        </x-modal>

        {{-- Reject Modal --}}
        <x-modal :show="$showRejectModal" maxWidth="lg" title="Reject Schedule Change Request">
            <form wire:submit.prevent="rejectRequest" class="space-y-4">
                {{-- Request Summary --}}
                <div class="p-4 bg-red-50 rounded-lg border border-red-200">
                    <h4 class="font-semibold text-red-900 mb-2">Request Details</h4>
                    <div class="space-y-2 text-sm">
                        <div>
                            <span class="font-medium text-red-800">Employee:</span>
                            <span class="text-red-700">{{ $request->employee->name }}</span>
                        </div>
                        <div>
                            <span class="font-medium text-red-800">Reason:</span>
                            <p class="text-red-700 mt-1">{{ $request->reason }}</p>
                        </div>
                    </div>
                </div>

                {{-- Admin Notes (Required for rejection) --}}
                <div>
                    <x-form.label for="adminNotes">Reason for Rejection <span
                            class="text-red-500">*</span></x-form.label>
                    <x-form.textarea name="adminNotes" wire:model="adminNotes" rows="3"
                        placeholder="Please explain why this request is being rejected (minimum 10 characters)..."></x-form.textarea>
                    <x-form.error name="adminNotes" />
                    <p class="mt-1 text-xs text-gray-500">{{ strlen($adminNotes) }}/500 characters</p>
                </div>

                {{-- Action Buttons --}}
                <div class="flex gap-3">
                    <button type="button" wire:click="closeModal"
                        class="flex-1 px-4 py-2 text-sm font-medium text-gray-700 bg-gray-100 hover:bg-gray-200 rounded-lg transition-colors">
                        Cancel
                    </button>
                    <button type="submit"
                        class="flex-1 px-4 py-2 text-sm font-medium text-white bg-red-600 hover:bg-red-700 rounded-lg transition-colors">
                        Reject Request
                    </button>
                </div>
            </form>
        </x-modal>
    @endif
</div>
