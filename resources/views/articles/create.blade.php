@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Додати статтю</h1>

        <form action="{{ route('articles.store') }}" method="POST">
            @csrf
            <div class="mb-3">
                <label for="title" class="form-label">Заголовок</label>
                <input type="text" class="form-control" id="title" name="title" required>
            </div>
            <div class="mb-3">
                <label for="content" class="form-label">Текст</label>
                <textarea class="form-control" id="content" name="content" rows="5" required></textarea>
            </div>
            <div class="mb-3">
                <label for="category_id" class="form-label">Категорія</label>
                <select class="form-control" id="category_id" name="category_id">
                    <option value="">Без категорії</option>
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                    @endforeach
                </select>
            </div>
            <button type="submit" class="btn btn-primary">Зберегти</button>
        </form>
    </div>
@endsection
