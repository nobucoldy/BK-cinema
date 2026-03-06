@extends('layouts.admin')

@section('content')
<div class="container">

    <h3 class="mb-4">✏️ Edit User</h3>

    {{-- Error --}}
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST"
          action="{{ route('admin.users.update', $user->id) }}">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label class="form-label">Name</label>
            <input type="text"
                   name="name"
                   class="form-control"
                   value="{{ old('name', $user->name) }}"
                   required>
        </div>

        <div class="mb-3">
            <label class="form-label">Email</label>
            <input type="email"
                   name="email"
                   class="form-control"
                   value="{{ old('email', $user->email) }}"
                   required>
        </div>

        <div class="mb-3">
            <label class="form-label">Phone</label>
            <input type="text"
                name="phone"
                class="form-control"
                value="{{ old('phone', $user->phone) }}"
                placeholder="VD: 0987654321">
        </div>

        <div class="mb-3">
            <label class="form-label">Role</label>
            <select name="role" class="form-control" required>
                <option value="user" {{ $user->role=='user'?'selected':'' }}>
                    User
                </option>
                <option value="admin" {{ $user->role=='admin'?'selected':'' }}>
                    Admin
                </option>
            </select>
        </div>

        <div class="d-flex gap-2">
            <button class="btn btn-primary">Update</button>
            <a href="{{ route('admin.users.index') }}" class="btn btn-secondary">
                Back
            </a>
        </div>

    </form>
</div>
@endsection
