@extends('layouts.admin')

@section('content')
<div class="container">

    <h3 class="mb-4">📄 Booking Detail</h3>

    <div class="card">
        <div class="card-body">

            <div class="row mb-3">
                <div class="col-md-6">
                    <h5>User Information</h5>
                    <p><strong>Name:</strong> {{ $booking->user->name }}</p>
                    <p><strong>Email:</strong> {{ $booking->user->email }}</p>
                </div>

                <div class="col-md-6">
                    <h5>Booking Information</h5>
                    <p><strong>Status:</strong>
                        <span class="badge bg-{{ $booking->status == 'confirmed' ? 'success' : 'danger' }}">
                            {{ ucfirst($booking->status) }}
                        </span>
                    </p>
                    <p><strong>Total Amount:</strong>
                        {{ number_format($booking->total_amount) }} đ
                    </p>
                </div>
            </div>

            <hr>

            <div class="row mb-3">
                <div class="col-md-6">
                    <h5>Movie & Showtime</h5>
                    <p><strong>Movie:</strong> {{ $booking->showtime->movie->title }}</p>
                    <p><strong>Date:</strong> {{ \Carbon\Carbon::parse($booking->showtime->show_date)->format('d M Y') }}</p>
<p><strong>Time:</strong> {{ \Carbon\Carbon::parse($booking->showtime->start_time)->format('H:i') }}</p>
                    <p><strong>Room:</strong> {{ $booking->showtime->room->name }}</p>
                </div>

                <div class="col-md-6">
                    <h5>System Info</h5>
                    <p><strong>Booking ID:</strong> {{ $booking->id }}</p>
                    <p><strong>Created At:</strong> {{ \Carbon\Carbon::parse($booking->created_at)->format('d M Y H:i') }}</p>

                </div>
            </div>

            <div class="d-flex gap-2">
                <a href="{{ route('admin.bookings.index') }}"
                   class="btn btn-secondary">
                    Back
                </a>

                @if($booking->status == 'confirmed')
                    <form action="{{ route('admin.bookings.cancel', $booking->id) }}"
                          method="POST"
                          onsubmit="return confirm('Cancel this booking?')">
                        @csrf
                       
                        <button class="btn btn-danger">
                            Cancel Booking
                        </button>
                    </form>
                @endif
            </div>

        </div>
    </div>

</div>
@endsection
