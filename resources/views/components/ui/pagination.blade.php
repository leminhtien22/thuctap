@props(['paginator'])

<nav aria-label="Pagination">
    <ul class="inline-flex -space-x-px text-sm">
        {{-- Previous Page --}}
        <li>
            <a href="{{ $paginator->previousPageUrl() }}"
                class="flex items-center justify-center px-3 h-8 ms-0 leading-tight 
                          {{ $paginator->onFirstPage() ? 'text-gray-300 pointer-events-none' : 'text-gray-500 hover:bg-gray-100 hover:text-gray-700' }}
                          bg-white border border-e-0 border-gray-300 rounded-s-lg dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white">
                <svg class="w-2.5 h-2.5 rtl:rotate-180" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                    viewBox="0 0 6 10">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M5 1 1 5l4 4" />
                </svg>
            </a>
        </li>

        {{-- Page Numbers --}}
        @foreach ($paginator->getUrlRange(1, $paginator->lastPage()) as $page => $url)
            <li>
                <a href="{{ $url }}"
                    class="flex items-center justify-center px-3 h-8 leading-tight 
                              {{ $paginator->currentPage() == $page ? 'leading-tight text-blue-600 border border-blue-300 bg-blue-50 hover:bg-blue-100 pointer-events-none' : 'text-gray-500 border border-gray-300 hover:bg-gray-100 hover:text-gray-700' }}
                              dark:border-gray-700 dark:bg-gray-800 dark:text-white">
                    {{ $page }}
                </a>
            </li>
        @endforeach

        {{-- Next Page --}}
        <li>
            <a href="{{ $paginator->nextPageUrl() }}"
                class="flex items-center justify-center px-3 h-8 leading-tight 
                          {{ $paginator->hasMorePages() ? 'text-gray-500 hover:bg-gray-100 hover:text-gray-700' : 'text-gray-300 pointer-events-none' }}
                          bg-white border border-gray-300 rounded-e-lg dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white">
                <svg class="w-2.5 h-2.5 rtl:rotate-180" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                    fill="none" viewBox="0 0 6 10">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="m1 9 4-4-4-4" />
                </svg>
            </a>
        </li>
    </ul>
</nav>
