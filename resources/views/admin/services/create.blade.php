@extends('layouts.admin-layout')
@section('main')
    <div class="flex items-center justify-between mb-4">
        <div>
            <x-page-header title="Add New Service">
                Provide the service details to register it in the system.
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

    {{-- Form Container --}}
    <x-form.container action="{{ route('admin.service.store') }}" enctype="multipart/form-data">
        <div class="grid grid-cols-1 gap-6 lg:grid-cols-3">
            {{-- Left Column - Service Details --}}
            <div class="lg:col-span-2 space-y-6">
                {{-- Name --}}
                <div>
                    <x-form.label for="name">Service Name <span class="text-red-500">*</span></x-form.label>
                    <x-form.input id="name" name="name" type="text" placeholder="e.g., Oil Change Service"
                        value="{{ old('name') }}" />
                    <x-form.error name="name" />
                </div>

                {{-- Description --}}
                <div>
                    <x-form.label for="description">Description</x-form.label>
                    <x-form.textarea name="description" id="service_description" rows="4"
                        placeholder="Describe the service in detail..." />
                    <x-form.error name="description" />
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    {{-- Category --}}
                    <div>
                        <x-form.label for="category">Category <span class="text-red-500">*</span></x-form.label>
                        <x-form.select id="category" name="category" :options="[
                            'Maintenance' => 'Maintenance',
                            'Repair' => 'Repair',
                            'Inspection' => 'Inspection',
                            'Detailing' => 'Detailing',
                            'Diagnostic' => 'Diagnostic',
                            'Other' => 'Other',
                        ]" :selected="old('category')"
                            placeholder="Select a category" />
                        <x-form.error name="category" />
                    </div>

                    {{-- Duration Minutes --}}
                    <div>
                        <x-form.label for="duration_minutes">Duration (minutes) <span
                                class="text-red-500">*</span></x-form.label>
                        <x-form.input id="duration_minutes" name="duration_minutes" type="number" min="1"
                            step="1" placeholder="e.g., 30" value="{{ old('duration_minutes') }}" />
                        <x-form.error name="duration_minutes" />
                    </div>
                </div>

                {{-- Price --}}
                <div>
                    <x-form.label for="price">Price <span class="text-red-500">*</span></x-form.label>
                    <div class="relative">
                        <span class="absolute left-4 top-1/2 -translate-y-1/2 text-gray-500 font-medium">₱</span>
                        <x-form.input id="price" name="price" type="number" min="0" step="0.01"
                            placeholder="0.00" value="{{ old('price') }}" class="pl-8" />
                    </div>
                    <x-form.error name="price" />
                </div>
            </div>

            {{-- Right Column - Image Upload --}}
            <div class="space-y-4">
                <div>
                    <x-form.label for="service_img">Service Image</x-form.label>
                    <div class="mt-2">
                        {{-- Image Preview --}}
                        <div id="imagePreviewContainer" class="hidden mb-4">
                            <div class="relative w-full aspect-square rounded-lg overflow-hidden border-2 border-gray-300 bg-gray-50">
                                <img id="imagePreview" src="" alt="Preview" class="w-full h-full object-contain">
                                <button type="button" onclick="clearImage()"
                                    class="absolute top-2 right-2 bg-red-500 text-white rounded-full p-2 hover:bg-red-600 transition-colors shadow-lg">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M6 18L18 6M6 6l12 12" />
                                    </svg>
                                </button>
                            </div>
                        </div>

                        {{-- Upload Area --}}
                        <label for="service_img" id="uploadLabel"
                            class="flex flex-col items-center justify-center w-full aspect-square border-2 border-dashed border-gray-300 rounded-lg cursor-pointer bg-gray-50 hover:bg-gray-100 hover:border-blue-500 transition-all duration-200">
                            <div class="flex flex-col items-center justify-center pt-5 pb-6">
                                <svg class="w-12 h-12 mb-3 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12" />
                                </svg>
                                <p class="mb-2 text-sm text-gray-500 font-semibold">Click to upload</p>
                                <p class="text-xs text-gray-500">PNG, JPG or WEBP</p>
                                <p class="text-xs text-gray-400 mt-1">(Max 2MB)</p>
                            </div>
                            <input id="service_img" name="service_img" type="file" class="hidden"
                                accept="image/png,image/jpeg,image/jpg,image/webp" onchange="previewImage(event)" />
                        </label>
                    </div>
                    <x-form.error name="service_img" />
                </div>
            </div>
        </div>

        {{-- Submit Button --}}
        <div class="mt-8 flex items-center justify-end space-x-4 pt-6 border-t border-gray-200">
            <x-button-link href="{{ route('admin.service.index') }}" text="Cancel" />
            <x-form.button type="submit" text="Add Service">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                </svg>
            </x-form.button>
        </div>
    </x-form.container>

    {{-- Image Preview Script --}}
    <script>
        function previewImage(event) {
            const file = event.target.files[0];
            if (file) {
                // Check file size (2MB = 2 * 1024 * 1024 bytes)
                if (file.size > 2 * 1024 * 1024) {
                    alert('File size must be less than 2MB');
                    event.target.value = '';
                    return;
                }

                const reader = new FileReader();
                reader.onload = function(e) {
                    document.getElementById('imagePreview').src = e.target.result;
                    document.getElementById('imagePreviewContainer').classList.remove('hidden');
                    document.getElementById('uploadLabel').classList.add('hidden');
                }
                reader.readAsDataURL(file);
            }
        }

        function clearImage() {
            document.getElementById('service_img').value = '';
            document.getElementById('imagePreview').src = '';
            document.getElementById('imagePreviewContainer').classList.add('hidden');
            document.getElementById('uploadLabel').classList.remove('hidden');
        }
    </script>
@endsection
