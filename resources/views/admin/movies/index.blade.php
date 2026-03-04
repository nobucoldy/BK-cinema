@extends('layouts.admin')

@section('content')
<div class="container-fluid">

    {{-- Tiêu đề --}}
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h3 class="mb-0">Movie Management</h3>
        <a href="{{ route('admin.movies.create') }}" class="btn btn-primary">
            + Add Movie
        </a>
    </div>

    

    {{-- Search and filter form --}}
    <form method="GET" class="row mb-4">
        <div class="col-md-4">
            <input type="text"
                   name="keyword"
                   class="form-control"
                   placeholder="Search movie title..."
                   value="{{ request('keyword') }}">
        </div>

        <div class="col-md-3">
            <select name="status" class="form-control">
                <option value="">-- All Status --</option>
                <option value="showing" {{ request('status')=='showing'?'selected':'' }}>
                    Showing
                </option>
                <option value="coming_soon" {{ request('status')=='coming_soon'?'selected':'' }}>
                    Coming Soon
                </option>
                <option value="stopped" {{ request('status')=='stopped'?'selected':'' }}>
                    Stopped
                </option>
            </select>
        </div>

        <div class="col-md-2">
            <button class="btn btn-primary w-100">
                Filter
            </button>
        </div>

        <div class="col-md-2">
            <a href="{{ route('admin.movies.index') }}" class="btn btn-secondary w-100">
                Reset
            </a>
        </div>
    </form>

    {{-- Movie list table --}}
    <div class="card">
        <div class="card-body p-0">
            <table class="table table-bordered table-hover mb-0">
                <thead class="table-dark">
                    <tr>
                        <th width="5%">STT</th>
                        <th>Title</th>
                        <th width="10%">Duration</th>
                        <th width="15%">Release Date</th>
                        <th width="12%">Status</th>
                        <th width="20%">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($movies as $movie)
                        <tr>
                            <td>
                                {{ ($movies->currentPage() - 1) * $movies->perPage() + $loop->iteration }}
                            </td>

                            <td>{{ $movie->title }}</td>
                            <td>{{ $movie->duration }} min</td>
                            <td>{{ \Carbon\Carbon::parse($movie->release_date)->format('d/m/Y') }}</td>

                            {{-- Status --}}
                            <td class="text-center">
                                @if($movie->status == 'showing')
                                    <span class="badge bg-success">Showing</span>
                                @elseif($movie->status == 'coming_soon')
                                    <span class="badge bg-warning text-dark">Coming Soon</span>
                                @else
                                    <span class="badge bg-secondary">Stopped</span>
                                @endif
                            </td>

                            {{-- Actions --}}
                            <td class="text-center">
                                
                                <a href="{{ route('admin.movies.edit', $movie->id) }}"
                                   class="btn btn-sm btn-warning">
                                    Edit
                                </a>

                                <form action="{{ route('admin.movies.destroy', $movie->id) }}"
                                      method="POST"
                                      class="d-inline"
                                      onsubmit="return confirm('Are you sure you want to delete this movie?')">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-sm btn-danger">
                                        Delete
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center py-3">
                                No movies found.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    {{-- Phân trang --}}
    <div class="mt-3">
        {{ $movies->appends(request()->query())->links('pagination::bootstrap-5') }}
    </div>

</div>
@endsection
