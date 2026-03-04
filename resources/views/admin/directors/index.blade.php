@extends('layouts.admin')

@section('content')
<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3>Directors Management</h3>
        <a href="{{ route('admin.directors.create') }}" class="btn btn-primary">
            + Add Director
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
                   placeholder="Search director..." value="{{ request('keyword') }}">
            <button class="btn btn-outline-secondary" type="submit">Search</button>
        </div>
    </form>

    {{-- Directors Table --}}
    @if ($directors->count() > 0)
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
                    @foreach ($directors as $director)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td><strong>{{ $director->name }}</strong></td>
                        <td><span class="badge bg-info">{{ $director->movies()->count() }}</span></td>
                        <td>{{ $director->created_at->format('M d, Y') }}</td>
                        <td>
                            <a href="{{ route('admin.directors.edit', $director->id) }}" 
                               class="btn btn-sm btn-warning">Edit</a>
                            <form method="POST" 
                                  action="{{ route('admin.directors.destroy', $director->id) }}"
                                  style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-sm btn-danger" 
                                        onclick="return confirm('Delete this director?')">Delete</button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        {{ $directors->links() }}
    @else
        <div class="alert alert-info">No directors found</div>
    @endif
</div>
@endsection
