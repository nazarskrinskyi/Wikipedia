@extends('layouts.app')

@section('content')
    <a href="{{ route('articles.versions', $article) }}" class="btn btn-secondary btn-sm">Історія</a>

    <div class="container">
        <h1>Історія змін статті: {{ $article->title }}</h1>
        <a href="{{ route('articles.index') }}" class="btn btn-secondary">Назад</a>

        <table class="table table-bordered mt-3">
            <thead>
            <tr>
                <th>Заголовок</th>
                <th>Дата створення</th>
                <th>Дії</th>
            </tr>
            </thead>
            <tbody>
            @foreach($versions as $version)
                <tr>
                    <td>{{ $version->title }}</td>
                    <td>{{ $version->created_at }}</td>
                    <td>
                        <form action="{{ route('articles.versions.restore', ['article' => $article, 'version' => $version]) }}" method="POST">
                            @csrf
                            <button type="submit" class="btn btn-warning btn-sm" onclick="return confirm('Відкотити до цієї версії?')">Відкотити</button>
                        </form>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
@endsection
