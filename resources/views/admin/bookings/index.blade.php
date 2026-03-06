@extends('layouts.admin')

@section('content')
<div class="container-fluid">

    <h3 class="mb-3">Bookings Management</h3>

    {{-- FILTER --}}
    <form method="GET" class="row g-2 mb-3">
        <div class="col-md-3">
            <input type="text"
                   name="keyword"
                   class="form-control"
                   placeholder="Search user / movie"
                   value="{{ request('keyword') }}">
        </div>

        <div class="col-md-3">
            <select name="status" class="form-control">
                <option value="">-- All Status --</option>

                <option value="pending"
                    {{ request('status')=='pending'?'selected':'' }}>
                    Pending
                </option>

                <option value="confirmed"
                    {{ request('status')=='confirmed'?'selected':'' }}>
                    Confirmed
                </option>

                <option value="cancelled"
                    {{ request('status')=='cancelled'?'selected':'' }}>
                    Cancelled
                </option>
            </select>
        </div>

        <div class="col-md-3">
            <button class="btn btn-primary">Filter</button>
            <a href="{{ route('admin.bookings.index') }}"
               class="btn btn-secondary">
                Reset
            </a>
        </div>
    </form>

    {{-- TABLE --}}
    <div class="card">
        <div class="card-body p-0">
            <table class="table table-bordered table-hover align-middle mb-0">
                <thead class="table-dark">
                    <tr>
                        <th width="5%">STT</th>
                        <th>User</th>
                        <th>Movie</th>
                        <th>Showtime</th>
                        <th>Total</th>
                        <th>Status</th>
                        <th width="160">Action</th>
                    </tr>
                </thead>

                <tbody>
                @forelse($bookings as $b)
                    <tr>
                        {{-- STT --}}
                        <td>
                            {{ ($bookings->currentPage() - 1) * $bookings->perPage() + $loop->iteration }}
                        </td>

                        <td>{{ $b->user->name }}</td>

                        <td>{{ $b->showtime->movie->title }}</td>

                        <td>
    {{ \Carbon\Carbon::parse($b->showtime->show_date)->format('d M Y') }} <br>
    <small class="text-muted">
        {{ \Carbon\Carbon::parse($b->showtime->start_time)->format('H:i') }}
    </small>
</td>

                        <td>{{ number_format($b->total_amount) }} đ</td>

                        {{-- STATUS --}}
                        <td>
                            @if($b->status == 'confirmed')
                                <span class="badge bg-success">Confirmed</span>
                            @elseif($b->status == 'pending')
                                <span class="badge bg-warning text-dark">Pending</span>
                            @else
                                <span class="badge bg-danger">Cancelled</span>
                            @endif
                        </td>

                        {{-- ACTION --}}
                        <td class="text-center">
                            <a href="{{ route('admin.bookings.show', $b->id) }}"
                               class="btn btn-sm btn-info">
                                View
                            </a>

                            @if(in_array($b->status, ['pending', 'confirmed']))
                                <form action="{{ route('admin.bookings.cancel', $b->id) }}"
                                      method="POST"
                                      class="d-inline"
                                      onsubmit="return confirm('Cancel this booking?')">
                                    @csrf
                                    
                                    <button class="btn btn-sm btn-danger">
                                        Cancel
                                    </button>
                                </form>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7"
                            class="text-center text-muted py-3">
                            No bookings found
                        </td>
                    </tr>
                @endforelse
                </tbody>
            </table>
        </div>
    </div>

    {{-- PAGINATION --}}
    <div class="mt-3 d-flex justify-content-center">
        {{ $bookings->appends(request()->query())->links('pagination::bootstrap-5') }}
    </div>

</div>
@endsection
