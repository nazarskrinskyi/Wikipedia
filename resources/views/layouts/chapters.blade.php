<?php
{{-- filepath: \\wsl.localhost\Ubuntu\home\kilingfred\Wikipedia\resources\views\layouts\chapters.blade.php --}}
<!DOCTYPE html>
<html lang="en">
<head>
    <title>{{ $title ?? 'Chapter List' }}</title>
    <link rel="stylesheet" href="{{ asset('css/chapters.css') }}">
    <script src="{{ asset('js/app.js') }}"></script>
</head>
<body>
    <header>
        <h1>{{ $header ?? 'Insert Header Here' }}</h1>
    </header>
    <div class="container">
        <div class="navigation">
            <button>
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
                    <image href="{{ asset('img/list-cvg.svg') }}" x="0" y="0" width="24" height="24" />
                </svg>
            </button>
            <ul>
                <li><a href="#tags">1. Теги</a></li>
                <li><a href="#universal-attributes">2. Універсальні атрибути</a></li>
                <li><a href="{{ url('/about') }}">3. Події</a></li>
            </ul>
        </div>
        <section class="content">
            <div class="content-header">
                <svg xmlns="http://www.w3.org/2000/svg" width="200" height="200" viewBox="0 0 24 24">
                    <image href="{{ asset('img/html-5-svgrepo-com.svg') }}" x="0" y="0" width="24" height="24" />
                </svg>
                <h1>{{ $contentHeader ?? 'Довідник з HTML' }}</h1>
                <button>&lt; Front-End</button>
            </div>
            <div class="content-body">
                <section id="tags">
                    <h2>Теги</h2>
                    <ul>
                        @foreach ($chapters as $chapter)
                            <li class="chapter-content">
                                <h3>{{ $chapter['title'] }}</h3>
                                <p>{{ $chapter['description'] }}</p>
                            </li>
                        @endforeach
                    </ul>
                </section>
                <section id="universal-attributes">
                    <h2>Універсальні атрибути</h2>
                    <ul>
                        @foreach ($attributes as $attribute)
                            <li class="chapter-content">
                                <h3>{{ $attribute['title'] }}</h3>
                                <p>{{ $attribute['description'] }}</p>
                            </li>
                        @endforeach
                    </ul>
                </section>
            </div>
        </section>
    </div>
    <footer>
        <p>{{ $footer ?? 'Insert Footer Here' }}</p>
    </footer>
    <script>
        let button = document.querySelector('.navigation button');
        let ul = document.querySelector('.navigation ul');

        button.addEventListener('click', function() {
            if (ul.style.display === 'none') {
                ul.style.display = 'block';
            } else {
                ul.style.display = 'none';
            }
        });
    </script>
</body>
</html>