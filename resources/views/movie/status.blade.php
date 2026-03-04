@extends('layouts.app')

@section('content')
<style>
    /* --- BREADCRUMB CĂN TÂM & KHÔNG ĐƯỜNG KẺ --- */
    .breadcrumb-container {
        height: 50px;
        display: flex;
        align-items: center;
        justify-content: center;
        background: transparent !important;
        border: none !important;
    }
    .breadcrumb {
        margin: 0 !important;
        padding: 0 !important;
        font-size: 13px;
        display: flex !important;
        align-items: center !important;
    }
    .breadcrumb-item + .breadcrumb-item::before {
        content: ">" !important;
        color: #ccc !important;
        padding: 0 10px;
        font-size: 11px;
    }
    .breadcrumb-item a { color: #888 !important; text-decoration: none; transition: 0.3s; }
    .breadcrumb-item a:hover { color: #ff69b4 !important; }
    .breadcrumb-item.active { color: #333; font-weight: 600; }

    /* --- STYLE GIAO DIỆN --- */
    .movie-list-page {
        background-color: #efe6f5; 
        width: 100vw;
        min-height: 100vh;
        padding: 20px 0 60px 0;
        margin-left: calc(-50vw + 50%);
        margin-right: calc(-50vw + 50%);
    }
    .filter-bar { display: flex; justify-content: space-between; align-items: center; margin-bottom: 40px; }
    .movie-grid-system { display: grid; grid-template-columns: repeat(4, 1fr); gap: 30px; }
    
    @media (max-width: 992px) { .movie-grid-system { grid-template-columns: repeat(2, 1fr); } }
    @media (max-width: 576px) { .movie-grid-system { grid-template-columns: repeat(1, 1fr); } }

    .movie-item-box {
        background: white; border-radius: 20px; overflow: hidden;
        box-shadow: 0 10px 25px rgba(0,0,0,0.06); transition: 0.3s cubic-bezier(0.175, 0.885, 0.32, 1.275);
        text-decoration: none !important; display: block;
    }
    .movie-item-box:hover { transform: translateY(-12px); box-shadow: 0 15px 35px rgba(0,0,0,0.12); }
    
    .poster-container { position: relative; width: 100%; aspect-ratio: 2/3; overflow: hidden; }
    .poster-container img { width: 100%; height: 100%; object-fit: cover; transition: 0.5s; }
    .movie-item-box:hover .poster-container img { transform: scale(1.1); }

    /* Label màu đỏ cố định cho Now Showing */
    .status-label {
        position: absolute; bottom: 15px; right: 15px; 
        background: #ff3131;
        color: white;
        font-size: 0.7rem; font-weight: bold;
        padding: 6px 14px; border-radius: 8px; text-transform: uppercase;
        box-shadow: 0 4px 10px rgba(0,0,0,0.2);
    }
    .movie-footer-info { padding: 18px; text-align: center; }
    .movie-footer-info h6 { font-weight: 700; color: #1a1a1a; text-transform: uppercase; margin: 0; font-size: 0.95rem; }
    .real-time-sub { color: #888; font-size: 0.95rem; margin-top: 5px; }
</style>

{{-- BREADCRUMB CĂN GIỮA --}}
<div class="breadcrumb-container">
    <div class="container">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                <li class="breadcrumb-item active" aria-current="page">Now Showing</li>
            </ol>
        </nav>
    </div>
</div>

<div class="movie-list-page">
    <div class="container">
        <div class="filter-bar">
            <div>
                <h2 class="fw-bold m-0 text-uppercase">Now Showing</h2>
                <div class="real-time-sub">
                    Schedule for today, {{ \Carbon\Carbon::now()->format('d/m/Y') }}
                </div>
            </div>
            <div class="d-flex gap-2">
                <select class="form-select shadow-none" id="genreFilter" style="width: auto; border-radius: 10px; cursor: pointer;" onchange="applyFilters()">
                    <option value="">All Genres</option>
                    @foreach($genres as $genre)
                        <option value="{{ $genre->id }}">{{ $genre->name }}</option>
                    @endforeach
                </select>
                <select class="form-select shadow-none" id="directorFilter" style="width: auto; border-radius: 10px; cursor: pointer;" onchange="applyFilters()">
                    <option value="">All Directors</option>
                    @foreach($directors as $director)
                        <option value="{{ $director->id }}">{{ $director->name }}</option>
                    @endforeach
                </select>
                <select class="form-select shadow-none" id="actorFilter" style="width: auto; border-radius: 10px; cursor: pointer;" onchange="applyFilters()">
                    <option value="">All Actors</option>
                    @foreach($actors as $actor)
                        <option value="{{ $actor->id }}">{{ $actor->name }}</option>
                    @endforeach
                </select>
            </div>
        </div>

        <div id="movieGrid" class="movie-grid-system">
            @forelse($movies as $movie)
                <a href="{{ route('movies.show', $movie->id) }}" class="movie-item-box">
                    <div class="poster-container">
                        <img src="{{ asset('storage/' . $movie->poster_url) }}" alt="{{ $movie->title }}">
                        <div class="status-label">Now Showing</div>
                    </div>
                    <div class="movie-footer-info">
                        <h6>{{ $movie->title }}</h6>
                    </div>
                </a>
            @empty
                <div class="text-center w-100 py-5" style="grid-column: 1 / -1;">
                    <i class="bi bi-film" style="font-size: 3rem; color: #ccc;"></i>
                    <p class="text-muted mt-3">No movies found for this status.</p>
                </div>
            @endforelse
        </div>
    </div>
</div>

<script>
    function applyFilters() {
        const genre = document.getElementById('genreFilter').value;
        const director = document.getElementById('directorFilter').value;
        const actor = document.getElementById('actorFilter').value;

        const params = new URLSearchParams();
        if (genre) params.append('genre', genre);
        if (director) params.append('director', director);
        if (actor) params.append('actor', actor);

        fetch(`/api/movies/showing-filter?${params.toString()}`)
            .then(response => response.json())
            .then(data => displayMovies(data))
            .catch(error => console.error('Error:', error));
    }

    function displayMovies(movies) {
        const grid = document.getElementById('movieGrid');
        
        if (movies.length === 0) {
            grid.innerHTML = `
                <div class="text-center w-100 py-5" style="grid-column: 1 / -1;">
                    <i class="bi bi-film" style="font-size: 3rem; color: #ccc;"></i>
                    <p class="text-muted mt-3">No movies found for this filter.</p>
                </div>
            `;
            return;
        }

        grid.innerHTML = movies.map(movie => `
            <a href="/movies/${movie.id}" class="movie-item-box">
                <div class="poster-container">
                    <img src="/storage/${movie.poster_url}" alt="${movie.title}">
                    <div class="status-label">Now Showing</div>
                </div>
                <div class="movie-footer-info">
                    <h6>${movie.title}</h6>
                </div>
            </a>
        `).join('');
    }
</script>
@endsection