<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Movie;
use App\Services\MovieService;
use Illuminate\Http\Request;

class MovieController extends Controller
{
    protected $movieService;

    public function __construct(MovieService $movieService)
    {
        $this->movieService = $movieService;
    }

    public function index()
    {
        return response()->json($this->movieService->getAllMovies());
    }

    public function show($id)
    {
        return response()->json($this->movieService->getMovieById($id));
    }

    public function showing()
    {
        return response()->json(
            $this->movieService->getShowingMovies()
        );
    }

    public function comingSoon()
    {
        return response()->json(
            $this->movieService->getComingSoonMovies()
        );
    }

    public function filter(Request $request)
    {
        $query = Movie::with(['genres', 'director', 'actors']);

        // Filter by genre
        if ($request->has('genre') && $request->genre) {
            $query->whereHas('genres', function ($q) use ($request) {
                $q->where('genres.id', $request->genre);
            });
        }

        // Filter by director
        if ($request->has('director') && $request->director) {
            $query->where('director_id', $request->director);
        }

        // Filter by actor
        if ($request->has('actor') && $request->actor) {
            $query->whereHas('actors', function ($q) use ($request) {
                $q->where('actors.id', $request->actor);
            });
        }

        $movies = $query->get();

        return response()->json($movies->map(function ($movie) {
            return [
                'id' => $movie->id,
                'title' => $movie->title,
                'poster_url' => $movie->poster_url,
                'duration' => $movie->duration,
                'description' => $movie->description,
            ];
        }));
    }

    public function showingFilter(Request $request)
    {
        $query = Movie::where('status', 'showing')->with(['genres', 'director', 'actors']);

        // Filter by genre
        if ($request->has('genre') && $request->genre) {
            $query->whereHas('genres', function ($q) use ($request) {
                $q->where('genres.id', $request->genre);
            });
        }

        // Filter by director
        if ($request->has('director') && $request->director) {
            $query->where('director_id', $request->director);
        }

        // Filter by actor
        if ($request->has('actor') && $request->actor) {
            $query->whereHas('actors', function ($q) use ($request) {
                $q->where('actors.id', $request->actor);
            });
        }

        $movies = $query->get();

        return response()->json($movies->map(function ($movie) {
            return [
                'id' => $movie->id,
                'title' => $movie->title,
                'poster_url' => $movie->poster_url,
                'duration' => $movie->duration,
                'description' => $movie->description,
            ];
        }));
    }
}

