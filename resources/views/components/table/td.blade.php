@props(['class' => ''])

<td {{ $attributes->merge(['class' => 'px-6 py-3 text-sm font-medium ' . $class]) }}>
    {{ $slot }}
</td>
