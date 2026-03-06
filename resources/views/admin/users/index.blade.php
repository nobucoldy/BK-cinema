@extends('layouts.admin')

@section('content')
<h3>Users</h3>

<form class="row mb-3">
    <div class="col-md-4">
        <input type="text"
               name="keyword"
               class="form-control"
               placeholder="Search name or email"
               value="{{ request('keyword') }}">
    </div>

    <div class="col-md-3">
        <select name="role" class="form-control">
            <option value="">All roles</option>
            <option value="admin" {{ request('role')=='admin'?'selected':'' }}>Admin</option>
            <option value="user" {{ request('role')=='user'?'selected':'' }}>User</option>
        </select>
    </div>

    <div class="col-md-2">
        <button class="btn btn-primary">Filter</button>
    </div>

    <div class="col-md-3 text-end">
        <a href="{{ route('admin.users.create') }}" class="btn btn-success">
            Add User
        </a>
    </div>
</form>

<table class="table table-bordered">
    <tr>
        <th>ID</th>
        <th>Name</th>
        <th>Email</th>
        <th>Role</th>
        <th width="180">Action</th>
    </tr>

    @foreach($users as $u)
    <tr>
        <td>{{ $u->id }}</td>
        <td>{{ $u->name }}</td>
        <td>{{ $u->email }}</td>
        <td>{{ ucfirst($u->role) }}</td>
        <td>
            <a href="{{ route('admin.users.show',$u->id) }}" class="btn btn-info btn-sm">View</a>
            <a href="{{ route('admin.users.edit',$u->id) }}" class="btn btn-warning btn-sm">Edit</a>

            <form action="{{ route('admin.users.destroy',$u->id) }}"
                  method="POST"
                  class="d-inline">
                @csrf @method('DELETE')
                <button class="btn btn-danger btn-sm"
                        onclick="return confirm('Delete user?')">
                    Delete
                </button>
            </form>
        </td>
    </tr>
    @endforeach
</table>

{{ $users->links() }}
@endsection
