@extends('adminlte::page')

@section('title', 'Версії')

@section('content_header')
    <h1>Версії</h1>
@endsection

@section('content')
    <div class="container">
        @if($versions->count())
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
                @foreach($versions as $article)
                    <tr>
                        <td>{{ $article->id }}</td>
                        <td>{{ $article->name }}</td>
                        <td>{{ $article->slug }}</td>
                        <td class="text-end">
                            <a href="{{ route('articles-versions.show', $article->id) }}" class="btn btn-sm btn-warning">Показати</a>
                            <form action="{{ route('articles-versions.restore', $article->id) }}" method="POST" class="d-inline">
                                @csrf
                                <button class="btn btn-sm btn-danger" onclick="return confirm('Ви впевнені?')">Відновити</button>
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
                {{ $versions->links() }}
            </div>
        @else
            <p>Версій не знайдено.</p>
        @endif
    </div>
@endsection
