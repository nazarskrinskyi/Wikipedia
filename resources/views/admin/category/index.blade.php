@extends('adminlte::page')

@section('title', 'Категорії')

@section('content_header')
    <h1>Категорії</h1>
@endsection

@section('content')
    <div class="container">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <a href="{{ route('categories.create') }}" class="btn btn-primary">Створити категорію</a>
        </div>

        @if($categories->count())
            <table class="table table-bordered">
                <thead>
                <tr>
                    <th>#</th>
                    <th>Назва</th>
                    <th>Slug</th>
                    <th>Батьківська категорія</th>
                    <th>Дочірні категорії</th>
                    <th class="text-end">Дії</th>
                </tr>
                </thead>
                <tbody>
                @foreach($categories as $category)
                    <tr>
                        <td>{{ $category->id }}</td>
                        <td>{{ $category->name }}</td>
                        <td>{{ $category->slug }}</td>
                        <td>{{ $category->parent?->name ?? '—' }}</td>
                        <td>
                            @foreach($category->children as $child)
                                <span class="badge badge-info">{{ $child->name }}</span>
                            @endforeach
                        </td>
                        <td class="text-end">
                            <a href="{{ route('categories.edit', $category->id) }}" class="btn btn-sm btn-warning">Редагувати</a>
                            <form action="{{ route('categories.destroy', $category->id) }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-sm btn-danger" onclick="return confirm('Ви впевнені?')">Видалити</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>

            <!-- Pagination Links -->
            <div class="mt-3">
                {{ $categories->links() }}
            </div>
        @else
            <p>Категорій не знайдено.</p>
        @endif
    </div>
@endsection
