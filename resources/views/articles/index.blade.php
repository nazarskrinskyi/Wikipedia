@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Статті</h1>
        <a href="{{ route('articles.create') }}" class="btn btn-primary mb-3">Додати статтю</a>

        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <table class="table table-bordered">
            <thead>
            <tr>
                <th>Заголовок</th>
                <th>Категорія</th>
                <th>Дії</th>
                <th>Статус</th>
            </tr>
            </thead>
            <tbody>
            @foreach($articles as $article)
                <tr>
                    <td>{{ $article->title }}</td>
                    <td>{{ $article->category->name ?? 'Без категорії' }}</td>
                    <td>
                        <a href="{{ route('articles.show', $article) }}" class="btn btn-info btn-sm">Переглянути</a>
                        <a href="{{ route('articles.edit', $article) }}" class="btn btn-warning btn-sm">Редагувати</a>
                        <form action="{{ route('articles.destroy', $article) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Видалити статтю?')">Видалити</button>
                        </form>
                    </td>
                    <td>
                        @can('approve-articles')
                            <form action="{{ route('articles.approve', $article) }}" method="POST" style="display:inline;">
                                @csrf
                                <button type="submit" class="btn btn-success btn-sm">Схвалити</button>
                            </form>
                        @endcan
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>

        {{ $articles->links() }}
    </div>
@endsection
