<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
        <link rel="stylesheet" href="https://cdn.ckeditor.com/ckeditor5/44.2.1/ckeditor5.css" crossorigin>

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased">
        <div class="min-h-screen bg-gray-100 dark:bg-gray-900">
            @include('layouts.navigation')

{{--            <!-- Page Heading -->--}}
{{--            @isset($header)--}}
{{--                <header class="bg-white dark:bg-gray-800 shadow">--}}
{{--                    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">--}}
{{--                        {{ $header }}--}}
{{--                    </div>--}}
{{--                </header>--}}
{{--            @endisset--}}

{{--            <!-- Page Content -->--}}
{{--            <main>--}}
{{--                {{ $slot }}--}}
{{--            </main>--}}
    <main>
        <div class="main-container">
            <div class="editor-container editor-container_classic-editor" id="editor-container">
                <div class="editor-container__editor"><div id="editor"></div></div>
            </div>
        </div>

        <form action="{{ route('search') }}" method="GET">
            <input type="text" name="q" id="search" placeholder="Пошук...">
            <select name="category_id">
                <option value="">Всі категорії</option>
                @foreach (\App\Models\Category::all() as $category)
                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                @endforeach
            </select>
            <button type="submit">🔍</button>
        </form>

        <ul id="autocomplete-results"></ul>

        <script>
            document.getElementById('search').addEventListener('input', function() {
                fetch(`/autocomplete?q=${this.value}`)
                    .then(response => response.json())
                    .then(data => {
                        let resultsList = document.getElementById('autocomplete-results');
                        resultsList.innerHTML = '';
                        data.forEach(title => {
                            let li = document.createElement('li');
                            li.textContent = title;
                            resultsList.appendChild(li);
                        });
                    });
            });
        </script>

        <!-- Load CKEditor Script -->
        <script src="https://cdn.ckeditor.com/ckeditor5/44.2.1/ckeditor5.umd.js" crossorigin></script>
    </main>
</div>
</body>
</html>
