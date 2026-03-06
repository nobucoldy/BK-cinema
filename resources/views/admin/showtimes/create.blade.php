@extends('layouts.admin')

@section('content')
<div class="container">

    <h3 class="mb-3">Add Showtime</h3>

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

    <form method="POST" action="{{ route('admin.showtimes.store') }}">
        @csrf

        {{-- Theater (Select first) --}}
        <div class="mb-3">
            <label class="form-label">Theater</label>
            <select name="theater_id" id="theaterSelect" class="form-control" required>
                <option value="">-- Select theater --</option>
                @foreach($theaters as $theater)
                    <option value="{{ $theater->id }}"
                            {{ old('theater_id') == $theater->id ? 'selected' : '' }}>
                        {{ $theater->name }}
                    </option>
                @endforeach
            </select>
        </div>

        {{-- Movie --}}
        <div class="mb-3">
            <label class="form-label">Movie</label>
            <select name="movie_id" id="movieSelect" class="form-control" required>
                <option value="">-- Select movie --</option>
                @foreach($movies as $movie)
                    <option value="{{ $movie->id }}"
                            data-duration="{{ $movie->duration }}"
                            {{ old('movie_id') == $movie->id ? 'selected' : '' }}>
                        {{ $movie->title }} ({{ $movie->duration }} min)
                    </option>
                @endforeach
            </select>
        </div>

        {{-- Room (Filtered by Theater) --}}
        <div class="mb-3">
            <label class="form-label">Room</label>
            <select name="room_id" id="roomSelect" class="form-control" required disabled>
                <option value="">-- Select theater first --</option>
            </select>
        </div>

        {{-- Screening Type --}}
        <div class="mb-3">
            <label class="form-label">Screening Type</label>
            <select name="screening_type_id" class="form-control" required>
                <option value="">-- Select screening type --</option>
                @foreach($screeningTypes as $type)
                    <option value="{{ $type->id }}" {{ old('screening_type_id') == $type->id ? 'selected' : '' }}>
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
                       value="{{ old('show_date') }}" required>
            </div>

            <div class="col-md-4 mb-3">
                <label class="form-label">Start Time</label>
                <input type="time" name="start_time"
                       id="startTime"
                       class="form-control"
                       value="{{ old('start_time') }}" required>
            </div>

            <div class="col-md-4 mb-3">
                <label class="form-label">End Time</label>
                <input type="time" name="end_time"
                       id="endTime"
                       class="form-control"
                       value="{{ old('end_time') }}" required>
            </div>
        </div>

       

        <button class="btn btn-success">Create Showtime</button>
        <a href="{{ route('admin.showtimes.index') }}" class="btn btn-secondary">
            Back
        </a>

    </form>
</div>

{{-- AUTO END TIME SCRIPT --}}
<script>
// Room data grouped by theater
const roomsByTheater = {
    @foreach($theaters as $theater)
        {{ $theater->id }}: [
            @foreach($theater->rooms as $room)
                { id: {{ $room->id }}, name: '{{ $room->name }}' },
            @endforeach
        ],
    @endforeach
};

// Filter rooms when theater changes
document.getElementById('theaterSelect').addEventListener('change', function() {
    const theaterSelect = this;
    const roomSelect = document.getElementById('roomSelect');
    const theaterId = theaterSelect.value;
    
    if (!theaterId) {
        roomSelect.innerHTML = '<option value="">-- Select theater first --</option>';
        roomSelect.disabled = true;
        return;
    }
    
    roomSelect.disabled = false;
    const rooms = roomsByTheater[theaterId] || [];
    
    if (rooms.length === 0) {
        roomSelect.innerHTML = '<option value="">-- No rooms available --</option>';
        return;
    }
    
    let html = '<option value="">-- Select room --</option>';
    rooms.forEach(room => {
        const selected = '{{ old("room_id") }}' == room.id ? 'selected' : '';
        html += `<option value="${room.id}" ${selected}>${room.name}</option>`;
    });
    roomSelect.innerHTML = html;
});

// Trigger on page load if theater was already selected
if (document.getElementById('theaterSelect').value) {
    document.getElementById('theaterSelect').dispatchEvent(new Event('change'));
}

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
