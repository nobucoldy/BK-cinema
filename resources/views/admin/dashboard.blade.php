@extends('layouts.admin')

@section('content')
<style>
    .stat-card {
        border-radius: 10px;
        padding: 18px;
        margin-bottom: 15px;
        border-left: 4px solid #667eea;
        background: white;
        box-shadow: 0 2px 8px rgba(0,0,0,0.08);
        transition: 0.3s;
    }
    .stat-card:hover { box-shadow: 0 4px 12px rgba(0,0,0,0.12); }
    
    .stat-card.blue { border-left-color: #667eea; background: linear-gradient(90deg, #f0f4ff 0%, white 100%); }
    .stat-card.green { border-left-color: #84fab0; background: linear-gradient(90deg, #f0fdf8 0%, white 100%); }
    .stat-card.orange { border-left-color: #fa709a; background: linear-gradient(90deg, #fff5f8 0%, white 100%); }
    .stat-card.red { border-left-color: #fd6e6a; background: linear-gradient(90deg, #fff5f5 0%, white 100%); }
    
    .stat-card h6 { font-size: 0.85rem; color: #666; margin-bottom: 8px; font-weight: 600; }
    .stat-card .stat-value { font-size: 1.8rem; font-weight: bold; color: #333; }
    .stat-card .stat-label { font-size: 0.8rem; color: #999; margin-top: 5px; }
    
    .table-wrapper { background: white; border-radius: 10px; padding: 18px; box-shadow: 0 2px 8px rgba(0,0,0,0.08); margin-bottom: 20px; }
    .table-title { font-weight: 600; font-size: 1rem; margin-bottom: 15px; color: #333; border-bottom: 2px solid #f0f0f0; padding-bottom: 10px; }
    
    .badge { font-weight: 600; padding: 4px 8px; }
</style>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h2 style="color: #333;">Dashboard</h2>
    <span class="text-muted">{{ date('d/m/Y') }}</span>
</div>

<!-- === REVENUE SECTION === -->
<div class="row g-3 mb-4">
    <div class="col-md-4">
        <div class="stat-card blue">
            <h6>💰 Total Revenue</h6>
            <div class="stat-value">{{ number_format($totalRevenue, 0) }} đ</div>
            <div class="stat-label">All time</div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="stat-card green">
            <h6>📈 Today Revenue</h6>
            <div class="stat-value">{{ number_format($todayRevenue, 0) }} đ</div>
            <div class="stat-label">{{ date('d/m/Y') }}</div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="stat-card orange">
            <h6>📅 Month Revenue</h6>
            <div class="stat-value">{{ number_format($monthRevenue, 0) }} đ</div>
            <div class="stat-label">{{ date('F Y') }}</div>
        </div>
    </div>
</div>

<!-- === MAIN STATS === -->
<div class="row g-3 mb-4">
    <div class="col-md-3">
        <div class="stat-card blue">
            <h6>🎬 Movies</h6>
            <div class="stat-value">{{ $totalMovies }}</div>
            <div class="stat-label"><span class="badge bg-success">{{ $showingMovies }}</span> <span class="badge bg-info">{{ $comingSoonMovies }}</span></div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="stat-card green">
            <h6>🏥 Infrastructure</h6>
            <div class="stat-value">{{ $totalTheaters }}</div>
            <div class="stat-label">Theaters • {{ $totalRooms }} Rooms</div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="stat-card orange">
            <h6>📺 Showtimes</h6>
            <div class="stat-value">{{ $totalShowtimes }}</div>
            <div class="stat-label">Active schedules</div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="stat-card red">
            <h6>👥 Users</h6>
            <div class="stat-value">{{ $totalUsers }}</div>
            <div class="stat-label">{{ $activeUsers }} Regular Users</div>
        </div>
    </div>
</div>

<!-- === BOOKINGS === -->
<div class="row g-3 mb-4">
    <div class="col-md-4">
        <div class="stat-card green">
            <h6>✅ Confirmed</h6>
            <div class="stat-value">{{ $confirmedBookings }}</div>
            <div class="stat-label">{{ $totalBookings > 0 ? round($confirmedBookings/$totalBookings*100) : 0 }}% success rate</div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="stat-card blue">
            <h6>📦 Total Bookings</h6>
            <div class="stat-value">{{ $totalBookings }}</div>
            <div class="stat-label">All transactions</div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="stat-card red">
            <h6>❌ Cancelled</h6>
            <div class="stat-value">{{ $cancelledBookings }}</div>
            <div class="stat-label">{{ $totalBookings > 0 ? round($cancelledBookings/$totalBookings*100) : 0 }}% cancellation</div>
        </div>
    </div>
</div>

<!-- === DATA TABLES === -->
<div class="row g-3">
    <div class="col-md-6">
        <div class="table-wrapper">
            <div class="table-title">📋 Recent Bookings</div>
            <table class="table table-sm table-hover mb-0">
                <thead class="table-light">
                    <tr>
                        <th>User</th>
                        <th>Movie</th>
                        <th>Status</th>
                        <th>Date</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($recentBookings as $booking)
                        <tr>
                            <td>{{ substr($booking->user->name ?? 'N/A', 0, 15) }}</td>
                            <td>{{ substr($booking->showtime->movie->title ?? 'N/A', 0, 15) }}</td>
                            <td>
                                @if($booking->status === 'confirmed')
                                    <span class="badge bg-success">✓</span>
                                @elseif($booking->status === 'pending')
                                    <span class="badge bg-warning">⏳</span>
                                @else
                                    <span class="badge bg-danger">✕</span>
                                @endif
                            </td>
                            <td>{{ $booking->created_at->format('d/m H:i') }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="text-center text-muted py-2">No data</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div class="col-md-6">
        <div class="table-wrapper">
            <div class="table-title">🎬 Popular Movies</div>
            <table class="table table-sm table-hover mb-0">
                <thead class="table-light">
                    <tr>
                        <th>Title</th>
                        <th>Status</th>
                        <th>Showtimes</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($popularMovies as $movie)
                        <tr>
                            <td>{{ substr($movie->title, 0, 18) }}</td>
                            <td>
                                <span class="badge {{ $movie->status === 'showing' ? 'bg-success' : 'bg-info' }}">
                                    {{ $movie->status === 'showing' ? 'Showing' : 'Coming' }}
                                </span>
                            </td>
                            <td><strong>{{ $movie->showtimes_count }}</strong></td>
                            <td>
                                <a href="{{ route('admin.movies.edit', $movie->id) }}" class="btn btn-sm btn-primary">Edit</a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="text-center text-muted py-2">No data</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- === RECENT MOVIES === -->
<div class="table-wrapper mt-4">
    <div class="table-title">🆕 Recently Added</div>
    <table class="table table-sm table-hover mb-0">
        <thead class="table-light">
            <tr>
                <th>Title</th>
                <th>Duration</th>
                <th>Status</th>
                <th>Release</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse($recentMovies as $movie)
                <tr>
                    <td>{{ $movie->title }}</td>
                    <td>{{ $movie->duration }} min</td>
                    <td>
                        <span class="badge {{ $movie->status === 'showing' ? 'bg-success' : 'bg-info' }}">
                            {{ $movie->status === 'showing' ? 'Showing' : 'Coming' }}
                        </span>
                    </td>
                    <td>{{ $movie->release_date ? \Carbon\Carbon::parse($movie->release_date)->format('d/m/Y') : 'N/A' }}</td>
                    <td>
                        <a href="{{ route('admin.movies.edit', $movie->id) }}" class="btn btn-sm btn-warning">Edit</a>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" class="text-center text-muted py-2">No movies yet</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
