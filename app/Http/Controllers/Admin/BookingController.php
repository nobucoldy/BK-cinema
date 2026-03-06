<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use Illuminate\Http\Request;

class BookingController extends Controller
{
    public function index(Request $request)
    {
        $query = Booking::with(['user', 'showtime.movie']);

        // 🔍 Search user / movie
        if ($request->filled('keyword')) {
            $query->where(function ($q) use ($request) {
                $q->whereHas('user', function ($u) use ($request) {
                    $u->where('name', 'like', '%' . $request->keyword . '%');
                })
                ->orWhereHas('showtime.movie', function ($m) use ($request) {
                    $m->where('title', 'like', '%' . $request->keyword . '%');
                });
            });
        }

        // 🎯 Filter status (pending, confirmed, cancelled, expired)
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $bookings = $query
            ->orderByDesc('created_at')
            ->paginate(10)
            ->withQueryString();

        return view('admin.bookings.index', compact('bookings'));
    }


    public function show($id)
    {
        $booking = Booking::with([
            'user',
            'showtime.movie',
            'showtime.room',
            'seats'
        ])->findOrFail($id);

        return view('admin.bookings.show', compact('booking'));
    }

    public function cancel($id)
    {
        $booking = Booking::findOrFail($id);
        $booking->update(['status' => 'canceled']);

        return redirect()->back()->with('success', 'Booking cancelled');
    }
}
