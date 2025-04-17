@props([
    'items' => [],
])

<aside id="logo-sidebar"
    class="fixed top-0 left-0 z-40 w-64 h-screen pt-20 transition-transform -translate-x-full bg-white border-r border-gray-200 sm:translate-x-0 dark:bg-gray-800 dark:border-gray-700"
    aria-label="Sidebar">
    <div class="h-full px-3 pb-4 overflow-y-auto bg-white dark:bg-gray-800">
        <ul class="space-y-2 font-medium">
            @foreach ($items as $item)
                <li>
                    <a href="{{ route($item['route']) }}"
                        class="flex items-center p-2 text-gray-900 rounded-lg dark:text-white hover:bg-gray-100 group {{ Route::is($item['route']) ? 'bg-gray-100 dark:bg-gray-700 text-gray-900' : '' }}">
                        <x-common.icon :name="$item['icon']" :active-color="Route::is($item['route']) ? 'text-gray-900 dark:text-gray-300' : ''" class="text-gray-500 group-hover:text-gray-900" />

                        <span class="flex-1 ms-3 whitespace-nowrap">
                            {{ $item['name'] }}
                        </span>

                        @isset($item['count'])
                            <span
                                class="inline-flex items-center justify-center w-3 h-3 p-3 ms-3 text-sm font-medium text-blue-800 bg-blue-100 rounded-full dark:bg-blue-900 dark:text-blue-300">
                                {{ $item['count'] }}
                            </span>
                        @endisset
                    </a>
                </li>
            @endforeach
        </ul>
    </div>
</aside>
