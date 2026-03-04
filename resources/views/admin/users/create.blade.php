@extends('layouts.admin')

@section('content')
<h3>Add User</h3>

<form method="POST" action="{{ route('admin.users.store') }}">
    @csrf
    @if ($errors->any())
    <div class="alert alert-danger">
        <ul class="mb-0">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
    <div class="mb-3">
        <label>Name</label>
        <input type="text" name="name" class="form-control" required>
    </div>

    <div class="mb-3">
        <label>Email</label>
        <input type="email" name="email" class="form-control" required>
    </div>

    <div class="mb-3">
        <label>Phone</label>
        <input type="text"
            name="phone"
            class="form-control"
            placeholder="VD: 0987654321">
    </div>


    <div class="mb-3">
        <label>Password</label>
        <input type="password" name="password" class="form-control" required>
    </div>

    <div class="mb-3">
        <label>Role</label>
        <select name="role" class="form-control">
            <option value="user">User</option>
            <option value="admin">Admin</option>
        </select>
    </div>

    <button class="btn btn-success">Create</button>
    <a href="{{ route('admin.users.index') }}" class="btn btn-secondary">Back</a>
</form>
@endsection
