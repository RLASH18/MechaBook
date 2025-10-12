@props(['name', 'id' => null, 'options' => [], 'selected' => null, 'placeholder' => 'Select an option'])

<select id="{{ $id ?? $name }}" name="{{ $name }}"
    {{ $attributes->merge([
        'class' => 'block w-full px-4 py-2 text-gray-700 bg-white border border-gray-300 rounded-lg
                    focus:border-blue-500 focus:ring-2 focus:ring-blue-400 focus:ring-opacity-50 focus:outline-none
                    transition duration-200 ease-in-out',
    ]) }}>
    @if ($placeholder)
        <option value="" disabled {{ !$selected ? 'selected' : '' }}>{{ $placeholder }}</option>
    @endif

    @if (!empty($options))
        @foreach ($options as $value => $label)
            <option value="{{ $value }}" {{ $selected == $value ? 'selected' : '' }}>{{ $label }}</option>
        @endforeach
    @else
        {{ $slot }}
    @endif
</select>
