@extends('adminlte::page')

@section('title', isset($category) ? 'Редагування категорії' : 'Створення категорії')

@section('content_header')
    <h1>{{ isset($category) ? 'Редагування категорії' : 'Створення категорії' }}</h1>
@endsection

@section('content')
    <div class="card card-primary">
        <div class="card-header">
            <h3 class="card-title">{{ isset($category) ? 'Редагувати категорію' : 'Створити категорію' }}</h3>
        </div>

        <form action="{{ isset($category) ? route('categories.update', $category) : route('categories.store') }}"
              method="POST" enctype="multipart/form-data">
            @csrf
            @if(isset($category))
                @method('PUT')
            @endif

            <div class="card-body">
                <div class="form-group">
                    <label for="name">Назва категорії</label>
                    <input type="text" name="name" id="name"
                           value="{{ old('name', $category->name ?? '') }}"
                           class="form-control @error('name') is-invalid @enderror"
                           placeholder="Введіть назву">
                    @error('name')
                    <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="slug">Slug (автоматично генерується)</label>
                    <input type="text" name="slug" id="slug"
                           value="{{ old('slug', $category->slug ?? '') }}"
                           class="form-control @error('slug') is-invalid @enderror"
                           placeholder="Введіть slug">
                    @error('slug')
                    <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="parent_id">Батьківська категорія</label>
                    <select name="parent_id" id="parent_id"
                            class="form-control @error('parent_id') is-invalid @enderror">
                        <option value="">-- Без батьківської --</option>
                        @foreach($categories as $cat)
                            <option value="{{ $cat->id }}"
                                {{ (old('parent_id', $category->parent_id ?? '') == $cat->id) ? 'selected' : '' }}>
                                {{ $cat->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('parent_id')
                    <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="preview_path" class="form-label">Зображення (завантажити файл)</label>

                    <div class="custom-file">
                        <input type="file" name="preview_path" id="preview_path"
                               class="custom-file-input @error('preview_path') is-invalid @enderror">
                        <label class="custom-file-label" for="preview_path">Оберіть файл...</label>

                        @error('preview_path')
                        <span class="invalid-feedback d-block mt-1">{{ $message }}</span>
                        @enderror
                    </div>
                </div>



                <div class="form-group">
                    <label for="color">Колір</label>
                    <input type="color" name="color" id="color"
                           value="{{ old('color', $category->color ?? '#000000') }}"
                           class="form-control @error('color') is-invalid @enderror">
                    @error('color')
                    <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            <div class="card-footer text-right">
                <button type="submit" class="btn btn-primary">
                    {{ isset($category) ? 'Оновити' : 'Створити' }}
                </button>
            </div>
        </form>
    </div>
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            const nameInput = document.getElementById("name");
            const slugInput = document.getElementById("slug");

            nameInput.addEventListener("input", function () {
                slugInput.value = nameInput.value
                    .toLowerCase()
                    .trim()
                    .replace(/[^a-z0-9\s-]/g, '')
                    .replace(/\s+/g, '-')
                    .replace(/-+/g, '-');
            });
        });
        document.querySelector('.custom-file-input').addEventListener('change', function (e) {
            let fileName = document.getElementById("preview_path").files[0].name;
            let nextSibling = e.target.nextElementSibling;
            nextSibling.innerText = fileName;
        });
    </script>
@endsection


