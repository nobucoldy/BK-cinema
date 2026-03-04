@extends('layouts.admin')

@section('content')
<h3 class="mb-3">Showtimes Management</h3>

{{-- Filter --}}
<form method="GET" class="row g-2 mb-3">
    <div class="col-md-4">
        <input type="text"
               name="movie"
               value="{{ request('movie') }}"
               class="form-control"
               placeholder="Search by movie title">
    </div>

    <div class="col-md-3">
        <input type="date"
               name="date"
               value="{{ request('date') }}"
               class="form-control">
    </div>

    <div class="col-md-3">
        <button class="btn btn-primary">Filter</button>
        <a href="{{ route('admin.showtimes.index') }}"
           class="btn btn-secondary">Reset</a>
    </div>

    <div class="col-md-2 text-end">
        <a href="{{ route('admin.showtimes.create') }}"
           class="btn btn-success">
            + Add Showtime
        </a>
    </div>
</form>

{{-- Table --}}
<table class="table table-bordered align-middle">
    <thead class="table-dark">
        <tr>
            <th>#</th>
            <th>Movie</th>
            <th>Room</th>
            <th>Date</th>
            <th>Time</th>
            <th width="160">Actions</th>
        </tr>
    </thead>

    <tbody>
    @forelse($showtimes as $s)
        <tr>
            <td>{{ $s->id }}</td>
            <td>{{ $s->movie->title }}</td>
            <td>{{ $s->room->name }}</td>
            <td>{{ $s->show_date->format('d/m/Y') }}</td>
            <td>
                @if($s->start_time && $s->movie->duration)
                    @php
                        $startTime = \DateTime::createFromFormat('H:i:s', $s->start_time);
                        $endTime = clone $startTime;
                        $endTime->add(new \DateInterval('PT' . $s->movie->duration . 'M'));
                    @endphp
                    {{ $startTime->format('H:i') }} ~ {{ $endTime->format('H:i') }}
                @else
                    -
                @endif
            </td>
            <td>
                <a href="{{ route('admin.showtimes.edit', $s->id) }}"
                   class="btn btn-sm btn-warning">
                    Edit
                </a>

                <form action="{{ route('admin.showtimes.destroy', $s->id) }}"
                      method="POST"
                      class="d-inline"
                      onsubmit="return confirm('Delete this showtime?')">
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
            <td colspan="6" class="text-center text-muted">
                No showtimes found
            </td>
        </tr>
    @endforelse
    </tbody>
</table>

{{-- Pagination --}}
<div class="d-flex justify-content-center">
    {{ $showtimes->links('pagination::bootstrap-5') }}
</div>
@endsection
