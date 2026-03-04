@extends('layouts.admin')

@section('content')
<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3>Actors Management</h3>
        <a href="{{ route('admin.actors.create') }}" class="btn btn-primary">
            + Add Actor
        </a>
    </div>

    {{-- Success message --}}
    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show">
            {{ session('success') }}
            <button class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    {{-- Error message --}}
    @if (session('error'))
        <div class="alert alert-danger alert-dismissible fade show">
            {{ session('error') }}
            <button class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    {{-- Search --}}
    <form method="GET" class="mb-3">
        <div class="input-group">
            <input type="text" name="keyword" class="form-control" 
                   placeholder="Search actor..." value="{{ request('keyword') }}">
            <button class="btn btn-outline-secondary" type="submit">Search</button>
        </div>
    </form>

    {{-- Actors Table --}}
    @if ($actors->count() > 0)
        <div class="table-responsive">
            <table class="table table-hover">
                <thead class="table-dark">
                    <tr>
                        <th>#</th>
                        <th>Name</th>
                        <th>Movies Count</th>
                        <th>Created</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($actors as $actor)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td><strong>{{ $actor->name }}</strong></td>
                        <td><span class="badge bg-info">{{ $actor->movies()->count() }}</span></td>
                        <td>{{ $actor->created_at->format('M d, Y') }}</td>
                        <td>
                            <a href="{{ route('admin.actors.edit', $actor->id) }}" 
                               class="btn btn-sm btn-warning">Edit</a>
                            <form method="POST" 
                                  action="{{ route('admin.actors.destroy', $actor->id) }}"
                                  style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-sm btn-danger" 
                                        onclick="return confirm('Delete this actor?')">Delete</button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        {{ $actors->links() }}
    @else
        <div class="alert alert-info">No actors found</div>
    @endif
</div>
@endsection
