@extends('layouts.admin')

@section('content')
<div class="container">

    <h3 class="mb-4">User Detail</h3>

    {{-- USER INFO --}}
    <div class="card mb-4">
        <div class="card-body">

            <p><strong>ID:</strong> {{ $user->id }}</p>
            <p><strong>Name:</strong> {{ $user->name }}</p>
            <p><strong>Email:</strong> {{ $user->email }}</p>
            <p><strong>Phone:</strong> {{ $user->phone ?? '-' }}</p>
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

    {{-- BOOKING HISTORY --}}
    <div class="card">
        <div class="card-header bg-primary text-white">
            <h5 class="mb-0">Booking History ({{ $user->bookings->count() }} bookings)</h5>
        </div>
        <div class="card-body">
            @if($user->bookings->count() > 0)
                <div class="table-responsive">
                    <table class="table table-bordered table-hover">
                        <thead class="table-light">
                            <tr>
                                <th>Booking ID</th>
                                <th>Movie</th>
                                <th>Showtime</th>
                                <th>Seats</th>
                                <th>Total Amount</th>
                                <th>Status</th>
                                <th>Booked At</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($user->bookings as $booking)
                                <tr>
                                    <td><strong>#{{ $booking->id }}</strong></td>
                                    <td>{{ $booking->showtime->movie->title }}</td>
                                    <td>
                                        <small>
                                            {{ \Carbon\Carbon::parse($booking->showtime->show_date)->format('d/m/Y') }}<br>
                                            <span class="text-muted">
                                                {{ \Carbon\Carbon::parse($booking->showtime->start_time)->format('H:i') }}
                                                - {{ $booking->showtime->room->name }}
                                            </span>
                                        </small>
                                    </td>
                                    <td>
                                        <small>
                                            @foreach($booking->bookingSeats as $seat)
                                                <span class="badge bg-info">{{ $seat->seat->seat_code }}</span>
                                            @endforeach
                                        </small>
                                    </td>
                                    <td><strong>{{ number_format($booking->total_amount) }} đ</strong></td>
                                    <td>
                                        @if($booking->status == 'confirmed')
                                            <span class="badge bg-success">Confirmed</span>
                                        @elseif($booking->status == 'pending')
                                            <span class="badge bg-warning text-dark">Pending</span>
                                        @else
                                            <span class="badge bg-danger">Canceled</span>
                                        @endif
                                    </td>
                                    <td>
                                        <small>{{ \Carbon\Carbon::parse($booking->created_at)->format('d/m/Y H:i') }}</small>
                                    </td>
                                    <td>
                                        <a href="{{ route('admin.bookings.show', $booking->id) }}"
                                           class="btn btn-sm btn-info">
                                            View
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="alert alert-info" role="alert">
                    <i class="bi bi-info-circle"></i> This user has no bookings yet.
                </div>
            @endif
        </div>
    </div>

</div>
@endsection
