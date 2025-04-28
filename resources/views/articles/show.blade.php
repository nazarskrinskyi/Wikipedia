<?php
$dom = new DOMDocument();
libxml_use_internal_errors(true);
$dom->loadHTML('<?xml encoding="utf-8" ?>' . $article->content);

$aTags = $dom->getElementsByTagName('a');

$headings = [];
foreach ($aTags as $a) {
    $id = $a->getAttribute('id');
    $text = trim($a->textContent);

    if ($id && $text === '') {
        $headings[] = ['id' => $id,];
    }
}

$updatedContent = $dom->saveHTML($dom->getElementsByTagName('body')->item(0));
$updatedContent = preg_replace('~^<body>|</body>$~', '', $updatedContent);
?>

<x-app-layout>

    <div class="gap-6 py-12 container mx-auto max-w-7xl flex flex-grow relative ">
        <x-slot name="footer">
            <x-footer />
        </x-slot>

        <aside class='max-w-xl w-1/4 sticky top-[5rem] max-h-[calc(100vh-20rem)]'>

            <button class='bg-gray-100 dark:bg-gray-800 p-2 rounded-lg cursor-default'>
                <div class="relative overflow-hidden">

                    <div class="rounded-sm absolute inset-0  transition-opacity duration-300 opacity-100 group-hover:opacity-0"
                        style="background: linear-gradient(to top right, {{ $parentCategory->from_color }}, {{ $parentCategory->to_color }});">
                    </div>

                    <div class="relative z-10">
                        <img class="w-5 h-5" src="{{ asset('uploads/' . $parentCategory->preview_path) }}"
                            alt="{{ $parentCategory->name }}">
                    </div>

                </div>
            </button>
            <ul
                class='mt-4 ml-2 text-gray-600 dark:text-gray-400  max-h-[calc(100vh-23rem)] overflow-y-auto scrollbar-dark'>
                @foreach ($parentCategory->children as $child)
                    <li class='mb-2'>
                        <span>{{ $child->name }}</span>
                        @if ($child->articles->count() > 0)
                            <ol class='mt-2 pl-8 list-disc'>
                                @foreach ($child->articles as $currentArticle)
                                    <li
                                        class='hover:text-sky-500 {{ $currentArticle->id == $article->id ? 'text-sky-500 font-semibold' : '' }}'>
                                        <a href="{{ route('article.show', $currentArticle->slug) }}" class="aside-link">
                                            <span>{{ $currentArticle->title }}</span>
                                        </a>
                                    </li>
                                @endforeach
                            </ol>
                        @endif
                    </li>
                @endforeach
            </ul>
        </aside>

        <div class='max-w-5xl w-full'>
            <h2 id='{{ $article->slug }}' class="relative mb-2 text-4xl tracking-tight text-gray-900 dark:text-white">
                {{ $article->title }}
            </h2>
            <div class='text-black dark:text-white ck-content'>
                {!! $updatedContent !!}
            </div>
        </div>

        <aside class='max-w-xl w-1/4 sticky top-[5rem] max-h-[calc(100vh-20rem)]'>

            <button class='bg-gray-100 dark:bg-gray-800 p-2 rounded-lg cursor-default'>
                {!! file_get_contents(public_path('images/toggle.svg')) !!}
            </button>
            <ul
                class='mt-4 ml-2 space-y-2 text-gray-600 dark:text-gray-400 max-h-[calc(100vh-23rem)] overflow-y-auto scrollbar-dark'>
                @foreach ($headings as $heading)
                    <li class='hover:text-sky-500'>
                        <a href="#{{ $heading['id'] }}" class="aside-link">
                            <span>{{ $loop->iteration }}.</span>
                            <span>{{ $heading['id'] }}</span>
                        </a>
                    </li>
                @endforeach
            </ul>
        </aside>
    </div>
    <link rel="stylesheet" href="https://cdn.ckeditor.com/ckeditor5/44.2.1/ckeditor5.css" crossorigin>
</x-app-layout>
<script>
    document.addEventListener("DOMContentLoaded", function() {
        const sections = document.querySelectorAll("li[id]");
        const navLinks = document.querySelectorAll(".aside-link");


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


{{--
    <h2>Обговорення</h2>
@foreach ($article->comments as $comment)
    <div class="comment">
        <p><strong>{{ $comment->user->name }}</strong> ({{ $comment->created_at->diffForHumans() }})</p>
        <p>{{ $comment->content }}</p>

        @can('update-comment', $comment)
            <form action="{{ route('comments.update', $comment) }}" method="POST">
                @csrf
                @method('PATCH')
                <input type="text" name="content" value="{{ $comment->content }}">
                <button type="submit">Редагувати</button>
            </form>
        @endcan

        @can('delete-comment', $comment)
            <form action="{{ route('comments.destroy', $comment) }}" method="POST">
                @csrf
                @method('DELETE')
                <button type="submit">Видалити</button>
            </form>
        @endcan
    </div>
@endforeach

@auth
    <h3>Додати коментар</h3>
    <form action="{{ route('comments.store', $article) }}" method="POST">
        @csrf
        <textarea name="content" required></textarea>
        <button type="submit">Коментувати</button>
    </form>
@else
    <p>Щоб залишати коментарі, <a href="{{ route('login') }}">увійдіть</a>.</p>
@endauth


<p>Перегляди: {{ $article->views()->count() }}</p>

<p>Лайки: {{ $article->likes()->where('is_like', true)->count() }}</p>
<p>Дизлайки: {{ $article->likes()->where('is_like', false)->count() }}</p>

@auth
    <form action="{{ route('articles.like', $article) }}" method="POST" style="display:inline;">
        @csrf
        <button type="submit">👍</button>
    </form>

    <form action="{{ route('articles.dislike', $article) }}" method="POST" style="display:inline;">
        @csrf
        <button type="submit">👎</button>
    </form>
@endauth --}}
