@if (count($breadcrumbs))

    <div class="flex items-center bg-gray-100 dark:bg-gray-800 rounded-lg">
        @foreach ($breadcrumbs as $breadcrumb)
            @if ($breadcrumb->url && !$loop->last)
                <a href="{{ $breadcrumb->url }}"
                    class="flex items-center text-black dark:text-white font-semibold hover:bg-gray-300 dark:hover:bg-gray-600 rounded-lg px-2 py-2">
                    {{ $breadcrumb->title }}
                </a>
                <svg class="breadcrumbs-link_icon" width="14" height="14" viewBox="0 0 14 14" fill="none"
                    xmlns="http://www.w3.org/2000/svg">
                    <path d="M4.667 1.556L9.333 7l-4.666 5.445" stroke="#0795E2" stroke-width="1.5"></path>
                </svg>
            @else
                <span
                    class="text-sky-500 flex items-center px-2 py-2 rounded-lg font-semibold">{{ $breadcrumb->title }}</span>
            @endif
        @endforeach
    </div>

@endif
