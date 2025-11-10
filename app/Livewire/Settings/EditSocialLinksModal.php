<?php

namespace App\Livewire\Settings;

use App\Http\Requests\settings\UpdateSocialLinksRequest;
use App\Services\SettingsService;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class EditSocialLinksModal extends Component
{
    // Modal state
    public $showModal = false;

    // Form fields for each platform
    public $facebook = '';
    public $twitter = '';
    public $linkedin = '';
    public $instagram = '';
    public $youtube = '';
    public $github = '';
    public $website = '';

    // Listen for edit social links event
    protected $listeners = ['openEditSocialLinksModal'];

    protected $settingsService;

    /**
     * Inject the settings service for handling business logic
     */
    public function boot(SettingsService $settingsService)
    {
        $this->settingsService = $settingsService;
    }

    /**
     * Open the modal and populate with current user social links.
     */
    public function openEditSocialLinksModal()
    {
        $user = Auth::user();
        $socialLinks = $user->socialLinks()->get()->keyBy('platform');

        // Populate form fields with existing data
        $this->facebook = $socialLinks->get('facebook')?->url ?? '';
        $this->twitter = $socialLinks->get('twitter')?->url ?? '';
        $this->linkedin = $socialLinks->get('linkedin')?->url ?? '';
        $this->instagram = $socialLinks->get('instagram')?->url ?? '';
        $this->youtube = $socialLinks->get('youtube')?->url ?? '';
        $this->github = $socialLinks->get('github')?->url ?? '';
        $this->website = $socialLinks->get('website')?->url ?? '';

        $this->showModal = true;
    }

    /**
     * Close the modal and reset form.
     */
    public function closeModal()
    {
        $this->showModal = false;
        $this->resetForm();
    }

    /**
     * Reset form fields and clear validation errors.
     */
    public function resetForm()
    {
        $this->reset(['facebook', 'twitter', 'linkedin', 'instagram', 'youtube', 'github', 'website']);
        $this->resetValidation();
    }

    /**
     * Update user social links.
     */
    public function updateSocialLinks()
    {
        $request = new UpdateSocialLinksRequest();
        $validated = $this->validate($request->rules(), $request->messages());

        $result = $this->settingsService->updateUserSocialLinks(Auth::id(), $validated);

        if ($result) {
            notyf()->success('Social links updated successfully!');
            $this->closeModal();
        } else {
            notyf()->error('Failed to update social links');
        }
    }

    public function render()
    {
        return view('livewire.settings.edit-social-links-modal');
    }
}
