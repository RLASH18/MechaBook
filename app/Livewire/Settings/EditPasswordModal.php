<?php

namespace App\Livewire\Settings;

use App\Http\Requests\settings\UpdatePasswordRequest;
use App\Services\SettingsService;
use Livewire\Component;

class EditPasswordModal extends Component
{
    // Modal state
    public $showModal = false;

    // Form fields
    public $current_password;
    public $new_password;
    public $new_password_confirmation;

    // Listen for edit password event
    protected $listeners = ['openEditPasswordModal' => 'openModal'];

    protected $settingsService;

    /**
     * Inject the settings service for handling business logic
     */
    public function boot(SettingsService $settingsService)
    {
        $this->settingsService = $settingsService;
    }

    /**
     * Open the modal.
     */
    public function openModal()
    {
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
        $this->reset(['current_password', 'new_password', 'new_password_confirmation']);
        $this->resetValidation();
    }

    /**
     * Update user password and notify success.
     */
    public function updatePassword()
    {
        $request = new UpdatePasswordRequest();
        $validated = $this->validate($request->rules(), $request->messages());

        $result = $this->settingsService->updatePassword(
            auth()->id(),
            $validated['current_password'],
            $validated['new_password']
        );

        if ($result['success']) {
            notyf()->success($result['message']);
            $this->closeModal();
        } else {
            $this->addError('current_password', $result['message']);
        }
    }

    public function render()
    {
        return view('livewire.settings.edit-password-modal');
    }
}
