<?php
namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Movie;
use App\Models\Theater;
use App\Models\Showtime;
use Illuminate\Http\Request;
use Carbon\Carbon;

class HomeController extends Controller
{
    public function index(Request $request)
    {
        // 1. Lấy danh sách phim cho Slider Banner (3s/lần)
        $featuredMovies = Movie::whereNotNull('movie_backdrop')
                       ->where('movie_backdrop', '!=', '')
                       ->latest()
                       ->get();

        // 2. Phim đang chiếu & sắp chiếu
        $showingMovies = Movie::where('status', 'showing')->get();
        $upcomingMovies = Movie::where('status', 'coming_soon')->get();

        // 3. Logic lấy dữ liệu Lịch chiếu (Xử lý toàn bộ ở đây)
        $cities = Theater::select('city')->distinct()->pluck('city');
        
        $theaters = Theater::when($request->filled('city'), function($q) use ($request) {
            return $q->where('city', $request->city);
        })->get();

        $selectedTheaterId = $request->get('theater_id', optional($theaters->first())->id);
        $selectedTheater = Theater::find($selectedTheaterId);
        $selectedDate = $request->get('show_date', now()->toDateString());

        $showtimesGroupedByMovie = collect();
        if ($selectedTheater) {
            $showtimesGroupedByMovie = Showtime::where('theater_id', $selectedTheater->id)
                ->where('show_date', $selectedDate)
                ->with(['movie.genres', 'screeningType'])
                ->get()
                ->groupBy('movie_id');
        }

        // CHỈ DÙNG 1 LỆNH RETURN DUY NHẤT VỚI ĐẦY ĐỦ BIẾN
        return view('home', compact(
            'showingMovies',
            'upcomingMovies',
            'featuredMovies', 
            'cities',
            'theaters',
            'selectedTheater',
            'selectedTheaterId',
            'selectedDate',
            'showtimesGroupedByMovie'
        ));
    }
}