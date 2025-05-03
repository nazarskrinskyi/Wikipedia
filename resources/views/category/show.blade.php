<x-app-layout>
    <div class="gap-6 py-12 container mx-auto max-w-7xl flex-grow">
        <x-slot name="footer">
            <x-footer />
        </x-slot>

        <ul class="grid grid-cols-3 gap-4 mb-5">
            @foreach ($category->children as $child)
                <li>
                    <a href="{{ route('category.index', $child->slug) }}">
                        <x-guide-card :image="$child->preview_path" :title="$child->name" :id="$child->id" :colorFrom="$child->from_color"
                            :colorTo="$child->to_color"></x-guide-card>
                    </a>
                </li>
            @endforeach
        </ul>
    </div>
</x-app-layout>
