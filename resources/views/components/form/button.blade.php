@props([
    'type' => 'button',
    'text' => 'Button',
])

<button type="{{ $type }}"
    {{ $attributes->class([
        'inline-flex items-center justify-center px-6 py-3 text-sm font-medium tracking-wide text-white capitalize
        transition-colors duration-300 transform bg-blue-600 rounded-2xl shadow-sm
        hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 cursor-pointer'
    ]) }}>

    {{-- Optional icon slot --}}
    @if ($slot->isNotEmpty())
        <span class="mr-2 flex items-center">
            {{ $slot }}
        </span>
    @endif

    {{ $text }}
</button>
