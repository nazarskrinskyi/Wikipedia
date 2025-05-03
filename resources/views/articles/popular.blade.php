<x-app-layout>

<h1>Популярні статті</h1>

    <ul>
        @foreach ($articles as $article)
            <li>
                <a href="{{ route('articles.show', $article) }}">{{ $article->title }}</a>
                - Перегляди: {{ $article->views_count }}
                - Лайки: {{ $article->likes_count }}
            </li>
        @endforeach
    </ul>
</x-app-layout>
