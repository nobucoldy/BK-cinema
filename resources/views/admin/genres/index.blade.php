@extends('layouts.admin')

@section('content')
<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3>Genres Management</h3>
        <a href="{{ route('admin.genres.create') }}" class="btn btn-primary">
            + Add Genre
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
                   placeholder="Search genre..." value="{{ request('keyword') }}">
            <button class="btn btn-outline-secondary" type="submit">Search</button>
        </div>
    </form>

    {{-- Genres Table --}}
    @if ($genres->count() > 0)
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
                    @foreach ($genres as $genre)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td><strong>{{ $genre->name }}</strong></td>
                        <td><span class="badge bg-info">{{ $genre->movies()->count() }}</span></td>
                        <td>{{ $genre->created_at->format('M d, Y') }}</td>
                        <td>
                            <a href="{{ route('admin.genres.edit', $genre->id) }}" 
                               class="btn btn-sm btn-warning">Edit</a>
                            <form method="POST" 
                                  action="{{ route('admin.genres.destroy', $genre->id) }}"
                                  style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-sm btn-danger" 
                                        onclick="return confirm('Delete this genre?')">Delete</button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        {{ $genres->links() }}
    @else
        <div class="alert alert-info">No genres found</div>
    @endif
</div>
@endsection
