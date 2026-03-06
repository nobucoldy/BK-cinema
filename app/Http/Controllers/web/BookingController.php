<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Showtime;
use App\Models\Booking;
use App\Models\BookingSeat;
use Illuminate\Support\Facades\DB;

class BookingController extends Controller
{
    /**
     * Hiển thị lịch sử đặt vé của user
     */
    public function history(Request $request)
    {
        $query = auth()->user()->bookings()->with(['showtime.movie', 'showtime.room']);

        // 🔍 Search movie
        if ($request->filled('keyword')) {
            $query->whereHas('showtime.movie', function ($q) use ($request) {
                $q->where('title', 'like', '%' . $request->keyword . '%');
            });
        }

        // 🎯 Filter status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $bookings = $query
            ->orderByDesc('created_at')
            ->paginate(10)
            ->withQueryString();

        return view('booking.history', compact('bookings'));
    }

    /**
     * Hiển thị chi tiết một đặt vé
     */
    public function show($id)
    {
        $booking = Booking::with([
            'user',
            'showtime.movie',
            'showtime.theater',
            'showtime.room',
            'showtime.screeningType',
            'bookingSeats.seat'
        ])->findOrFail($id);

        // Kiểm tra user có quyền xem booking này không
        if ($booking->user_id !== auth()->id()) {
            abort(403, 'Unauthorized access');
        }

        return view('booking.show', compact('booking'));
    }

    /**
     * Hiển thị trang chọn ghế cho một suất chiếu
     */
    public function create($showtimeId)
    {
        // Lấy suất chiếu + thông tin phòng + ghế + phim với director, actors, genres
        $showtime = Showtime::with(['room.seats', 'movie.director', 'movie.actors', 'movie.genres'])->findOrFail($showtimeId);

        // Lấy các ghế đã được đặt (status = confirmed) - lấy seat code thay vì ID
        $soldSeatCodes = BookingSeat::whereHas('booking', function($q) use ($showtimeId){
            $q->where('showtime_id', $showtimeId)
              ->where('status', 'confirmed');
        })->join('seats', 'booking_seats.seat_id', '=', 'seats.id')
          ->pluck('seats.seat_code')->toArray();

        return view('booking.create', compact('showtime', 'soldSeatCodes'));
    }

    /**
     * Lưu booking và ghế sau khi thanh toán
     */
    public function store(Request $request)
    {
        $request->validate([
            'showtime_id' => 'required|exists:showtimes,id',
            'seat_ids' => 'required|array|min:1',
            'seat_ids.*' => 'exists:seats,id',
        ]);

        DB::beginTransaction();

        try {
            // Lấy suất chiếu và ghế phòng
            $showtime = Showtime::with('room.seats')->findOrFail($request->showtime_id);

            // Kiểm tra xem ghế có bị đặt rồi không
            $bookedSeats = BookingSeat::whereHas('booking', function($q) use ($request) {
                $q->where('showtime_id', $request->showtime_id)
                  ->where('status', 'confirmed');
            })->whereIn('seat_id', $request->seat_ids)->pluck('seat_id')->toArray();

            if (!empty($bookedSeats)) {
                DB::rollBack();
                return response()->json([
                    'success' => false,
                    'message' => 'Some seats are already booked',
                    'booked_seats' => $bookedSeats
                ], 409);
            }

            // Tạo booking mới
            $booking = Booking::create([
                'user_id' => auth()->id(),
                'showtime_id' => $request->showtime_id,
                'total_amount' => 0,
                'status' => 'confirmed',
            ]);

            $total = 0;

            foreach ($request->seat_ids as $seatId) {
                $seat = $showtime->room->seats->where('id', $seatId)->first();

                // Xác định giá ghế dựa trên seat_type
                $price = 36000; // default regular
                if ($seat) {
                    if (strpos($seat->seat_code, 'L') === 0) {
                        $price = 90000; // Couple seats
                    } elseif (in_array($seat->seat_code[0], ['D', 'E', 'F', 'G', 'H'])) {
                        $price = 49000; // VIP seats
                    }
                }

                // Tạo booking seat
                BookingSeat::create([
                    'booking_id' => $booking->id,
                    'seat_id' => $seatId,
                    'showtime_id' => $request->showtime_id,
                    'price' => $price,
                    'status' => 'confirmed',
                ]);

                $total += $price;
            }

            // Cập nhật tổng tiền booking
            $booking->update(['total_amount' => $total]);

            DB::commit();

            return response()->json([
                'success' => true,
                'booking_id' => $booking->id,
                'total_amount' => $total,
                'message' => 'Booking created successfully'
            ]);

        } catch (\Throwable $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'An error occurred: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Hủy đặt vé
     */
    public function cancel($id)
    {
        try {
            // Check if user is authenticated
            if (!auth()->check()) {
                \Log::warning('Unauthenticated cancel attempt for booking ' . $id);
                return redirect()->route('login')->with('error', 'Please login to cancel booking');
            }

            \Log::info('Cancel method called for booking ID: ' . $id . ' by user: ' . auth()->id());

            $booking = Booking::findOrFail($id);

            // Kiểm tra user có quyền hủy booking này không
            if ($booking->user_id !== auth()->id()) {
                \Log::warning('Unauthorized cancel attempt for booking ' . $id . ' by user ' . auth()->id());
                abort(403, 'Unauthorized access');
            }

            // Kiểm tra booking có thể hủy không
        if ($booking->status === 'canceled') {
            \Log::info('Booking ' . $id . ' is already canceled');
            return redirect()->back()->with('info', 'This booking is already canceled');
        }

        $booking->update(['status' => 'canceled']);
        \Log::info('Booking ' . $id . ' canceled successfully');

        return redirect()->back()->with('success', 'Booking canceled successfully');
        } catch (\Exception $e) {
            \Log::error('Error cancelling booking ' . $id . ': ' . $e->getMessage());
            return redirect()->back()->with('error', 'Failed to cancel booking: ' . $e->getMessage());
        }
    }
}
