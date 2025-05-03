@extends('adminlte::page')

@section('title', 'Перегляд статті')

@section('content_header')
    <h1>Перегляд статті</h1>
@endsection

@section('content')
    <div class="container">
        <div class="card">
            <div class="card-header">
                <h3>{{ $article->title }}</h3>
            </div>
            <div class="card-body">
                <p><strong>ID:</strong> {{ $article->id }}</p>
                <p><strong>Назва:</strong> {{ $article->title }}</p>
                <p><strong>Slug:</strong> {{ $article->slug }}</p>
                <p><strong>Опис:</strong> {!! nl2br(e($article->description ?? 'Опис відсутній')) !!}</p>
            </div>
            <div class="card-footer text-end">
                <a href="{{ route('articles-approve.approve', $article->id) }}"
                   onclick="event.preventDefault(); if(confirm('Ви впевнені?')) document.getElementById('approve-form').submit();"
                   class="btn btn-success">
                    Апрув
                </a>

                <form id="approve-form" action="{{ route('articles-approve.approve', $article->id) }}" method="POST" style="display: none;">
                    @csrf
                </form>

                <a href="{{ route('articles-approve.index') }}" class="btn btn-secondary">Назад</a>
            </div>
        </div>
    </div>
@endsection
