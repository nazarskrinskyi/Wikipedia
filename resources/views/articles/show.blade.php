<h2>Обговорення</h2>

@foreach($article->comments as $comment)
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
@endauth
