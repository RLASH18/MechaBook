@if (session('auth_success'))
    <div
        class="mt-2 flex items-start gap-3 p-4 text-sm text-green-800 bg-green-50 border border-green-200 rounded-xl">
        <svg class="w-5 h-5 mr-2 flex-shrink-0" fill="none" stroke="currentColor"
            viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M5 13l4 4L19 7" />
        </svg>
        <span>{{ session('auth_success') }}</span>
    </div>
@endif

@if (session('auth_error'))
    <div
        class="mt-2 flex items-start gap-3 p-4 text-sm text-red-800 bg-red-50 border border-red-200 rounded-xl">
        <svg class="w-5 h-5 mr-2 flex-shrink-0" fill="none" stroke="currentColor"
            viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M6 18L18 6M6 6l12 12" />
        </svg>
        <span>{{ session('auth_error') }}</span>
    </div>
@endif

@if (session('auth_info'))
    <div
        class="mt-2 flex items-start gap-3 p-4 text-sm text-blue-800 bg-blue-50 border border-blue-200 rounded-xl">
        <svg class="w-5 h-5 mr-2 flex-shrink-0" xmlns="http://www.w3.org/2000/svg"
            width="24" height="24" viewBox="0 0 24 24" fill="none"
            stroke="currentColor" stroke-width="2" stroke-linecap="round"
            stroke-linejoin="round" class="lucide lucide-info-icon lucide-info">
            <circle cx="12" cy="12" r="10" />
            <path d="M12 16v-4" />
            <path d="M12 8h.01" />
        </svg>
        <div class="flex-1">
            <span>{{ session('auth_info') }}</span>
            @if (str_contains(session('auth_info'), 'verify your email'))
                <div class="mt-3">
                    <a href="{{ route('verification.resend.form') }}"
                        class="text-blue-600 hover:text-blue-800 underline text-sm font-medium transition-colors">
                        Resend verification email
                    </a>
                </div>
            @endif
        </div>
    </div>
@endif
