<div>
    {{-- Service Table --}}
    <div class="overflow-hidden rounded-2xl border border-gray-200 bg-white pt-4">
        <x-table.header title="Service List" />

        {{-- Table --}}
        <div class="max-w-full overflow-x-auto custom-scrollbar">
            <x-table.table>

                {{-- Head --}}
                <x-table.thead :headers="['Service ID', 'Service Name', 'Category', 'Price', 'Action']" />

                {{-- Body --}}
                <x-table.tbody>
                    @forelse ($services as $service)
                        <tr>
                            {{-- Service ID --}}
                            <x-table.td>
                                <span class="font-medium text-gray-700 text-sm">
                                    {{ 'SRV-' . str_pad($service->id, 4, '0', STR_PAD_LEFT) }}
                                </span>
                            </x-table.td>

                            {{-- Name --}}
                            <x-table.td>
                                <p class="font-medium text-gray-900 text-sm mb-1 truncate max-w-[150px]"
                                    title="{{ $service->name }}">
                                    {{ $service->name }}
                                </p>
                            </x-table.td>

                            {{-- Category --}}
                            <x-table.td>
                                @php
                                    $categoryColors = [
                                        'Maintenance' => 'bg-green-100 text-green-800',
                                        'Repair' => 'bg-blue-100 text-blue-800',
                                        'Inspection' => 'bg-yellow-100 text-yellow-800',
                                        'Detailing' => 'bg-purple-100 text-purple-800',
                                        'Diagnostic' => 'bg-pink-100 text-pink-800',
                                    ];
                                    $colorClass = $categoryColors[$service->category] ?? 'bg-gray-100 text-gray-800';
                                @endphp
                                <span
                                    class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium {{ $colorClass }}">
                                    {{ $service->category }}
                                </span>
                            </x-table.td>

                            {{-- Price --}}
                            <x-table.td class="text-small text-green-600 font-semibold">
                                ₱{{ number_format($service->price, 2) }}
                            </x-table.td>

                            {{-- Action --}}
                            <x-table.td class="items-center">
                                <div class="flex items-center gap-4">

                                    {{-- Show Button --}}
                                    <x-icon-button href="{{ route('admin.service.show', $service->id) }}"
                                        title="View Service">
                                        <svg class="w-5 h-5 cursor-pointer fill-gray-700 hover:fill-indigo-600"
                                            xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                                            <path
                                                d="M12.0003 3C17.3924 3 21.8784 6.87976 22.8189 12C21.8784 17.1202 17.3924 21 12.0003 21C6.60812 21 2.12215 17.1202 1.18164 12C2.12215 6.87976 6.60812 3 12.0003 3ZM12.0003 19C16.2359 19 19.8603 16.052 20.7777 12C19.8603 7.94803 16.2359 5 12.0003 5C7.7646 5 4.14022 7.94803 3.22278 12C4.14022 16.052 7.7646 19 12.0003 19ZM12.0003 16.5C9.51498 16.5 7.50026 14.4853 7.50026 12C7.50026 9.51472 9.51498 7.5 12.0003 7.5C14.4855 7.5 16.5003 9.51472 16.5003 12C16.5003 14.4853 14.4855 16.5 12.0003 16.5ZM12.0003 14.5C13.381 14.5 14.5003 13.3807 14.5003 12C14.5003 10.6193 13.381 9.5 12.0003 9.5C10.6196 9.5 9.50026 10.6193 9.50026 12C9.50026 13.3807 10.6196 14.5 12.0003 14.5Z" />
                                        </svg>
                                    </x-icon-button>

                                    {{-- Edit Button --}}
                                    <x-icon-button href="{{ route('admin.service.edit', $service->id) }}"
                                        title="Edit Service">
                                        <svg class="w-5 h-5 cursor-pointer fill-gray-700 hover:fill-green-600"
                                            xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                                            <path
                                                d="M6.41421 15.89L16.5563 5.74785L15.1421 4.33363L5 14.4758V15.89H6.41421ZM7.24264 17.89H3V13.6473L14.435 2.21231C14.8256 1.82179 15.4587 1.82179 15.8492 2.21231L18.6777 5.04074C19.0682 5.43126 19.0682 6.06443 18.6777 6.45495L7.24264 17.89ZM3 19.89H21V21.89H3V19.89Z" />
                                        </svg>
                                    </x-icon-button>

                                    {{-- Delete Button --}}
                                    <form action="{{ route('admin.service.destroy', $service->id) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" title="Delete Service">
                                            <svg class="w-5 h-5 cursor-pointer fill-gray-700 hover:fill-red-600 mt-1"
                                                xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"
                                                fill="currentColor">
                                                <path
                                                    d="M7 4V2H17V4H22V6H20V21C20 21.5523 19.5523 22 19 22H5C4.44772 22 4 21.5523 4 21V6H2V4H7ZM6 6V20H18V6H6ZM9 9H11V17H9V9ZM13 9H15V17H13V9Z" />
                                            </svg>
                                        </button>
                                    </form>
                                </div>
                            </x-table.td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-12">
                                <div class="text-center">
                                    <svg class="w-16 h-16 mx-auto text-gray-400 mb-4" fill="none"
                                        stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                    </svg>
                                    <p class="text-gray-500 text-lg font-medium">No services found</p>
                                    <p class="text-gray-400 text-sm mt-1">Try adjusting your search or filters</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </x-table.tbody>
            </x-table.table>

            {{-- Pagination --}}
            <x-pagination :items="$services" />
        </div>
    </div>
</div>
