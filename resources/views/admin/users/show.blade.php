@extends('layouts.admin')

@section('content')
<div class="container">

    <h3 class="mb-4">👤 User Detail</h3>

    <div class="card">
        <div class="card-body">

            <p><strong>ID:</strong> {{ $user->id }}</p>
            <p><strong>Name:</strong> {{ $user->name }}</p>
            <p><strong>Email:</strong> {{ $user->email }}</p>
            <p><strong>Phone:</strong> {{ $user->phone ?? '-' }}</p> {{-- Add this line --}}
            <p>
                <strong>Role:</strong>
                <span class="badge bg-{{ $user->role=='admin' ? 'danger' : 'secondary' }}">
                    {{ ucfirst($user->role) }}
                </span>
            </p>
            <p><strong>Created at:</strong> {{ $user->created_at->format('d/m/Y H:i') }}</p>

            <a href="{{ route('admin.users.edit', $user->id) }}"
               class="btn btn-warning">
                Edit
            </a>

            <a href="{{ route('admin.users.index') }}"
               class="btn btn-secondary">
                Back
            </a>

        </div>
    </div>

</div>
@endsection
