<?php

namespace App\Livewire\Settings;

use App\Services\SettingsService;
use App\Traits\LogoutHandler;
use Livewire\Component;

class DeleteAccountModal extends Component
{
    use LogoutHandler;

    // Modal state
    public $showModal = false;

    // Form field
    public $password;

    // Listen for delete account event
    protected $listeners = ['openDeleteAccountModal' => 'openModal'];

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
        $this->reset(['password']);
        $this->resetValidation();
    }

    /**
     * Get validation rules.
     */
    protected function rules()
    {
        return [
            'password' => 'required|string|min:8'
        ];
    }

    /**
     * Delete user account.
     */
    public function deleteAccount()
    {
        $this->validate();

        $result = $this->settingsService->deleteAccount(auth()->id(), $this->password);

        if ($result['success']) {
            notyf()->success($result['message']);

            // Logout the user using trait
            return $this->logoutUser();
        } else {
            $this->addError('password', $result['message']);
        }
    }

    public function render()
    {
        return view('livewire.settings.delete-account-modal');
    }
}
