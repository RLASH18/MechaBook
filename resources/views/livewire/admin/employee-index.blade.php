<div>
    {{-- Employee Table --}}
    <div class="overflow-hidden rounded-2xl border border-gray-200 bg-white pt-4">
        <x-table.header title="Employee List" />

        {{-- Table --}}
        <div class="max-w-full overflow-x-auto custom-scrollbar">
            <x-table.table>

                {{-- Head --}}
                <x-table.thead :headers="['Employees ID', 'Name', 'Email', 'Phone', 'Status', 'Action']" />

                {{-- Body --}}
                <x-table.tbody>
                    @foreach ($employees as $employee)
                        <tr>
                            @php
                                // Split name and get initials
                                $nameParts = explode(' ', $employee->name);
                                $firstName = $nameParts[0] ?? '';
                                $lastName = end($nameParts) ?? '';
                                $initials = strtoupper(substr($firstName, 0, 1) . substr($lastName, 0, 1));

                                // Determine status - handle null last_active_at
                                $lastActive = $employee->last_active_at ?? $employee->created_at;
                                $daysInactive = now()->diffInDays($lastActive);
                                if ($daysInactive < 1) {
                                    $status = ['label' => 'Active', 'bg' => 'bg-green-50', 'text' => 'text-green-600'];
                                } elseif ($daysInactive <= 5) {
                                    $status = ['label' => 'Idle', 'bg' => 'bg-yellow-50', 'text' => 'text-yellow-600'];
                                } else {
                                    $status = ['label' => 'Inactive', 'bg' => 'bg-red-50', 'text' => 'text-red-600'];
                                }
                            @endphp

                            {{-- Employee ID --}}
                            <x-table.td>
                                <span class="font-medium text-gray-700 text-sm">
                                    {{ 'EMP-' . str_pad($employee->id, 4, '0', STR_PAD_LEFT) }}
                                </span>
                            </x-table.td>

                            {{-- Name --}}
                            <x-table.td>
                                <div class="flex items-center gap-3">
                                    <div
                                        class="w-10 h-10 bg-gradient-to-br from-blue-400 to-blue-600 rounded-full flex items-center justify-center flex-shrink-0">
                                        <span class="text-white font-semibold text-xs">{{ $initials }}</span>
                                    </div>
                                    <div>
                                        <p class="font-medium text-gray-700 text-sm">{{ $firstName }}</p>
                                    </div>
                                </div>
                            </x-table.td>

                            {{-- Email --}}
                            <x-table.td class="text-small">{{ $employee->email }}</x-table.td>

                            {{-- Phone --}}
                            <x-table.td class="text-small">{{ $employee->phone }}</x-table.td>

                            {{-- Status --}}
                            <x-table.td>
                                <span
                                    class="rounded-full px-2 py-0.5 text-xs font-medium {{ $status['bg'] }} {{ $status['text'] }}">
                                    {{ $status['label'] }}
                                </span>
                            </x-table.td>

                            {{-- Action --}}
                            <x-table.td class="items-center">
                                <div class="flex justify-center items-center gap-4">

                                    {{-- Show Button --}}
                                    <x-icon-button href="{{ route('admin.employee.show', $employee->id) }}"
                                        title="View Employee">
                                        <svg class="w-5 h-5 cursor-pointer fill-gray-700 hover:fill-indigo-600"
                                            xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                                            <path
                                                d="M12.0003 3C17.3924 3 21.8784 6.87976 22.8189 12C21.8784 17.1202 17.3924 21 12.0003 21C6.60812 21 2.12215 17.1202 1.18164 12C2.12215 6.87976 6.60812 3 12.0003 3ZM12.0003 19C16.2359 19 19.8603 16.052 20.7777 12C19.8603 7.94803 16.2359 5 12.0003 5C7.7646 5 4.14022 7.94803 3.22278 12C4.14022 16.052 7.7646 19 12.0003 19ZM12.0003 16.5C9.51498 16.5 7.50026 14.4853 7.50026 12C7.50026 9.51472 9.51498 7.5 12.0003 7.5C14.4855 7.5 16.5003 9.51472 16.5003 12C16.5003 14.4853 14.4855 16.5 12.0003 16.5ZM12.0003 14.5C13.381 14.5 14.5003 13.3807 14.5003 12C14.5003 10.6193 13.381 9.5 12.0003 9.5C10.6196 9.5 9.50026 10.6193 9.50026 12C9.50026 13.3807 10.6196 14.5 12.0003 14.5Z" />
                                        </svg>
                                    </x-icon-button>

                                    {{-- Edit Button --}}
                                    <x-icon-button href="{{ route('admin.employee.edit', $employee->id) }}"
                                        title="Edit Employee">
                                        <svg class="w-5 h-5 cursor-pointer fill-gray-700 hover:fill-green-600"
                                            xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                                            <path
                                                d="M6.41421 15.89L16.5563 5.74785L15.1421 4.33363L5 14.4758V15.89H6.41421ZM7.24264 17.89H3V13.6473L14.435 2.21231C14.8256 1.82179 15.4587 1.82179 15.8492 2.21231L18.6777 5.04074C19.0682 5.43126 19.0682 6.06443 18.6777 6.45495L7.24264 17.89ZM3 19.89H21V21.89H3V19.89Z" />
                                        </svg>
                                    </x-icon-button>

                                    {{-- Delete Button --}}
                                    <form action="{{ route('admin.employee.destroy', $employee->id) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" title="Delete Employee">
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
                    @endforeach
                </x-table.tbody>
            </x-table.table>

            {{-- Pagination --}}
            <x-pagination :items="$employees" />
        </div>
    </div>
</div>
