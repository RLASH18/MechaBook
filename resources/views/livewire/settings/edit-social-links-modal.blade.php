<div>
    <x-modal :show="$showModal" title="Update Social Links" maxWidth="3xl">
        <form wire:submit.prevent="updateSocialLinks" class="space-y-4">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                {{-- Facebook --}}
                <div>
                    <x-form.label for="facebook">
                        <i class="fab fa-facebook-f mr-2 text-blue-600"></i>Facebook
                    </x-form.label>
                    <x-form.input type="url" name="facebook" wire:model="facebook" placeholder="https://facebook.com/yourprofile" />
                    <x-form.error name="facebook" />
                </div>

                {{-- Twitter --}}
                <div>
                    <x-form.label for="twitter">
                        <i class="fab fa-twitter mr-2 text-blue-400"></i>Twitter
                    </x-form.label>
                    <x-form.input type="url" name="twitter" wire:model="twitter" placeholder="https://twitter.com/yourusername" />
                    <x-form.error name="twitter" />
                </div>

                {{-- LinkedIn --}}
                <div>
                    <x-form.label for="linkedin">
                        <i class="fab fa-linkedin-in mr-2 text-blue-700"></i>LinkedIn
                    </x-form.label>
                    <x-form.input type="url" name="linkedin" wire:model="linkedin" placeholder="https://linkedin.com/in/yourprofile" />
                    <x-form.error name="linkedin" />
                </div>

                {{-- Instagram --}}
                <div>
                    <x-form.label for="instagram">
                        <i class="fab fa-instagram mr-2 text-pink-600"></i>Instagram
                    </x-form.label>
                    <x-form.input type="url" name="instagram" wire:model="instagram" placeholder="https://instagram.com/yourusername" />
                    <x-form.error name="instagram" />
                </div>

                {{-- YouTube --}}
                <div>
                    <x-form.label for="youtube">
                        <i class="fab fa-youtube mr-2 text-red-600"></i>YouTube
                    </x-form.label>
                    <x-form.input type="url" name="youtube" wire:model="youtube" placeholder="https://youtube.com/c/yourchannel" />
                    <x-form.error name="youtube" />
                </div>

                {{-- GitHub --}}
                <div>
                    <x-form.label for="github">
                        <i class="fab fa-github mr-2 text-gray-800"></i>GitHub
                    </x-form.label>
                    <x-form.input type="url" name="github" wire:model="github" placeholder="https://github.com/yourusername" />
                    <x-form.error name="github" />
                </div>

                {{-- Website --}}
                <div>
                    <x-form.label for="website">
                        <i class="fas fa-globe mr-2 text-green-600"></i>Website
                    </x-form.label>
                    <x-form.input type="url" name="website" wire:model="website" placeholder="https://yourwebsite.com" />
                    <x-form.error name="website" />
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
                    Save Changes
                </button>
            </div>
        </form>
    </x-modal>
</div>
