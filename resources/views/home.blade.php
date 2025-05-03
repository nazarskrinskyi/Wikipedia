<x-app-layout>
    <div class="gap-6 py-12 container mx-auto max-w-7xl flex-grow">
        <x-slot name="footer">
            <x-footer/>
        </x-slot>

         @if (session('success'))
            <x-pop-up message="{{ session('success') }}" />
        @endif
        @foreach($categories as $category)
            <a href="{{ route('category.show', $category->slug) }}"
               class="mb-4 text-blue-500 dark:text-blue-300 inline-flex items-center px-1 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 rounded-lg ">
                <h3 class="text-blue-500 dark:text-blue-300 font-semibold text-4xl">
                    {{ $category->name }}
                </h3>
                <svg class="w-4 h-4 ms-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                     viewBox="0 0 6 10">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M1 1l4 4-4 4"/>
                </svg>
            </a>

            <ul class="grid grid-cols-3 gap-4 mb-5">
                @foreach($category->children as $child)
                    <li>
                        <a href="{{ route('category.index', $child->slug) }}">
                            <x-guide-card
                                :image="$child->preview_path"
                                :title="$child->name"
                                :id="$child->id"
                                :colorFrom="$child->from_color"
                                :colorTo="$child->to_color"></x-guide-card>
                        </a>
                    </li>
                @endforeach
            </ul>
        @endforeach
    </div>
</x-app-layout>
