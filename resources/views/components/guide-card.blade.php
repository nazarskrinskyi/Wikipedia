@props([
    'image' => 'html.svg',
    'title' => 'Довідник HTML',
    'id',
    'colorFrom' => '#fd7c48',
    'colorTo' => '#bf4628',
])

<div
    class="relative group max-w-sm p-6 bg-gray-100 border border-gray-200 rounded-lg shadow-sm 
    dark:bg-gray-800 dark:border-gray-700 overflow-hidden">

    <!-- Градиент на всю карточку -->
    <div
        class="absolute inset-0 bg-gradient-to-tr from-[{{ $colorFrom }}] to-[{{ $colorTo }}] opacity-0 group-hover:opacity-100 transition-opacity duration-300">
    </div>

    <div class="relative overflow-hidden inline-block">

        <!-- Градиент-фон внутри картинки -->
        <div
            class="rounded-lg absolute inset-0 bg-gradient-to-tr from-[{{ $colorFrom }}] to-[{{ $colorTo }}] transition-opacity duration-300 opacity-100 group-hover:opacity-0">
        </div>

        <!-- Отдельный бордер -->
        <div
            class="absolute inset-0 border-2 border-transparent group-hover:border-white group-hover:border-opacity-25 transition-all duration-300 rounded-lg pointer-events-none">
        </div>

        <!-- SVG -->
        <div class="relative z-10">
            {!! file_get_contents(public_path('images/' . $image)) !!}
        </div>

    </div>

    <h5 class="relative mb-2 text-4xl tracking-tight text-gray-900 dark:text-white">{{ $title }}</h5>

</div>
