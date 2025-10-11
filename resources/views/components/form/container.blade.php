@props(['action', 'method' => 'POST'])

@php
    $httpMethods = ['GET', 'POST'];
    $realMethod = strtoupper($method);
@endphp

{{-- Form Container --}}
<div class="overflow-hidden rounded-2xl border border-gray-200 bg-white">
    <form action="{{ $action }}" method="{{ in_array($realMethod, $httpMethods) ? $realMethod : 'POST' }}"
        class="p-6" {{ $attributes }}>

        @csrf

        @unless (in_array($realMethod, $httpMethods))
            @method($realMethod)
        @endunless

        {{ $slot }}
    </form>
</div>
