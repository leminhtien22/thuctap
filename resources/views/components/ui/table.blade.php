@props(['columns'])

<div class="relative overflow-x-auto shadow-md sm:rounded-lg">
    <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
        <thead class="text-xs text-gray-700 bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
            <tr>
                @foreach ($columns as $column)
                    <th scope="col" class="px-6 py-3 whitespace-nowrap">
                        {{ $column }}
                    </th>
                @endforeach

            </tr>
        </thead>

        <tbody>
            {{ $body }}
        </tbody>
    </table>
</div>
