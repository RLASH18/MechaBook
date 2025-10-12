<div>
    <x-modal :show="$showModal" title="Delete Account" maxWidth="lg">
        <form wire:submit.prevent="deleteAccount" class="space-y-4">
            {{-- Warning Message --}}
            <div class="bg-red-50 border border-red-200 rounded-lg p-4">
                <div class="flex items-start">
                    <svg class="w-5 h-5 text-red-600 mt-0.5 mr-3 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd"
                            d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z"
                            clip-rule="evenodd" />
                    </svg>
                    <div>
                        <h4 class="text-sm font-semibold text-red-800 mb-1">Warning: This action cannot be undone</h4>
                        <p class="text-sm text-red-700">
                            Deleting your account will permanently remove all your data, including your profile,
                            settings, and history. This action is irreversible.
                        </p>
                    </div>
                </div>
            </div>

            {{-- Password Confirmation --}}
            <div>
                <x-form.label for="password">Confirm Your Password <span class="text-red-500">*</span></x-form.label>
                <x-form.input type="password" name="password" wire:model="password"
                    placeholder="Enter your password to confirm" />
                <x-form.error name="password" />
                <p class="mt-1 text-xs text-gray-500">Please enter your password to confirm account deletion.</p>
            </div>

            {{-- Action Buttons --}}
            <div class="flex gap-3 pt-4">
                <button type="button" wire:click="closeModal"
                    class="flex-1 px-4 py-2 text-sm font-medium text-gray-700 bg-gray-100 hover:bg-gray-200 rounded-lg transition-colors">
                    Cancel
                </button>
                <button type="submit"
                    class="flex-1 px-4 py-2 text-sm font-medium text-white bg-red-600 hover:bg-red-700 rounded-lg transition-colors">
                    Delete Account
                </button>
            </div>
        </form>
    </x-modal>
</div>
