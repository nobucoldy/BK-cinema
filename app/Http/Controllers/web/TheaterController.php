<?php

namespace App\Http\Controllers\Web; // Chú ý: Nên viết hoa chữ W để chuẩn PSR-4

use App\Http\Controllers\Controller;
use App\Models\Theater;
use App\Models\Showtime;
use Illuminate\Http\Request;

class TheaterController extends Controller
{
    public function index(Request $request)
    {
        $cities = Theater::select('city')->distinct()->pluck('city');
        $query = Theater::query();

        if ($request->filled('city')) {
            $query->where('city', $request->city);
        }

        $theaters = $query->get();
        return view('theaters.index', compact('theaters', 'cities'));
    }

    public function showSchedule(Request $request)
{
    $cities = Theater::select('city')->distinct()->pluck('city');
    $selectedTheaterId = $request->get('theater_id');

    // --- PHẦN THAY ĐỔI QUAN TRỌNG Ở ĐÂY ---
    if ($selectedTheaterId) {
        // Nếu người dùng chọn từ trang danh sách rạp, sidebar chỉ hiện duy nhất rạp đó
        $theaters = Theater::where('id', $selectedTheaterId)->get();
    } else {
        // Nếu vào trang Schedule trực tiếp, hiện danh sách theo thành phố như cũ
        $theaters = Theater::when($request->filled('city'), function ($q) use ($request) {
            $q->where('city', $request->city);
        })->get();
    }
    // --------------------------------------

    // Nếu không có ID được truyền vào, lấy rạp đầu tiên làm mặc định
    if (!$selectedTheaterId && $theaters->isNotEmpty()) {
        $selectedTheaterId = $theaters->first()->id;
    }

    $selectedTheater = Theater::find($selectedTheaterId);
    $selectedDate = $request->get('show_date', now()->toDateString());

    $showtimesGroupedByMovie = collect();

    if ($selectedTheater) {
        $showtimesGroupedByMovie = Showtime::with(['movie'])
            ->where('theater_id', $selectedTheater->id)
            ->whereDate('show_date', $selectedDate)
            ->where('start_time', '>=', $selectedDate == now()->toDateString() ? now()->toTimeString() : '00:00:00')
            ->orderBy('start_time')
            ->get()
            ->groupBy('movie_id');
    }

    return view('theaters.schedule', compact(
        'theaters',
        'cities',
        'selectedTheater',
        'selectedTheaterId',
        'selectedDate',
        'showtimesGroupedByMovie'
    ));
}
}