<x-app-layout>
    <div class="gap-6 py-12 container mx-auto max-w-7xl flex flex-grow relative ">
        <x-slot name="footer">
            <x-footer />
        </x-slot>


        <aside class='max-w-xl w-1/4'>
            <div class='sticky top-[5rem]'>
                <button class='bg-gray-100 dark:bg-gray-800 p-2 rounded-lg'>
                    {!! file_get_contents(public_path('images/toggle.svg')) !!}
                </button>
                <ul class='mt-4 ml-2 space-y-2 text-gray-400 dark:text-gray-600'>
                    @foreach ($category->children as $child)
                        <li class='hover:text-sky-500'>
                            <a href="#{{ $child->slug }}" class="aside-link">
                                <span>{{ $loop->iteration }}.</span>
                                <span>{{ $child->name }}</span>
                            </a>
                        </li>
                    @endforeach
                </ul>
            </div>
        </aside>

        <div class='max-w-5xl w-full'>

            <div class="relative overflow-hidden inline-block">

                <div class="rounded-lg absolute inset-0  transition-opacity duration-300 opacity-100 group-hover:opacity-0"
                    style="background: linear-gradient(to top right, {{ $category->from_color }}, {{ $category->to_color }});">
                </div>

                <div
                    class="absolute inset-0 border-2 border-transparent group-hover:border-white group-hover:border-opacity-25 transition-all duration-300 rounded-lg pointer-events-none">
                </div>

                <div class="relative z-10">
                    <img class="w-16 h-16" src="{{ asset('uploads/' . $category->preview_path) }}"
                        alt="{{ $category->name }}">
                </div>

            </div>

            <h5 class="relative mb-2 text-4xl tracking-tight text-gray-900 dark:text-white">{{ $category->name }}</h5>

            <ul>
                @foreach ($category->children as $child)
                    <li class='mt-8' id="{{ $child->slug }}">
                        <h6 class="relative mb-4 text-2xl tracking-tight text-gray-900 dark:text-white">
                            {{ $child->name }}</h6>
                        <ul>
                            @foreach ($child->articles as $article)
                                <li class='mb-4 bg-gray-100 dark:bg-gray-800 p-2 rounded-lg'>
                                    <h7 class="relative mb-2 text-lg text-sky-500 font-semibold">
                                        {{ $article->title }}
                                    </h7>
                                    <p class='text-md text-gray-900 dark:text-white'>
                                        {!! htmlspecialchars($article?->description) !!}
                                    </p>
                                </li>
                            @endforeach
                        </ul>
                    </li>
                @endforeach
            </ul>
        </div>

    </div>
</x-app-layout>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        const sections = document.querySelectorAll("li[id]");
        const navLinks = document.querySelectorAll(".aside-link");

        console.log(sections[0].offsetTop);

        function activateLink() {
            let index = sections.length;

            while (--index >= 0 && window.scrollY + 100 < sections[index].offsetTop) {}

            navLinks.forEach((link) => link.classList.remove("text-sky-500", "font-semibold"));
            if (navLinks[index]) {
                navLinks[index].classList.add("text-sky-500", "font-semibold");
            }
        }

        activateLink();
        window.addEventListener("scroll", activateLink);
    });
</script>
