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
            @if (isset($category))
                @method('PUT')
            @endif

            <div class="card-body">
                <div class="form-group">
                    <label for="name">Назва категорії</label>
                    <input type="text" name="name" id="name" value="{{ old('name', $category->name ?? '') }}"
                        class="form-control @error('name') is-invalid @enderror" placeholder="Введіть назву">
                    @error('name')
                        <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="slug">Slug (автоматично генерується)</label>
                    <input type="text" name="slug" id="slug" value="{{ old('slug', $category->slug ?? '') }}"
                        class="form-control @error('slug') is-invalid @enderror" placeholder="Введіть slug">
                    @error('slug')
                        <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="parent_id">Батьківська категорія</label>
                    <select name="parent_id" id="parent_id" class="form-control @error('parent_id') is-invalid @enderror">
                        <option value="">-- Без батьківської --</option>
                        @foreach ($categories as $cat)
                            <option value="{{ $cat->id }}"
                                {{ old('parent_id', $category->parent_id ?? '') == $cat->id ? 'selected' : '' }}>
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
                            class="custom-file-input @error('preview_path') is-invalid @enderror" accept="image/svg+xml">
                        <label class="custom-file-label" for="preview_path">Оберіть файл...</label>

                        @error('preview_path')
                            <span class="invalid-feedback d-block mt-1">{{ $message }}</span>
                        @enderror
                    </div>

                    @if (isset($category) && $category->preview_path)
                        <div id="current-image-wrapper" class="mt-3">
                            <p>Поточне зображення:</p>
                            <img src="{{ asset('uploads/' . $category->preview_path) }}" alt="Current Image"
                                id="preview-img"
                                style="max-width: 100%; height: auto; border: 1px solid #ccc; padding: 4px;" />
                        </div>
                    @else
                        <!-- Image preview -->
                        <div id="image-preview" class="mt-3" style="display: none;">
                            <p>Попередній перегляд:</p>
                            <img id="preview-img" src="" alt="Image Preview"
                                style="max-width: 100%; height: auto; border: 1px solid #ccc; padding: 4px;" />
                        </div>
                    @endif
                </div>

                <script>
                    document.addEventListener("DOMContentLoaded", function() {
                        const fileInput = document.getElementById('preview_path');
                        const fileLabel = document.querySelector('label[for="preview_path"]');
                        const previewContainer = document.getElementById('image-preview');
                        const previewImg = document.getElementById('preview-img');

                        fileInput.addEventListener('change', function() {
                            const file = fileInput.files[0];

                            if (file) {
                                fileLabel.textContent = file.name;

                                if (file.type.startsWith('image/')) {
                                    const reader = new FileReader();
                                    reader.onload = function(e) {
                                        previewImg.src = e.target.result;
                                        previewContainer.style.display = 'block';
                                    };
                                    reader.readAsDataURL(file);
                                } else {
                                    previewContainer.style.display = 'none';
                                    previewImg.src = '';
                                }
                            } else {
                                fileLabel.textContent = 'Оберіть файл...';
                                previewContainer.style.display = 'none';
                                previewImg.src = '';
                            }
                        });
                    });
                </script>

                <div class="form-group">
                    <label for="from_color">Колір (від)</label>
                    <div class="input-group">
                        <input type="text" name="from_color" id="from_color"
                            value="{{ old('from_color', $category->from_color ?? '#000000') }}"
                            class="form-control @error('from_color') is-invalid @enderror"
                            oninput="document.getElementById('from_color_picker').value = this.value">
                        <input type="color" name="from_color_picker" id="from_color_picker"
                            value="{{ old('from_color', $category->from_color ?? '#000000') }}"
                            class="form-control form-control-color"
                            oninput="document.getElementById('from_color').value = this.value">
                    </div>
                    @error('from_color')
                        <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="to_color">Колір (до)</label>
                    <div class="input-group">
                        <input type="text" name="to_color" id="to_color"
                            value="{{ old('to_color', $category->to_color ?? '#000000') }}"
                            class="form-control @error('to_color') is-invalid @enderror"
                            oninput="document.getElementById('to_color_picker').value = this.value">
                        <input type="color" name="to_color_picker" id="to_color_picker"
                            value="{{ old('to_color', $category->to_color ?? '#000000') }}"
                            class="form-control form-control-color"
                            oninput="document.getElementById('to_color').value = this.value">
                    </div>
                    @error('to_color')
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
        document.addEventListener("DOMContentLoaded", function() {
            const nameInput = document.getElementById("name");
            const slugInput = document.getElementById("slug");

            function transliterate(text) {
                const map = {
                    а: 'a',
                    б: 'b',
                    в: 'v',
                    г: 'g',
                    д: 'd',
                    е: 'e',
                    ё: 'e',
                    ж: 'zh',
                    з: 'z',
                    и: 'i',
                    й: 'y',
                    к: 'k',
                    л: 'l',
                    м: 'm',
                    н: 'n',
                    о: 'o',
                    п: 'p',
                    р: 'r',
                    с: 's',
                    т: 't',
                    у: 'u',
                    ф: 'f',
                    х: 'h',
                    ц: 'ts',
                    ч: 'ch',
                    ш: 'sh',
                    щ: 'shch',
                    ъ: '',
                    ы: 'y',
                    ь: '',
                    э: 'e',
                    ю: 'yu',
                    я: 'ya',
                    є: 'ye',
                    і: 'i',
                    ї: 'yi',
                    ґ: 'g'
                };

                return text.toLowerCase().split('').map(char =>
                    map[char] || char
                ).join('');
            }

            function generateSlug(text) {
                return transliterate(text)
                    .trim()
                    .replace(/[^a-z0-9\s-]/g, '')
                    .replace(/\s+/g, '-')
                    .replace(/-+/g, '-');
            }

            nameInput.addEventListener("input", function() {
                slugInput.value = generateSlug(nameInput.value);
            });
        });
        document.querySelector('.custom-file-input').addEventListener('change', function(e) {
            let fileName = document.getElementById("preview_path").files[0].name;
            let nextSibling = e.target.nextElementSibling;
            nextSibling.innerText = fileName;
        });
    </script>
@endsection
