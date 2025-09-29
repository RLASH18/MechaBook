<div class="flex items-center justify-between h-24 rounded-lg bg-gray-50 shadow px-4">
    <div>
        <p class="text-3xl font-bold text-gray-800">{{ $value }}</p>
        <span class="text-sm text-gray-500">{{ $label }}</span>
    </div>
    <div class="flex items-center justify-center w-12 h-12 {{ $bgColor ?? 'bg-blue-600' }} rounded-lg">
        {{ $slot }}
    </div>
</div>
