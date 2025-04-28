@extends('adminlte::page')

@section('title', 'Версії')

@section('content_header')
    <h1>Версії</h1>
@endsection

@section('content')
    @if (session('success'))
        <x-pop-up message="{{ session('success') }}" />
    @endif
    <div class="container">
        <form method="GET" action="{{ route('articles-versions.filter') }}" class="mb-4">
            <div class="row">
                <div class="col-md-6">
                    <input type="text" name="search" value="{{ $search ?? '' }}" class="form-control" placeholder="Пошук за назвою статті...">
                </div>
                <div class="col-md-2">
                    <button class="btn btn-primary" type="submit">Пошук</button>
                </div>
            </div>
        </form>

        @if(isset($versions) && $versions->count())
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
                        <td>{{ $article->title }}</td>
                        <td>{{ $article->slug }}</td>
                        <td class="text-end">
                            <a href="{{ route('articles-versions.show', $article->id) }}" class="btn btn-sm btn-warning">Показати</a>
                            <form action="{{ route('articles-versions.restore', $article->id) }}" method="POST" class="d-inline">
                                @csrf
                                <button class="btn btn-sm btn-success" onclick="return confirm('Ви впевнені?')">Відновити</button>
                            </form>
                            <form action="{{ route('articles-versions.destroy', $article->id) }}" method="POST" class="d-inline">
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
                {{ $versions->appends(['search' => $search ?? ''])->links('pagination::bootstrap-5') }}
            </div>
        @else
            <p>Версій не знайдено.</p>
        @endif
    </div>
@endsection
