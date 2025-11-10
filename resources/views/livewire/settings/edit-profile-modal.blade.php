<div>
    <x-modal :show="$showModal" title="Edit Profile" maxWidth="lg">
        <form wire:submit.prevent="updateProfile" class="space-y-4">
            {{-- Profile Image Field --}}
            <div>
                <x-form.label for="profileImage">Profile Image</x-form.label>
                <div class="flex flex-col items-center space-y-2">
                    {{-- Clickable Circle with Image Preview --}}
                    <div class="relative">
                        <label for="profileImageInput" class="cursor-pointer block">
                            @if ($profileImage)
                                <img src="{{ $profileImage->temporaryUrl() }}" alt="Preview"
                                    class="w-24 h-24 rounded-full object-cover border-2 border-blue-500 hover:border-blue-600 transition">
                            @elseif ($currentProfileImage)
                                <img src="{{ asset('storage/' . $currentProfileImage) }}" alt="Current Profile"
                                    class="w-24 h-24 rounded-full object-cover border-2 border-gray-300 hover:border-blue-500 transition">
                            @else
                                <div
                                    class="w-24 h-24 rounded-full bg-gray-100 flex items-center justify-center border-2 border-dashed border-gray-300 hover:border-blue-500 hover:bg-gray-50 transition">
                                    <svg class="w-10 h-10 text-gray-400" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 4v16m8-8H4" />
                                    </svg>
                                </div>
                            @endif
                        </label>

                        {{-- Hidden File Input --}}
                        <input type="file" id="profileImageInput" wire:model="profileImage" accept="image/*" class="hidden">

                        {{-- X Button to Remove Image --}}
                        @if ($profileImage || $currentProfileImage)
                            <button type="button" wire:click="$set('profileImage', null)"
                                class="absolute -top-1 -right-1 w-7 h-7 bg-red-500 hover:bg-red-600 text-white rounded-full flex items-center justify-center shadow-lg transition">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M6 18L18 6M6 6l12 12" />
                                </svg>
                            </button>
                        @endif
                    </div>

                    {{-- Helper Text --}}
                    <p class="text-xs text-gray-500 text-center">PNG, JPG, GIF up to 2MB</p>

                    {{-- Loading Indicator --}}
                    <div wire:loading wire:target="profileImage" class="text-sm text-blue-600">
                        Uploading image...
                    </div>
                </div>
                <div class="text-center">
                    <x-form.error name="profileImage" />
                </div>
            </div>

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
