@extends('adminlte::page')

@section('title', 'Категорії')

@section('content_header')
    <h1>Статті</h1>
@endsection

@section('content')
    <div class="container">
        @if($articles->count())
            <table class="table table-bordered">
                <thead>
                <tr>
                    <th>#</th>
                    <th>Назва</th>
                    <th>Slug</th>
                    <th class="text-end">Дії</th>
                </tr>
                </thead>
                <tbody>
                @foreach($articles as $article)
                    <tr>
                        <td>{{ $article->id }}</td>
                        <td>{{ $article->name }}</td>
                        <td>{{ $article->slug }}</td>
                        <td class="text-end">
                            <a href="{{ route('articles-approve.show', $article->id) }}" class="btn btn-sm btn-warning">Показати</a>
                            <form action="{{ route('articles-approve.approve', $article->id) }}" method="POST" class="d-inline">
                                @csrf
                                <button class="btn btn-sm btn-danger" onclick="return confirm('Ви впевнені?')">Апрув</button>
                            </form>
                            <form action="{{ route('articles.destroy', $article->id) }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-sm btn-danger" onclick="return confirm('Ви впевнені?')">Видалити</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>

            <div class="mt-3">
                {{ $articles->links() }}
            </div>
        @else
            <p>Статтей не знайдено.</p>
        @endif
    </div>
@endsection
