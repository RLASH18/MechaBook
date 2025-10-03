@props([
    'href' => '#',
    'title' => 'Button',
])

<a wire:navigate href="{{ $href }}" title="{{ $title }}" aria-label="{{ $title }}"
    {{ $attributes->class([]) }}>
    {{ $slot }}
</a>
