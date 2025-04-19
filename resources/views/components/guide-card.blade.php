@props([
    'image' => 'html.svg',
    'title' => 'Довідник HTML',
    'id',
    'colorFrom' => '#fd7c48',
    'colorTo' => '#bf4628',
])

<div
    class="relative group max-w-sm p-6 bg-gray-100 border border-gray-200 rounded-lg shadow-sm 
    dark:bg-gray-800 dark:border-gray-700 overflow-hidden ">

    <div class="absolute inset-0 opacity-0 group-hover:opacity-100 transition-opacity duration-300"
        style="background: linear-gradient(to top right, {{ $colorFrom }}, {{ $colorTo }});">
    </div>

    <div class="relative overflow-hidden inline-block">

        <div class="rounded-lg absolute inset-0  transition-opacity duration-300 opacity-100 group-hover:opacity-0"
            style="background: linear-gradient(to top right, {{ $colorFrom }}, {{ $colorTo }});">
        </div>

        <div
            class="absolute inset-0 border-2 border-transparent group-hover:border-white group-hover:border-opacity-25 transition-all duration-300 rounded-lg pointer-events-none">
        </div>

        <div class="relative z-10">
            <img class="w-16 h-16" src="{{ asset('images/' . $image) }}" alt="{{ $title }}">
        </div>

    </div>

    <h5 class="relative mb-2 text-4xl tracking-tight text-gray-900 dark:text-white">{{ $title }}</h5>

</div>
