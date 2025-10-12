<?php

namespace App\Livewire\Settings;

use App\Http\Requests\settings\UpdateProfileRequest;
use App\Services\SettingsService;
use Livewire\Component;

class EditProfileModal extends Component
{
    // Modal state
    public $showModal = false;

    // Form fields
    public $name;
    public $email;
    public $phone;

    // Listen for edit profile event
    protected $listeners = ['openEditProfileModal' => 'openModal'];

    protected $settingsService;

    /**
     * Inject the settings service for handling business logic
     */
    public function boot(SettingsService $settingsService)
    {
        $this->settingsService = $settingsService;
    }

    /**
     * Open the modal and populate with current user data.
     */
    public function openModal()
    {
        $user = auth()->user();
        $this->name = $user->name;
        $this->email = $user->email;
        $this->phone = $user->phone;
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
        $this->reset(['name', 'email', 'phone']);
        $this->resetValidation();
    }

    /**
     * Update user profile and notify success.
     */
    public function updateProfile()
    {
        $request = new UpdateProfileRequest();
        $validated = $this->validate($request->rules(), $request->messages());

        $result = $this->settingsService->updateUserProfile(auth()->id(), $validated);

        if ($result) {
            notyf()->success('Profile updated successfully!');
            $this->closeModal();
            $this->dispatch('profileUpdated');
        } else {
            notyf()->error('Failed to update profile');
        }
    }

    public function render()
    {
        return view('livewire.settings.edit-profile-modal');
    }
}
