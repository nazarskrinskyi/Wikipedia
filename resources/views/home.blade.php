<x-app-layout>
    <div class="gap-6 py-12 container mx-auto max-w-7xl">
        <x-slot name="footer">
            <x-footer/>
        </x-slot>


        {{-- @if (session('success'))
            <x-pop-up message="{{ session('success') }}" />
        @endif --}}

        <a href="{{ route('articles.index') }}"
           class="mb-4 text-blue-500 dark:text-blue-300 inline-flex items-center px-1 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 rounded-lg ">
            <h3 class="text-blue-500 dark:text-blue-300 font-semibold text-4xl">
                front-end
            </h3>
            <svg class="w-4 h-4 ms-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                 viewBox="0 0 6 10">
                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M1 1l4 4-4 4"/>
            </svg>
        </a>

        <ul class="grid grid-cols-3 gap-4">
            @foreach($categories as $category)
                <li>
                    <a href="{{ route('category.show', $category->slug) }}">
                        <x-guide-card
                            :image="$category->preview_path"
                            :title="$category->name"
                            :id="$category->id"
                            :colorFrom="$category->from_color"
                            :colorTo="$category->to_color"
                        />
                    </a>
                </li>
            @endforeach
        </ul>


    </div>
</x-app-layout>
