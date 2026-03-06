<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Movie;
use App\Models\Showtime;
use App\Models\Booking;
use App\Models\User;
use App\Models\Theater;
use App\Models\Room;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        // === OVERVIEW STATS ===
        $totalMovies = Movie::count();
        $showingMovies = Movie::where('status', 'showing')->count();
        $comingSoonMovies = Movie::where('status', 'coming_soon')->count();
        
        $totalTheaters = Theater::count();
        $totalRooms = Room::count();
        $totalShowtimes = Showtime::count();
        
        $totalBookings = Booking::count();
        $confirmedBookings = Booking::where('status', 'confirmed')->count();
        $cancelledBookings = Booking::where('status', 'cancelled')->count();
        
        $totalUsers = User::count();
        $activeUsers = User::where('role', 'user')->count();

        // === REVENUE STATISTICS ===
        $totalRevenue = Booking::where('status', 'confirmed')
            ->sum('total_amount');

        $todayRevenue = Booking::where('status', 'confirmed')
            ->whereDate('created_at', Carbon::today())
            ->sum('total_amount');

        $monthRevenue = Booking::where('status', 'confirmed')
            ->whereMonth('created_at', Carbon::now()->month)
            ->whereYear('created_at', Carbon::now()->year)
            ->sum('total_amount');

        // === RECENT DATA ===
        $recentBookings = Booking::with(['user', 'showtime.movie'])
            ->latest()
            ->take(5)
            ->get();

        $recentMovies = Movie::latest()
            ->take(5)
            ->get();

        $popularMovies = Movie::withCount('showtimes')
            ->orderByDesc('showtimes_count')
            ->take(5)
            ->get();

        // === BOOKING STATUS BREAKDOWN ===
        $bookingStatusBreakdown = Booking::selectRaw('status, COUNT(*) as count')
            ->groupBy('status')
            ->get()
            ->pluck('count', 'status')
            ->toArray();

        // === MONTHLY REVENUE ===
        $monthlyRevenue = [];
        for ($i = 6; $i >= 0; $i--) {
            $date = Carbon::now()->subMonths($i);
            $revenue = Booking::where('status', 'confirmed')
                ->whereMonth('created_at', $date->month)
                ->whereYear('created_at', $date->year)
                ->sum('total_amount');
            $monthlyRevenue[$date->format('M')] = $revenue;
        }

        return view('admin.dashboard', compact(
            'totalMovies',
            'showingMovies',
            'comingSoonMovies',
            'totalTheaters',
            'totalRooms',
            'totalShowtimes',
            'totalBookings',
            'confirmedBookings',
            'cancelledBookings',
            'totalUsers',
            'activeUsers',
            'totalRevenue',
            'todayRevenue',
            'monthRevenue',
            'recentBookings',
            'recentMovies',
            'popularMovies',
            'bookingStatusBreakdown',
            'monthlyRevenue'
        ));
    }
}

