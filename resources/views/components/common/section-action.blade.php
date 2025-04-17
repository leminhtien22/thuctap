@props(['title', 'description'])

<div class="relative overflow-hidden bg-white shadow-md dark:bg-gray-800 sm:rounded-lg my-6">
    <div class="flex-row items-center justify-between p-4 space-y-3 sm:flex sm:space-y-0 sm:space-x-4">
        <div>
            <h5 class="mr-3 font-semibold dark:text-white">{{ $title }}</h5>
            
            @if ($description)
                <p class="text-sm text-gray-500 dark:text-gray-400">{{ $description }}</p>
            @endif
        </div>

        {{ $slot }}
    </div>
</div>
