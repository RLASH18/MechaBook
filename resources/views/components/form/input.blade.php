<input id="{{ $id ?? $name }}" name="{{ $name ?? '' }}" type="{{ $type ?? 'text' }}" value="{{ $value ?? old($name ?? '') }}"
    {{ $attributes->merge([
        'class' => 'block w-full px-4 py-2 text-gray-700 bg-white border border-gray-300 rounded-lg
                    focus:border-blue-500 focus:ring-2 focus:ring-blue-400 focus:ring-opacity-50 focus:outline-none
                    transition duration-200 ease-in-out',
    ]) }}>
