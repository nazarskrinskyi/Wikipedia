@extends('adminlte::page')

@section('title', 'Категорії')

@section('content_header')
    <h1>Статті</h1>
@endsection

@section('content')
    @if (session('success'))
        <x-pop-up message="{{ session('success') }}" />
    @endif
    <div class="container">
        <form method="GET" action="{{ route('articles-approve.filter') }}" class="mb-4">
            <div class="row">
                <div class="col-md-4">
                    <label for="category_id">Фільтрувати за категорією:</label>
                    <select name="category_id" id="category_id" class="form-control" onchange="this.form.submit()">
                        <option value=""> Всі категорії </option>
                        @foreach($categories as $cat)
                            <option value="{{ $cat->id }}" {{ (isset($category) && $category->id == $cat->id) || (request()->get('category_id') == $cat->id) ? 'selected' : '' }}>
                                {{ $cat->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>
        </form>

        {{-- Таблиця статей --}}
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
                        <td>{{ $article->title }}</td>
                        <td>{{ $article->slug }}</td>
                        <td class="text-end">
                            <a href="{{ route('articles-approve.show', $article->id) }}" class="btn btn-sm btn-warning">Показати</a>
                            <form action="{{ route('articles-approve.approve', $article->id) }}" method="POST" class="d-inline">
                                @csrf
                                <button class="btn btn-sm btn-success" onclick="return confirm('Ви впевнені?')">Апрув</button>
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
                {{ $articles->appends(request()->query())->links() }}
            </div>
        @else
            <p>Статтей не знайдено.</p>
        @endif
    </div>
@endsection
