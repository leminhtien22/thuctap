@props([
    'name' => 'post',
    'class' => '',
    'activeColor' => '',
])

@php
    $icons = [
        'post' => '<svg class="w-5 h-5 transition duration-75"
                aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                fill="currentColor" viewBox="0 0 24 24">
                <path fill-rule="evenodd"
                    d="M5 3a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h11.5c.07 0 .14-.007.207-.021.095.014.193.021.293.021h2a2 2 0 0 0 2-2V7a1 1 0 0 0-1-1h-1a1 1 0 1 0 0 2v11h-2V5a2 2 0 0 0-2-2H5Zm7 4a1 1 0 0 1 1-1h.5a1 1 0 1 1 0 2H13a1 1 0 0 1-1-1Zm0 3a1 1 0 0 1 1-1h.5a1 1 0 1 1 0 2H13a1 1 0 0 1-1-1Zm-6 4a1 1 0 0 1 1-1h6a1 1 0 1 1 0 2H7a1 1 0 0 1-1-1Zm0 3a1 1 0 0 1 1-1h6a1 1 0 1 1 0 2H7a1 1 0 0 1-1-1ZM7 6a1 1 0 0 0-1 1v3a1 1 0 0 0 1 1h3a1 1 0 0 0 1-1V7a1 1 0 0 0-1-1H7Zm1 3V8h1v1H8Z"
                    clip-rule="evenodd" />
            </svg>',
        'ticket' => '<svg class="shrink-0 w-5 h-5 transition duration-75"
                aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor"
                viewBox="0 0 18 18">
                <path
                    d="M6.143 0H1.857A1.857 1.857 0 0 0 0 1.857v4.286C0 7.169.831 8 1.857 8h4.286A1.857 1.857 0 0 0 8 6.143V1.857A1.857 1.857 0 0 0 6.143 0Zm10 0h-4.286A1.857 1.857 0 0 0 10 1.857v4.286C10 7.169 10.831 8 11.857 8h4.286A1.857 1.857 0 0 0 18 6.143V1.857A1.857 1.857 0 0 0 16.143 0Zm-10 10H1.857A1.857 1.857 0 0 0 0 11.857v4.286C0 17.169.831 18 1.857 18h4.286A1.857 1.857 0 0 0 8 16.143v-4.286A1.857 1.857 0 0 0 6.143 10Zm10 0h-4.286A1.857 1.857 0 0 0 10 11.857v4.286c0 1.026.831 1.857 1.857 1.857h4.286A1.857 1.857 0 0 0 18 16.143v-4.286A1.857 1.857 0 0 0 16.143 10Z" />
            </svg>',
        'order' => '<svg class="shrink-0 w-5 h-5 transition duration-75"
                aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor"
                viewBox="0 0 20 20">
                <path
                    d="m17.418 3.623-.018-.008a6.713 6.713 0 0 0-2.4-.569V2h1a1 1 0 1 0 0-2h-2a1 1 0 0 0-1 1v2H9.89A6.977 6.977 0 0 1 12 8v5h-2V8A5 5 0 1 0 0 8v6a1 1 0 0 0 1 1h8v4a1 1 0 0 0 1 1h2a1 1 0 0 0 1-1v-4h6a1 1 0 0 0 1-1V8a5 5 0 0 0-2.582-4.377ZM6 12H4a1 1 0 0 1 0-2h2a1 1 0 0 1 0 2Z" />
            </svg>',
        'user' => '<svg class="shrink-0 w-5 h-5 transition duration-75"
                aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor"
                viewBox="0 0 20 18">
                <path
                    d="M14 2a3.963 3.963 0 0 0-1.4.267 6.439 6.439 0 0 1-1.331 6.638A4 4 0 1 0 14 2Zm1 9h-1.264A6.957 6.957 0 0 1 15 15v2a2.97 2.97 0 0 1-.184 1H19a1 1 0 0 0 1-1v-1a5.006 5.006 0 0 0-5-5ZM6.5 9a4.5 4.5 0 1 0 0-9 4.5 4.5 0 0 0 0 9ZM8 10H5a5.006 5.006 0 0 0-5 5v2a1 1 0 0 0 1 1h11a1 1 0 0 0 1-1v-2a5.006 5.006 0 0 0-5-5Z" />
            </svg>',
        'collection' => '<svg class="shrink-0 w-5 h-5 transition duration-75"
                aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor"
                viewBox="0 0 18 20">
                <path
                    d="M17 5.923A1 1 0 0 0 16 5h-3V4a4 4 0 1 0-8 0v1H2a1 1 0 0 0-1 .923L.086 17.846A2 2 0 0 0 2.08 20h13.84a2 2 0 0 0 1.994-2.153L17 5.923ZM7 9a1 1 0 0 1-2 0V7h2v2Zm0-5a2 2 0 1 1 4 0v1H7V4Zm6 5a1 1 0 1 1-2 0V7h2v2Z" />
            </svg>',
            'shop' => '<svg class="shrink-0 w-5 h-5 transition duration-75" 
                aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" 
                viewBox="0 0 20 20">
                <path 
                    d="M3 1a1 1 0 0 0-1 1v.586l1.707 1.707A1 1 0 0 0 4.414 5H17a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1H3Zm0 4v11a2 2 0 0 0 2 2h10a2 2 0 0 0 2-2V5H3Zm4 10a1 1 0 1 1 0-2 1 1 0 0 1 0 2Zm4 0a1 1 0 1 1 0-2 1 1 0 0 1 0 2Z" />
            </svg>',
            'photo' => '<svg class="shrink-0 w-5 h-5 transition duration-75"
             xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
            <path d="M4 4a2 2 0 0 0-2 2v12c0 1.104.896 2 2 2h16a2 2 0 0 0 2-2V6c0-1.104-.896-2-2-2H4zm0 2h16v12H4V6zm3.5 2a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3zM5 16l3.5-4.5 2.5 3L15.5 10 19 16H5z"/>
            </svg>',
            'setting' => '<svg class="shrink-0 w-5 h-5 transition duration-75"
              xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
             <path d="M12 15.5a3.5 3.5 0 1 0 0-7 3.5 3.5 0 0 0 0 7zM19.43 12.98c.04-.32.07-.66.07-1s-.03-.68-.07-1l2.11-1.65a.5.5 0 0 0 .12-.65l-2-3.46a.5.5 0 0 0-.61-.22l-2.49 1a7.025 7.025 0 0 0-1.5-.87l-.38-2.65A.5.5 0 0 0 14 2h-4a.5.5 0 0 0-.5.43l-.38 2.65a7.025 7.025 0 0 0-1.5.87l-2.49-1a.5.5 0 0 0-.61.22l-2 3.46a.5.5 0 0 0 .12.65L4.57 11c-.04.32-.07.66-.07 1s.03.68.07 1l-2.11 1.65a.5.5 0 0 0-.12.65l2 3.46a.5.5 0 0 0 .61.22l2.49-1c.47.36.97.66 1.5.87l.38 2.65a.5.5 0 0 0 .5.43h4c.25 0 .46-.18.5-.43l.38-2.65c.53-.21 1.03-.51 1.5-.87l2.49 1a.5.5 0 0 0 .61-.22l2-3.46a.5.5 0 0 0-.12-.65l-2.11-1.65z"/>
             </svg>',

        'exhibition' => '<svg class="shrink-0 w-5 h-5 transition duration-75" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" viewBox="0 0 24 24">
  <path fill-rule="evenodd" d="M6 5V4a1 1 0 1 1 2 0v1h3V4a1 1 0 1 1 2 0v1h3V4a1 1 0 1 1 2 0v1h1a2 2 0 0 1 2 2v2H3V7a2 2 0 0 1 2-2h1ZM3 19v-8h18v8a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2Zm5-6a1 1 0 1 0 0 2h8a1 1 0 1 0 0-2H8Z" clip-rule="evenodd"/>
</svg>
',
    ];
@endphp

<span {{ $attributes->merge(['class' => 'inline-flex items-center justify-center ' . $class . ' ' . $activeColor]) }}>
    {!! $icons[$name] ?? '' !!}
</span>
