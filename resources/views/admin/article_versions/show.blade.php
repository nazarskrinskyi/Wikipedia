@extends('adminlte::page')

@section('title', 'Перегляд статті')

@section('content_header')
    <h1>Перегляд статті</h1>
@endsection

@section('content')
    <div class="container">
        <div class="card">
            <div class="card-header">
                <h3>{{ $version->title }}</h3>
            </div>
            <div class="card-body">
                <p><strong>ID:</strong> {{ $version->id }}</p>
                <p><strong>Назва:</strong> {{ $version->title }}</p>
                <p><strong>Slug:</strong> {{ $version->slug }}</p>
                <p><strong>Опис:</strong> {!! nl2br(e($version->description ?? 'Опис відсутній')) !!}</p>
            </div>
            <div class="card-footer text-end">
                <form action="{{ route('articles-versions.restore', $version->id) }}" method="POST" class="d-inline">
                    @csrf
                    <button class="btn btn-sm btn-success" onclick="return confirm('Ви впевнені?')">Відновити</button>
                </form>

                <a href="{{ route('articles-versions.index') }}" class="btn btn-secondary">Назад</a>
            </div>
        </div>
    </div>
@endsection
