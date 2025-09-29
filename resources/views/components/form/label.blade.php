<label for="{{ $for ?? '' }}" {{ $attributes->merge(['class' => 'block mb-2 text-sm font-medium text-gray-700']) }}>
    {{ $slot }}
</label>
