<div>
    <x-modal :show="$showModal" title="Change Password" maxWidth="lg">
        <form wire:submit.prevent="updatePassword" class="space-y-4">
            {{-- Current Password --}}
            <div>
                <x-form.label for="current_password">Current Password <span class="text-red-500">*</span></x-form.label>
                <x-form.input type="password" name="current_password" wire:model="current_password" placeholder="Enter current password" />
                <x-form.error name="current_password" />
            </div>

            {{-- New Password --}}
            <div>
                <x-form.label for="new_password">New Password <span class="text-red-500">*</span></x-form.label>
                <x-form.input type="password" name="new_password" wire:model="new_password" placeholder="Enter new password (min. 8 characters)" />
                <x-form.error name="new_password" />
            </div>

            {{-- Confirm New Password --}}
            <div>
                <x-form.label for="new_password_confirmation">Confirm New Password <span class="text-red-500">*</span></x-form.label>
                <x-form.input type="password" name="new_password_confirmation" wire:model="new_password_confirmation" placeholder="Confirm new password" />
            </div>

            {{-- Action Buttons --}}
            <div class="flex gap-3 pt-4">
                <button type="button" wire:click="closeModal"
                    class="flex-1 px-4 py-2 text-sm font-medium text-gray-700 bg-gray-100 hover:bg-gray-200 rounded-lg transition-colors">
                    Cancel
                </button>
                <button type="submit"
                    class="flex-1 px-4 py-2 text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 rounded-lg transition-colors">
                    Update Password
                </button>
            </div>
        </form>
    </x-modal>
</div>
