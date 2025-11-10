<?php

namespace App\Livewire\Settings;

use App\Http\Requests\settings\UpdateProfileRequest;
use App\Services\SettingsService;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithFileUploads;

class EditProfileModal extends Component
{
    use WithFileUploads;

    // Modal state
    public $showModal = false;

    // Form fields
    public $name;
    public $email;
    public $phone;
    public $profileImage;
    public $currentProfileImage;

    // Listen for edit profile event
    protected $listeners = ['openEditProfileModal'];

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
    public function openEditProfileModal()
    {
        $user = Auth::user();
        $this->name = $user->name;
        $this->email = $user->email;
        $this->phone = $user->phone;
        $this->currentProfileImage = $user->profile_image;
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
        $this->reset(['name', 'email', 'phone', 'profileImage']);
        $this->resetValidation();
    }

    /**
     * Update user profile and notify success.
     */
    public function updateProfile()
    {
        $request = new UpdateProfileRequest();
        $validated = $this->validate($request->rules(), $request->messages());

        // Remove profileImage from validated data since we pass it separately
        $profileData = collect($validated)->except('profileImage')->toArray();

        $result = $this->settingsService->updateUserProfile(Auth::id(), $profileData, $this->profileImage);

        if ($result) {
            notyf()->success('Profile updated successfully!');
            $this->closeModal();
        } else {
            notyf()->error('Failed to update profile');
        }
    }

    public function render()
    {
        return view('livewire.settings.edit-profile-modal');
    }
}
