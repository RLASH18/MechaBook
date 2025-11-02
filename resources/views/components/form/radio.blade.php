@props(['name', 'value', 'label'])

<label class="flex items-center">
    <input type="radio" name="{{ $name }}" value="{{ $value }}"
        {{ $attributes->merge([
            'class' => 'w-4 h-4 text-blue-600 border-gray-300 focus:ring-blue-500',
        ]) }}>
    <span class="ml-2 text-sm text-gray-700">{{ $label }}</span>
</label>
