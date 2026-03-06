<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Movie;
use App\Models\Review;
use App\Models\Showtime;
use Carbon\Carbon;
use Illuminate\Http\Request;

class MovieController extends Controller
{
    public function index()
    {
        $reviews = Review::with('movie')->latest()->paginate(12);
        return view('review.index', compact('reviews'));
    }

    public function showing()
    {
        $movies = Movie::where('status', 'showing')->paginate(12);
        $genres = \App\Models\Genre::all();
        $directors = \App\Models\Director::all();
        $actors = \App\Models\Actor::all();
        return view('movies.status', compact('movies', 'genres', 'directors', 'actors'));
    }

    public function upcoming()
    {
        $movies = Movie::where('status', 'coming_soon')->get();
        return view('movies.upcoming', compact('movies')); 
    }

    public function show($id)
    {
        $movie = Movie::with(['director', 'actors', 'genres'])->findOrFail($id);

        // 7 ngày tới
        $dates = collect(range(0, 6))
            ->map(fn ($i) => Carbon::today()->addDays($i)->toDateString());

        $allShowtimes = Showtime::with(['theater', 'screeningType']) // ✅ LOAD KIỂU CHIẾU
            ->where('movie_id', $movie->id)
            ->whereBetween('show_date', [
                Carbon::today()->toDateString(),
                Carbon::today()->addDays(6)->toDateString()
            ])
            ->orderBy('show_date')
            ->orderBy('start_time')
            ->get();

        // Group: ngày → rạp
        $showtimes = $allShowtimes
            ->groupBy([
                fn ($st) => Carbon::parse($st->show_date)->toDateString(),
                fn ($st) => $st->theater->name
            ]);

        return view('movies.show', compact('movie', 'showtimes'));
    }


}
