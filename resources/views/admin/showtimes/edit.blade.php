@extends('layouts.admin')

@section('content')
<div class="container">

    <h3 class="mb-3">Edit Showtime</h3>

    {{-- Error --}}
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST"
          action="{{ route('admin.showtimes.update', $showtime->id) }}">
        @csrf
        @method('PUT')

        {{-- Movie --}}
        <div class="mb-3">
            <label class="form-label">Movie</label>
            <select name="movie_id" id="movieSelect" class="form-control" required>
                @foreach($movies as $movie)
                    <option value="{{ $movie->id }}"
                            data-duration="{{ $movie->duration }}"
                            {{ old('movie_id', $showtime->movie_id) == $movie->id ? 'selected' : '' }}>
                        {{ $movie->title }} ({{ $movie->duration }} min)
                    </option>
                @endforeach
            </select>
        </div>

        {{-- Room --}}
        <div class="mb-3">
            <label class="form-label">Room</label>
            <select name="room_id" class="form-control" required>
                @foreach($rooms as $room)
                    <option value="{{ $room->id }}"
                        {{ old('room_id', $showtime->room_id) == $room->id ? 'selected' : '' }}>
                        {{ $room->name }}
                    </option>
                @endforeach
            </select>
        </div>

        {{-- Screening Type --}}
        <div class="mb-3">
            <label class="form-label">Screening Type</label>
            <select name="screening_type_id" class="form-control" required>
                @foreach($screeningTypes as $type)
                    <option value="{{ $type->id }}" {{ old('screening_type_id', $showtime->screening_type_id) == $type->id ? 'selected' : '' }}>
                        {{ $type->label }}
                    </option>
                @endforeach
            </select>
        </div>

        {{-- Date & Time --}}
        <div class="row">
            <div class="col-md-4 mb-3">
                <label class="form-label">Show Date</label>
                <input type="date" name="show_date"
                       class="form-control"
                       value="{{ old('show_date', $showtime->show_date) }}" required>
            </div>

            <div class="col-md-4 mb-3">
                <label class="form-label">Start Time</label>
                <input type="time" name="start_time"
                       id="startTime"
                       class="form-control"
                       value="{{ old('start_time', $showtime->start_time) }}" required>
            </div>

            <div class="col-md-4 mb-3">
                <label class="form-label">End Time</label>
                <input type="time" name="end_time"
                       id="endTime"
                       class="form-control"
                       value="{{ old('end_time', $showtime->end_time) }}" required>
            </div>
        </div>

        <button class="btn btn-warning">Update Showtime</button>
        <a href="{{ route('admin.showtimes.index') }}" class="btn btn-secondary">
            Back
        </a>
    </form>
</div>

{{-- AUTO END TIME SCRIPT --}}
<script>
function calculateEndTime() {
    const movieSelect = document.getElementById('movieSelect');
    const startTime = document.getElementById('startTime');
    const endTime = document.getElementById('endTime');

    if (!movieSelect.value || !startTime.value) return;

    const duration = parseInt(
        movieSelect.options[movieSelect.selectedIndex].dataset.duration
    );

    if (isNaN(duration)) return;

    const [h, m] = startTime.value.split(':').map(Number);
    let totalMinutes = h * 60 + m + duration;

    totalMinutes %= 1440;

    const endH = String(Math.floor(totalMinutes / 60)).padStart(2, '0');
    const endM = String(totalMinutes % 60).padStart(2, '0');

    endTime.value = `${endH}:${endM}`;
}

document.getElementById('movieSelect').addEventListener('change', calculateEndTime);
document.getElementById('startTime').addEventListener('change', calculateEndTime);
</script>
@endsection
