@extends('layouts.admin')

@section('content')
<div class="container">

    <h3 class="mb-4">+ Edit Movie</h3>

    {{-- Errors --}}
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
          action="{{ route('admin.movies.update', $movie->id) }}"
          enctype="multipart/form-data">
        @csrf
        @method('PUT')

        {{-- Title --}}
        <div class="mb-3">
            <label class="form-label">Title</label>
            <input type="text"
                   name="title"
                   class="form-control"
                   value="{{ old('title', $movie->title) }}"
                   required>
        </div>

        {{-- Duration --}}
        <div class="mb-3">
            <label class="form-label">Duration (minutes)</label>
            <input type="number"
                   name="duration"
                   class="form-control"
                   value="{{ old('duration', $movie->duration) }}"
                   required>
        </div>

        {{-- Director --}}
        <div class="mb-3">
            <label class="form-label">Director</label>
            <input type="text" 
                   class="form-control mb-2" 
                   id="directorSearch" 
                   placeholder="🔍 Search director...">
            <select name="director_id" class="form-control" id="directorSelect" required>
                <option value="">-- Select Director --</option>
                @foreach ($directors as $director)
                    <option value="{{ $director->id }}" data-name="{{ $director->name }}" {{ old('director_id', $movie->director_id) == $director->id ? 'selected' : '' }}>
                        {{ $director->name }}
                    </option>
                @endforeach
            </select>
        </div>

        {{-- Genres --}}
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
                               {{ in_array($genre->id, old('genres', $movieGenres)) ? 'checked' : '' }}>
                        <label class="form-check-label" for="genre_{{ $genre->id }}">
                            {{ $genre->name }}
                        </label>
                    </div>
                @endforeach
            </div>
        </div>

        {{-- Actors --}}
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
                               {{ in_array($actor->id, old('actors', $movieActors)) ? 'checked' : '' }}>
                        <label class="form-check-label" for="actor_{{ $actor->id }}">
                            {{ $actor->name }}
                        </label>
                    </div>
                @endforeach
            </div>
        </div>

        {{-- Release Date --}}
        <div class="mb-3">
            <label class="form-label">Release Date</label>
            <input type="date"
                   name="release_date"
                   class="form-control"
                   value="{{ old('release_date', $movie->release_date) }}"
                   required>
        </div>

        {{-- Status --}}
        <div class="mb-3">
            <label class="form-label">Status</label>
            <select name="status" class="form-control" required>
                <option value="showing" {{ $movie->status=='showing'?'selected':'' }}>
                    Showing
                </option>
                <option value="coming_soon" {{ $movie->status=='coming_soon'?'selected':'' }}>
                    Coming Soon
                </option>
                <option value="stopped" {{ $movie->status=='stopped'?'selected':'' }}>
                    Stopped
                </option>
            </select>
        </div>

        {{-- Trailer URL --}}
        <div class="mb-3">
            <label class="form-label">Trailer URL</label>
            <input type="url"
                   name="trailer_url"
                   class="form-control"
                   value="{{ old('trailer_url', $movie->trailer_url) }}"
                   placeholder="https://youtube.com/watch?v=...">
        </div>

        {{-- Current Poster --}}
        @if($movie->poster_url)
        <div class="mb-3">
            <label class="form-label">Current Poster</label><br>
            <img src="{{ asset('storage/' . $movie->poster_url) }}"
                 alt="Poster"
                 class="img-thumbnail"
                 style="max-height: 200px">
        </div>
        @endif

        {{-- Upload New Poster --}}
        <div class="mb-3">
            <label class="form-label">Change Poster (optional)</label>
            <input type="file"
                   name="poster"
                   class="form-control"
                   accept="image/*">
        </div>

        {{-- Description --}}
        <div class="mb-3">
            <label class="form-label">Description</label>
            <textarea name="description"
                      class="form-control"
                      rows="4">{{ old('description', $movie->description) }}</textarea>
        </div>

        {{-- Actions --}}
        <div class="d-flex gap-2">
            <button class="btn btn-primary">
                Update
            </button>
            <a href="{{ route('admin.movies.index') }}"
               class="btn btn-secondary">
                Back
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
