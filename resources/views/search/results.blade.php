@extends('layouts.app')

@section('content')
    <h1>Результати пошуку для "{{ $query }}"</h1>

    @if ($results->isEmpty())
        <p>Нічого не знайдено.</p>
    @else
        <ul>
            @foreach ($results as $article)
                <li>
                    <a href="{{ route('articles.show', $article) }}">{{ $article->title }}</a>
                </li>
            @endforeach
        </ul>
    @endif
@endsection
