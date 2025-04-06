@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Редагувати статтю</h1>

        <form action="{{ route('articles.update', $article) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="mb-3">
                <label for="title" class="form-label">Заголовок</label>
                <input type="text" class="form-control" id="title" name="title" value="{{ $article->title }}" required>
            </div>
            <div class="mb-3">
                <label for="content" class="form-label">Текст</label>
                <textarea class="form-control" id="content" name="content" rows="5" required>{{ $article->content }}</textarea>
            </div>
            <div class="mb-3">
                <label for="category_id" class="form-label">Категорія</label>
                <select class="form-control" id="category_id" name="category_id">
                    <option value="">Без категорії</option>
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}" {{ $article->category_id == $category->id ? 'selected' : '' }}>
                            {{ $category->name }}
                        </option>
                    @endforeach
                </select>
            </div>
            <button type="submit" class="btn btn-primary">Оновити</button>
        </form>
    </div>
@endsection
