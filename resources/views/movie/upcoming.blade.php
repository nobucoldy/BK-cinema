@extends('layouts.app')

@section('content')
<style>
    /* --- BREADCRUMB CĂN TÂM & KHÔNG ĐƯỜNG KẺ (ĐỒNG BỘ 100%) --- */
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
    .upcoming-page { background-color: #efe6f5; width: 100%; min-height: 100vh; padding: 50px 0; }
    .movie-grid { display: grid; grid-template-columns: repeat(4, 1fr); gap: 25px; }
    @media (max-width: 992px) { .movie-grid { grid-template-columns: repeat(2, 1fr); } }

    .movie-card {
        background: white; border-radius: 20px; overflow: hidden;
        box-shadow: 0 10px 25px rgba(0,0,0,0.05); transition: 0.3s;
        text-decoration: none !important; display: block;
    }
    .movie-card:hover { transform: translateY(-10px); }
    .poster-box { position: relative; width: 100%; aspect-ratio: 2/3; }
    .poster-box img { width: 100%; height: 100%; object-fit: cover; }

    .badge-upcoming {
        position: absolute; bottom: 12px; right: 12px; background: #007bff;
        color: white; font-size: 0.7rem; font-weight: bold;
        padding: 4px 12px; border-radius: 6px;
    }
    .movie-info { padding: 15px; text-align: center; }
    .movie-info h6 { font-weight: 700; color: #333; text-transform: uppercase; margin: 0; }
</style>
{{-- BREADCRUMB CĂN GIỮA --}}
<div class="breadcrumb-container">
    <div class="container">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                <li class="breadcrumb-item active" aria-current="page">Coming Soon</li>
            </ol>
        </nav>
    </div>
</div>
<div class="upcoming-page">
    <div class="container">
        <h2 class="fw-bold mb-4">COMING SOON</h2>
        <div class="movie-grid">
            @forelse($movies as $movie)
                <a href="{{ route('movies.show', $movie->id) }}" class="movie-card">
                    <div class="poster-box">
                        <img src="{{ asset('storage/' . $movie->poster_url) }}" alt="{{ $movie->title }}">
                        <div class="badge-upcoming">Coming Soon</div>
                    </div>
                    <div class="movie-info">
                        <h6>{{ $movie->title }}</h6>
                    </div>
                </a>
            @empty
                <div class="text-center w-100 py-5">
                    <p class="text-muted">No upcoming movies at the moment.</p>
                </div>
            @endforelse
        </div>
    </div>
</div>
@endsection