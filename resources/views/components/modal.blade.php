@props(['show' => false, 'title' => '', 'maxWidth' => 'lg'])

@if ($show)
    {{-- Modal wrapper - positioned to account for sidebar --}}
    <div class="fixed inset-0 z-50 flex" role="dialog" aria-modal="true">
        {{-- Spacer for sidebar (256px = w-64) --}}
        <div class="w-64 flex-shrink-0"></div>

        {{-- Main content overlay area --}}
        <div class="flex-1 flex flex-col">
            {{-- Spacer for navbar (approximate height) --}}
            <div class="h-16 flex-shrink-0"></div>

            {{-- Overlay that only covers main content --}}
            <div class="flex-1 relative">
                {{-- Blurred backdrop only (no dark overlay) --}}
                <div class="absolute inset-0 backdrop-blur-sm transition-opacity"
                     wire:click="closeModal"
                     aria-hidden="true"></div>

                {{-- Modal centered in main content area --}}
                <div class="absolute inset-0 flex items-center justify-center p-4 overflow-y-auto">
                    <div @class([
                        'relative bg-white rounded-xl shadow-2xl w-full',
                        'max-w-md' => $maxWidth === 'md',
                        'max-w-lg' => $maxWidth === 'lg',
                        'max-w-xl' => $maxWidth === 'xl',
                        'max-w-2xl' => $maxWidth === '2xl',
                    ])>
                        <div class="px-6 pt-5 pb-4">
                            {{-- Header --}}
                            <div class="flex items-center justify-between mb-4">
                                <h3 class="text-lg font-semibold text-gray-900">{{ $title }}</h3>
                                <button wire:click="closeModal" type="button"
                                    class="text-gray-400 hover:text-gray-600 transition-colors focus:outline-none">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M6 18L18 6M6 6l12 12" />
                                    </svg>
                                </button>
                            </div>

                            {{-- Content --}}
                            <div>
                                {{ $slot }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endif
