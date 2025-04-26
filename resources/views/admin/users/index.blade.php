@extends('adminlte::page')

@section('title', 'Users')

@section('content_header')
    <h1>Users</h1>
@endsection

@section('content')
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <form method="GET" class="mb-3">
        <div class="input-group">
            <input type="text" name="name" value="{{ request('name') }}" class="form-control" placeholder="Search by name...">
            <div class="input-group-append">
                <button class="btn btn-primary">Search</button>
            </div>
        </div>
    </form>

    <table class="table table-bordered table-striped">
        <thead>
        <tr>
            <th>Name</th>
            <th>Email</th>
            <th>Role</th>
            <th>Created At</th>
            <th></th>
        </tr>
        </thead>
        <tbody>
        @forelse ($users as $user)
            <tr>
                <td>{{ $user->name }}</td>
                <td>{{ $user->email }}</td>
                <td>{{ ucfirst($user->role) }}</td>
                <td>{{ $user->created_at->format('Y-m-d') }}</td>
                <td>
                    <a href="{{ route('admin.users.show', $user) }}" class="btn btn-sm btn-info">Manage Role</a>
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="5">No users found.</td>
            </tr>
        @endforelse
        </tbody>
    </table>

    {{ $users->links() }}
@endsection
