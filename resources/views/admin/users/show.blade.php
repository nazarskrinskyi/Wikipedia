@extends('adminlte::page')

@section('title', 'Edit User Role')

@section('content_header')
    <h1>Edit Role for {{ $user->name }}</h1>
@endsection

@section('content')
    @if ($errors->any())
        <div class="alert alert-danger">
            {{ $errors->first() }}
        </div>
    @endif

    <form method="POST" action="{{ route('admin.users.update', $user) }}">
        @csrf
        @method('PATCH')

        <div class="form-group">
            <label for="role">Role</label>
            <select name="role" id="role" class="form-control">
                @foreach ($roles as $role)
                    <option value="{{ $role }}" @selected($user->role === $role)>{{ ucfirst($role) }}</option>
                @endforeach
            </select>
        </div>

        <button type="submit" class="btn btn-success">Update Role</button>
        <a href="{{ route('admin.users.index') }}" class="btn btn-secondary">Back</a>
    </form>
@endsection
