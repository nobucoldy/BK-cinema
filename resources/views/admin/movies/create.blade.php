@extends('layouts.admin')

@section('content')
<div class="container">

    <h3 class="mb-4">+ Add New Movie</h3>

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
      action="{{ route('admin.movies.store') }}"
      enctype="multipart/form-data">
    @csrf

    <div class="mb-3">
        <label class="form-label">Title</label>
        <input type="text"
               name="title"
               class="form-control"
               value="{{ old('title') }}"
               required>
    </div>

    <div class="mb-3">
        <label class="form-label">Duration (minutes)</label>
        <input type="number"
               name="duration"
               class="form-control"
               value="{{ old('duration') }}"
               required>
    </div>

    <div class="mb-3">
        <label class="form-label">Director</label>
        <input type="text" 
               class="form-control mb-2" 
               id="directorSearch" 
               placeholder="🔍 Search director...">
        <select name="director_id" class="form-control" id="directorSelect" required>
            <option value="">-- Select Director --</option>
            @foreach ($directors as $director)
                <option value="{{ $director->id }}" data-name="{{ $director->name }}" {{ old('director_id') == $director->id ? 'selected' : '' }}>
                    {{ $director->name }}
                </option>
            @endforeach
        </select>
    </div>

    <div class="mb-3">
        <label class="form-label">Genres (Select at least one)</label>
        <input type="text" 
               class="form-control mb-2" 
               id="genreSearch" 
               placeholder="🔍 Search genres...">
        <div class="border rounded p-3" style="max-height: 200px; overflow-y: auto;" id="genreContainer">
            @foreach ($genres as $genre)
                <div class="form-check" data-genre-name="{{ strtolower($genre->name) }}">
                    <input class="form-check-input" 
                           type="checkbox" 
                           name="genres[]" 
                           value="{{ $genre->id }}"
                           id="genre_{{ $genre->id }}"
                           {{ in_array($genre->id, old('genres', [])) ? 'checked' : '' }}>
                    <label class="form-check-label" for="genre_{{ $genre->id }}">
                        {{ $genre->name }}
                    </label>
                </div>
            @endforeach
        </div>
    </div>

    <div class="mb-3">
        <label class="form-label">Actors</label>
        <input type="text" 
               class="form-control mb-2" 
               id="actorSearch" 
               placeholder="🔍 Search actors...">
        <div class="border rounded p-3" style="max-height: 200px; overflow-y: auto;" id="actorContainer">
            @foreach ($actors as $actor)
                <div class="form-check" data-actor-name="{{ strtolower($actor->name) }}">
                    <input class="form-check-input" 
                           type="checkbox" 
                           name="actors[]" 
                           value="{{ $actor->id }}"
                           id="actor_{{ $actor->id }}"
                           {{ in_array($actor->id, old('actors', [])) ? 'checked' : '' }}>
                    <label class="form-check-label" for="actor_{{ $actor->id }}">
                        {{ $actor->name }}
                    </label>
                </div>
            @endforeach
        </div>
    </div>

    <div class="mb-3">
        <label class="form-label">Release Date</label>
        <input type="date"
               name="release_date"
               class="form-control"
               value="{{ old('release_date') }}"
               required>
    </div>

    <div class="mb-3">
        <label class="form-label">Status</label>
        <select name="status" class="form-control" required>
            <option value="">-- Select Status --</option>
            <option value="showing" {{ old('status') == 'showing' ? 'selected' : '' }}>Showing</option>
            <option value="coming_soon" {{ old('status') == 'coming_soon' ? 'selected' : '' }}>Coming Soon</option>
            <option value="stopped" {{ old('status') == 'stopped' ? 'selected' : '' }}>Stopped</option>
        </select>
    </div>

    <div class="mb-3">
        <label class="form-label">Trailer URL</label>
        <input type="url"
               name="trailer_url"
               class="form-control"
               value="{{ old('trailer_url') }}"
               placeholder="https://youtube.com/watch?v=...">
    </div>

    <div class="mb-3">
        <label class="form-label">Poster Image</label>
        <input type="file"
               name="poster"
               class="form-control"
               accept="image/*">
    </div>

    <div class="mb-3">
        <label class="form-label">Description</label>
        <textarea name="description"
                  class="form-control"
                  rows="4">{{ old('description') }}</textarea>
    </div>

    <div class="d-flex gap-2">
        <button class="btn btn-success">Save</button>
        <a href="{{ route('admin.movies.index') }}" class="btn btn-secondary">
            Cancel
        </a>
    </div>
</form>

</div>

<script>
document.getElementById('directorSearch').addEventListener('keyup', function() {
    const searchTerm = this.value.toLowerCase();
    const options = document.querySelectorAll('#directorSelect option');
    options.forEach(option => {
        if (option.dataset.name) {
            option.style.display = option.dataset.name.toLowerCase().includes(searchTerm) ? '' : 'none';
        }
    });
});

document.getElementById('genreSearch').addEventListener('keyup', function() {
    const searchTerm = this.value.toLowerCase();
    const items = document.querySelectorAll('#genreContainer .form-check');
    items.forEach(item => {
        const name = item.dataset.genreName;
        item.style.display = name.includes(searchTerm) ? '' : 'none';
    });
});

document.getElementById('actorSearch').addEventListener('keyup', function() {
    const searchTerm = this.value.toLowerCase();
    const items = document.querySelectorAll('#actorContainer .form-check');
    items.forEach(item => {
        const name = item.dataset.actorName;
        item.style.display = name.includes(searchTerm) ? '' : 'none';
    });
});
</script>
@endsection
