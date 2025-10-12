@extends('layouts.admin-layout')
@section('main')
    {{-- Header --}}
    <div class="flex items-center justify-between mb-4">
        <div>
            <x-page-header title="Service Details">
                View detailed information about this service.
            </x-page-header>
        </div>

        <div>
            <x-button-link href="{{ route('admin.service.index') }}" text="Go back">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-5 h-5 mr-2">
                    <path
                        d="M7.82843 10.9999H20V12.9999H7.82843L13.1924 18.3638L11.7782 19.778L4 11.9999L11.7782 4.22168L13.1924 5.63589L7.82843 10.9999Z" />
                </svg>
            </x-button-link>
        </div>
    </div>

    {{-- Service Info Card --}}
    <div class="bg-blue-50 border border-blue-200 rounded-lg p-4 mb-4">
        <div class="flex items-center">
            <svg class="w-5 h-5 text-blue-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
            </svg>
            <div>
                <h4 class="text-sm font-medium text-blue-900">Service Offering</h4>
                <p class="text-sm text-blue-700">This service is available for customer bookings.</p>
            </div>
        </div>
    </div>

    <div class="overflow-hidden rounded-2xl border border-gray-200 bg-white shadow">
        <div class="p-6">
            <div class="grid grid-cols-1 gap-6 lg:grid-cols-3">
                {{-- Left Column - Service Image --}}
                <div class="lg:col-span-1">
                    <div class="sticky top-6">
                        <x-form.label>Service Image</x-form.label>
                        <div class="mt-2 w-full aspect-square rounded-lg overflow-hidden border-2 border-gray-300 bg-gray-50">
                            @if ($service->service_img)
                                <img src="{{ asset('storage/' . $service->service_img) }}" alt="{{ $service->name }}"
                                    class="w-full h-full object-cover">
                            @else
                                <div class="w-full h-full flex flex-col items-center justify-center text-gray-400">
                                    <svg class="w-20 h-20 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                    </svg>
                                    <p class="text-sm">No image available</p>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>

                {{-- Right Column - Service Details --}}
                <div class="lg:col-span-2 space-y-6">
                    {{-- Service Name --}}
                    <div>
                        <x-form.label>Service Name</x-form.label>
                        <div
                            class="block w-full px-4 py-2 text-gray-900 bg-gray-50 border border-gray-300 rounded-lg font-medium text-base">
                            {{ $service->name }}
                        </div>
                    </div>

                    {{-- Description --}}
                    <div>
                        <x-form.label>Description</x-form.label>
                        <div
                            class="block w-full px-4 py-3 text-gray-900 bg-gray-50 border border-gray-300 rounded-lg min-h-[100px]">
                            {{ $service->description ?? 'No description provided' }}
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        {{-- Category --}}
                        <div>
                            <x-form.label>Category</x-form.label>
                            <div class="block w-full px-4 py-2 text-gray-900 bg-gray-50 border border-gray-300 rounded-lg">
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-base font-medium bg-blue-50 text-blue-600">
                                    {{ $service->category }}
                                </span>
                            </div>
                        </div>

                        {{-- Service ID --}}
                        <div>
                            <x-form.label>Service ID</x-form.label>
                            <div
                                class="block w-full px-4 py-2 text-gray-900 bg-gray-50 border border-gray-300 rounded-lg font-mono">
                                SRV-{{ str_pad($service->id, 4, '0', STR_PAD_LEFT) }}
                            </div>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        {{-- Duration --}}
                        <div>
                            <x-form.label>Duration</x-form.label>
                            <div class="block w-full px-4 py-2 text-gray-900 bg-gray-50 border border-gray-300 rounded-lg">
                                <div class="flex items-center">
                                    <svg class="w-5 h-5 text-gray-600 mr-2" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                    <span class="font-semibold">{{ $service->duration_minutes }} minutes</span>
                                </div>
                            </div>
                        </div>

                        {{-- Price --}}
                        <div>
                            <x-form.label>Price</x-form.label>
                            <div class="block w-full px-4 py-2 text-gray-900 bg-gray-50 border border-gray-300 rounded-lg">
                                <div class="flex items-center">
                                    <svg class="w-5 h-5 text-green-600 mr-2" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                    <span
                                        class="text-base font-semibold text-green-600">₱{{ number_format($service->price, 2) }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Additional Information --}}
            <div class="mt-8 pt-6 border-t border-gray-200">
                <h3 class="text-lg font-medium text-gray-900 mb-4">Additional Information</h3>
                <div class="grid grid-cols-1 gap-6 lg:grid-cols-2">
                    {{-- Created At --}}
                    <div>
                        <x-form.label>Created At</x-form.label>
                        <div class="block w-full px-4 py-2 text-gray-900 bg-gray-50 border border-gray-300 rounded-lg">
                            {{ $service->created_at->format('M d, Y \a\t g:i A') }}
                        </div>
                    </div>

                    {{-- Last Updated --}}
                    <div>
                        <x-form.label>Last Updated</x-form.label>
                        <div class="block w-full px-4 py-2 text-gray-900 bg-gray-50 border border-gray-300 rounded-lg">
                            {{ $service->updated_at->format('M d, Y \a\t g:i A') }}
                        </div>
                    </div>
                </div>
            </div>

            {{-- Action Buttons --}}
            <div class="mt-8 flex items-center justify-end space-x-4 pt-6 border-t border-gray-200">
                <form action="{{ route('admin.service.destroy', $service->id) }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <x-form.button type="submit" text="Delete Service"
                        class="!bg-red-600 hover:!bg-red-700 focus:!ring-red-500">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16">
                            </path>
                        </svg>
                    </x-form.button>
                </form>
                <x-button-link href="{{ route('admin.service.edit', $service->id) }}" text="Edit Service"
                    class="!bg-green-600 hover:!bg-green-700 focus:!ring-green-500 focus:!border-green-600 focus-visible:!ring-green-600 active:!ring-green-600 text-white">
                    <svg class="w-4 h-4 mr-2" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                        <path
                            d="M6.41421 15.89L16.5563 5.74785L15.1421 4.33363L5 14.4758V15.89H6.41421ZM7.24264 17.89H3V13.6473L14.435 2.21231C14.8256 1.82179 15.4587 1.82179 15.8492 2.21231L18.6777 5.04074C19.0682 5.43126 19.0682 6.06443 18.6777 6.45495L7.24264 17.89ZM3 19.89H21V21.89H3V19.89Z" />
                    </svg>
                </x-button-link>
            </div>
        </div>
    </div>
@endsection
