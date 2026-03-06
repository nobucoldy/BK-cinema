<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Booking;
use App\Models\Showtime;
use App\Models\Seat;
use Illuminate\Support\Facades\DB;

class BookingController extends Controller
{
    public function store(Request $request)
    {
        // 🔐 Kiểm tra đăng nhập
        $user = $request->user();
        if (!$user) {
            return response()->json([
                'message' => 'Unauthenticated'
            ], 401);
        }

        // ✅ Validate dữ liệu
        $validated = $request->validate([
            'showtime_id' => 'required|exists:showtimes,id',
            'seat_ids' => 'required|array|min:1',
            'seat_ids.*' => 'exists:seats,id',
        ]);

        // 🎬 Get showtime + room
        $showtime = Showtime::with(['movie', 'room'])
            ->findOrFail($validated['showtime_id']);

        // 1️⃣ Check if seat belongs to room
        $validSeatCount = Seat::where('room_id', $showtime->room_id)
            ->whereIn('id', $validated['seat_ids'])
            ->count();

        if ($validSeatCount !== count($validated['seat_ids'])) {
            return response()->json([
                'message' => 'Some seats do not belong to this room'
            ], 422);
        }

        // 2️⃣ Check if seat has been booked
        $bookedSeats = DB::table('booking_seats')
            ->join('bookings', 'booking_seats.booking_id', '=', 'bookings.id')
            ->where('bookings.showtime_id', $showtime->id)
            ->whereIn('booking_seats.seat_id', $validated['seat_ids'])
            ->pluck('booking_seats.seat_id');

        if ($bookedSeats->isNotEmpty()) {
            return response()->json([
                'message' => 'Some seats already booked',
                'booked_seats' => $bookedSeats
            ], 409);
        }

        // 3️⃣ Tạo booking (transaction)
        return DB::transaction(function () use ($user, $showtime, $validated) {

            $totalAmount = count($validated['seat_ids']) * $showtime->price;

            $booking = Booking::create([
                'user_id' => $user->id,
                'showtime_id' => $showtime->id,
                'total_amount' => $totalAmount,
                'status' => 'confirmed',
            ]);

            $booking->seats()->attach($validated['seat_ids']);

            return response()->json([
                'message' => 'Booking created successfully',
                'booking' => $booking->load([
                    'seats',
                    'showtime.movie',
                    'showtime.room'
                ])
            ], 201);
        });
    }
}
