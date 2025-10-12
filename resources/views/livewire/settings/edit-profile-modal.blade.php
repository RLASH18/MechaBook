<div>
    <x-modal :show="$showModal" title="Edit Profile" maxWidth="lg">
        <form wire:submit.prevent="updateProfile" class="space-y-4">
            {{-- Name Field --}}
            <div>
                <x-form.label for="name">Full Name <span class="text-red-500">*</span></x-form.label>
                <x-form.input type="text" name="name" wire:model="name" placeholder="Enter your full name" />
                <x-form.error name="name" />
            </div>

            {{-- Email Field --}}
            <div>
                <x-form.label for="email">Email Address <span class="text-red-500">*</span></x-form.label>
                <x-form.input type="email" name="email" wire:model="email" placeholder="Enter your email" />
                <x-form.error name="email" />
            </div>

            {{-- Phone Field --}}
            <div>
                <x-form.label for="phone">Phone Number</x-form.label>
                <x-form.input type="text" name="phone" wire:model="phone" placeholder="Enter your phone number" />
                <x-form.error name="phone" />
            </div>

            {{-- Action Buttons --}}
            <div class="flex gap-3 pt-4">
                <button type="button" wire:click="closeModal"
                    class="flex-1 px-4 py-2 text-sm font-medium text-gray-700 bg-gray-100 hover:bg-gray-200 rounded-lg transition-colors">
                    Cancel
                </button>
                <button type="submit"
                    class="flex-1 px-4 py-2 text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 rounded-lg transition-colors">
                    Save Changes
                </button>
            </div>
        </form>
    </x-modal>
</div>
