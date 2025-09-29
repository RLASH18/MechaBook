@props(['headers' => []])

<thead class="border-y border-gray-100 bg-gray-50">
    <tr>
        @foreach ($headers as $head)
            <th class="px-6 py-3 whitespace-nowrap text-left">
                <span class="font-medium text-gray-500 text-xs">{{ $head }}</span>
            </th>
        @endforeach
    </tr>
</thead>
