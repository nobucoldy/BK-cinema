<?php

namespace App\Http\Controllers\Admin;

use App\Models\Room;
use App\Models\Movie;
use App\Models\Theater;
use App\Models\Showtime;
use App\Models\ScreeningType;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ShowtimeController extends Controller
{
   public function index(Request $request)
{
    $query = Showtime::with(['movie', 'room']);

    // 🔍 Search by movie title
    if ($request->filled('movie')) {
        $query->whereHas('movie', function ($q) use ($request) {
            $q->where('title', 'like', '%' . $request->movie . '%');
        });
    }

    // 📅 Filter by date
    if ($request->filled('date')) {
        $query->where('show_date', $request->date);
    }

    // ❌ ABSOLUTELY DO NOT groupBy movie_id
    $showtimes = $query
        ->orderBy('show_date')
        ->orderBy('start_time')
        ->paginate(10);

    return view('admin.showtimes.index', compact('showtimes'));
}

    public function destroy($id)
    {
        $showtime = Showtime::findOrFail($id);

        // Cannot delete if there are bookings
        if ($showtime->bookings()->count() > 0) {
            return back()->with(
                'error',
                'Cannot delete a showtime that already has ticket bookings'
            );
        }

        $showtime->delete();

        return back()->with(
            'success',
            'Delete showtime successfully'
        );
    }
    public function edit($id)
    {
        $showtime = Showtime::findOrFail($id);

        return view('admin.showtimes.edit', [
            'showtime'        => $showtime,
            'movies'          => Movie::all(),
            'rooms'           => Room::all(),
            'screeningTypes'  => ScreeningType::all(),
        ]);
    }
    public function create()
    {
        return view('admin.showtimes.create', [
            'movies'          => \App\Models\Movie::orderBy('title')->get(),
            'theaters'        => \App\Models\Theater::with('rooms')->orderBy('name')->get(),
            'screeningTypes'  => ScreeningType::all(),
        ]);
    }
    public function update(Request $request, $id)
    {
        $showtime = Showtime::findOrFail($id);

        $request->validate([
            'screening_type_id' => 'required|exists:screening_types,id',
            'show_date'         => 'required|date',
            'start_time'        => 'required',
            'end_time'          => 'nullable',
        ]);

        $showtime->update($request->only(
            'screening_type_id',
            'show_date',
            'start_time',
            'end_time'
        ));

        return redirect()->route('admin.showtimes.index')
            ->with('success', 'Showtime updated successfully');
    }
    public function store(Request $request)
    {
        $request->validate([
            'theater_id'      => 'required|exists:theaters,id',
            'movie_id'        => 'required|exists:movies,id',
            'room_id'         => 'required|exists:rooms,id',
            'screening_type_id' => 'required|exists:screening_types,id',
            'show_date'       => 'required|date',
            'start_time'      => 'required',
            'end_time'        => 'nullable',
        ]);

        // Get movie to get duration
        $movie = Movie::findOrFail($request->movie_id);

        // Tính end_time nếu không nhập
        $start = \Carbon\Carbon::createFromFormat('H:i', $request->start_time);

        if ($request->filled('end_time')) {
            $end = \Carbon\Carbon::createFromFormat('H:i', $request->end_time);
        } else {
            $end = (clone $start)->addMinutes($movie->duration);
        }

        // ❌ Check for duplicate showtime (same room – same day)
        $conflict = Showtime::where('room_id', $request->room_id)
            ->where('show_date', $request->show_date)
            ->where(function ($q) use ($start, $end) {
                $q->whereBetween('start_time', [$start, $end])
                ->orWhereBetween('end_time', [$start, $end])
                ->orWhere(function ($q2) use ($start, $end) {
                    $q2->where('start_time', '<=', $start)
                        ->where('end_time', '>=', $end);
                });
            })
            ->exists();

        if ($conflict) {
            return back()
                ->withInput()
                ->with('error', 'Showtime conflicts with another in the same room');
        }

        // ✅ Lưu DB
        Showtime::create([
            'movie_id'          => $request->movie_id,
            'theater_id'        => $request->theater_id,
            'room_id'           => $request->room_id,
            'screening_type_id' => $request->screening_type_id,
            'show_date'         => $request->show_date,
            'start_time'        => $start->format('H:i'),
            'end_time'          => $end->format('H:i'),
            'price'             => 0,
        ]);

        return redirect()
            ->route('admin.showtimes.index')
            ->with('success', 'Showtime added successfully');
    }

}
