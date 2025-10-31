@props([
    'href' => '#',
    'text' => 'Button',
])

<a wire:navigate href="{{ $href }}"
    {{ $attributes->class([
        'inline-flex items-center px-6 py-3 text-sm text-gray-700 border border-gray-300 rounded-2xl shadow-sm
        focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500
        focus-visible:ring-2 focus-visible:ring-indigo-500 active:ring-2 active:ring-indigo-500 transition-all cursor-pointer'
    ]) }}>
    {{ $slot }}
    <span>{{ $text }}</span>
</a>
