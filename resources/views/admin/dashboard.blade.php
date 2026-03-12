@extends('layouts.admin')

@section('content')
<style>
    /* Modern Dashboard Styles */
    .dashboard-header {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        padding: 2rem;
        border-radius: 15px;
        margin-bottom: 2rem;
        box-shadow: 0 10px 30px rgba(102, 126, 234, 0.3);
    }

    .dashboard-title {
        font-size: 2.5rem;
        font-weight: 700;
        margin: 0;
        text-shadow: 0 2px 4px rgba(0,0,0,0.3);
    }

    .dashboard-date {
        font-size: 1.1rem;
        opacity: 0.9;
        margin-top: 0.5rem;
    }

    .stat-card {
        border-radius: 15px;
        padding: 25px;
        margin-bottom: 20px;
        border: none;
        background: white;
        box-shadow: 0 8px 25px rgba(0,0,0,0.1);
        transition: all 0.3s ease;
        position: relative;
        overflow: hidden;
    }

    .stat-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 4px;
        background: linear-gradient(90deg, #667eea, #764ba2);
    }

    .stat-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 15px 35px rgba(0,0,0,0.15);
    }

    .stat-card.blue {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
    }

    .stat-card.blue::before { background: linear-gradient(90deg, #5a67d8, #4c51bf); }

    .stat-card.green {
        background: linear-gradient(135deg, #48bb78 0%, #38a169 100%);
        color: white;
    }

    .stat-card.green::before { background: linear-gradient(90deg, #38a169, #2f855a); }

    .stat-card.orange {
        background: linear-gradient(135deg, #ed8936 0%, #dd6b20 100%);
        color: white;
    }

    .stat-card.orange::before { background: linear-gradient(90deg, #dd6b20, #c05621); }

    .stat-card.red {
        background: linear-gradient(135deg, #f56565 0%, #e53e3e 100%);
        color: white;
    }

    .stat-card.red::before { background: linear-gradient(90deg, #e53e3e, #c53030); }

    .stat-card .stat-icon {
        font-size: 2rem;
        margin-bottom: 10px;
        opacity: 0.9;
    }

    .stat-card h6 {
        font-size: 0.9rem;
        margin-bottom: 15px;
        font-weight: 600;
        opacity: 0.9;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .stat-card .stat-value {
        font-size: 2.2rem;
        font-weight: 800;
        margin-bottom: 5px;
        text-shadow: 0 2px 4px rgba(0,0,0,0.2);
    }

    .stat-card .stat-label {
        font-size: 0.85rem;
        opacity: 0.8;
        font-weight: 500;
    }

    .table-wrapper {
        background: white;
        border-radius: 15px;
        padding: 25px;
        box-shadow: 0 8px 25px rgba(0,0,0,0.1);
        margin-bottom: 25px;
        border: 1px solid rgba(0,0,0,0.05);
    }

    .table-title {
        font-weight: 700;
        font-size: 1.2rem;
        margin-bottom: 20px;
        color: #2d3748;
        display: flex;
        align-items: center;
        border-bottom: 3px solid #e2e8f0;
        padding-bottom: 15px;
    }

    .table-title::before {
        content: '';
        width: 6px;
        height: 24px;
        background: linear-gradient(135deg, #667eea, #764ba2);
        border-radius: 3px;
        margin-right: 12px;
    }

    .table {
        margin-bottom: 0;
    }

    .table thead th {
        background: linear-gradient(135deg, #f7fafc 0%, #edf2f7 100%);
        border: none;
        font-weight: 600;
        color: #4a5568;
        padding: 15px;
        text-transform: uppercase;
        font-size: 0.8rem;
        letter-spacing: 0.5px;
    }

    .table tbody tr {
        transition: all 0.2s ease;
        border-bottom: 1px solid #f1f5f9;
    }

    .table tbody tr:hover {
        background: linear-gradient(135deg, #f8fafc 0%, #f1f5f9 100%);
        transform: scale(1.01);
    }

    .table tbody td {
        padding: 15px;
        vertical-align: middle;
        color: #4a5568;
    }

    .badge {
        font-weight: 600;
        padding: 6px 12px;
        border-radius: 20px;
        font-size: 0.75rem;
    }

    .btn {
        border-radius: 8px;
        font-weight: 600;
        padding: 8px 16px;
        transition: all 0.2s ease;
    }

    .btn:hover {
        transform: translateY(-1px);
        box-shadow: 0 4px 12px rgba(0,0,0,0.15);
    }

    .btn-primary {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        border: none;
    }

    .btn-warning {
        background: linear-gradient(135deg, #ed8936 0%, #dd6b20 100%);
        border: none;
        color: white;
    }

    /* Animation for loading */
    @keyframes fadeInUp {
        from {
            opacity: 0;
            transform: translateY(30px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .stat-card, .table-wrapper {
        animation: fadeInUp 0.6s ease-out;
    }

    .stat-card:nth-child(1) { animation-delay: 0.1s; }
    .stat-card:nth-child(2) { animation-delay: 0.2s; }
    .stat-card:nth-child(3) { animation-delay: 0.3s; }
    .stat-card:nth-child(4) { animation-delay: 0.4s; }

    /* Responsive adjustments */
    @media (max-width: 768px) {
        .dashboard-header {
            padding: 1.5rem;
        }

        .dashboard-title {
            font-size: 2rem;
        }

        .stat-card {
            padding: 20px;
        }

        .stat-card .stat-value {
            font-size: 1.8rem;
        }
    }
</style>

<div class="dashboard-header">
    <h1 class="dashboard-title">🎯 Admin Dashboard</h1>
    <p class="dashboard-date">Today: {{ date('l, F j, Y') }}</p>
</div>

<!-- === REVENUE SECTION === -->
<div class="row g-4 mb-5">
    <div class="col-md-4">
        <div class="stat-card blue">
            <div class="stat-icon">💰</div>
            <h6>Total Revenue</h6>
            <div class="stat-value">{{ number_format($totalRevenue, 0) }} đ</div>
            <div class="stat-label">All time earnings</div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="stat-card green">
            <div class="stat-icon">📈</div>
            <h6>Today's Revenue</h6>
            <div class="stat-value">{{ number_format($todayRevenue, 0) }} đ</div>
            <div class="stat-label">{{ date('M j, Y') }}</div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="stat-card orange">
            <div class="stat-icon">📅</div>
            <h6>Monthly Revenue</h6>
            <div class="stat-value">{{ number_format($monthRevenue, 0) }} đ</div>
            <div class="stat-label">{{ date('F Y') }}</div>
        </div>
    </div>
</div>

<!-- === MAIN STATS === -->
<div class="row g-4 mb-5">
    <div class="col-md-3">
        <div class="stat-card blue">
            <div class="stat-icon">🎬</div>
            <h6>Movies</h6>
            <div class="stat-value">{{ $totalMovies }}</div>
            <div class="stat-label">
                <span class="badge bg-success me-1">{{ $showingMovies }}</span> Showing
                <span class="badge bg-info ms-2">{{ $comingSoonMovies }}</span> Coming Soon
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="stat-card green">
            <div class="stat-icon">🏢</div>
            <h6>Infrastructure</h6>
            <div class="stat-value">{{ $totalTheaters }}</div>
            <div class="stat-label">{{ $totalRooms }} Rooms Total</div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="stat-card orange">
            <div class="stat-icon">📺</div>
            <h6>Showtimes</h6>
            <div class="stat-value">{{ $totalShowtimes }}</div>
            <div class="stat-label">Active Schedules</div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="stat-card red">
            <div class="stat-icon">👥</div>
            <h6>Users</h6>
            <div class="stat-value">{{ $totalUsers }}</div>
            <div class="stat-label">{{ $activeUsers }} Active Users</div>
        </div>
    </div>
</div>

<!-- === BOOKINGS === -->
<div class="row g-4 mb-5">
    <div class="col-md-4">
        <div class="stat-card green">
            <div class="stat-icon">✅</div>
            <h6>Confirmed Bookings</h6>
            <div class="stat-value">{{ $confirmedBookings }}</div>
            <div class="stat-label">{{ $totalBookings > 0 ? round($confirmedBookings/$totalBookings*100) : 0 }}% Success Rate</div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="stat-card blue">
            <div class="stat-icon">📦</div>
            <h6>Total Bookings</h6>
            <div class="stat-value">{{ $totalBookings }}</div>
            <div class="stat-label">All Transactions</div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="stat-card red">
            <div class="stat-icon">❌</div>
            <h6>Canceled Bookings</h6>
            <div class="stat-value">{{ $canceledBookings }}</div>
            <div class="stat-label">{{ $totalBookings > 0 ? round($canceledBookings/$totalBookings*100) : 0 }}% Cancellation Rate</div>
        </div>
    </div>
</div>

<!-- === DATA TABLES === -->
<div class="row g-4">
    <div class="col-md-6">
        <div class="table-wrapper">
            <div class="table-title">📋 Recent Bookings</div>
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>User</th>
                            <th>Movie</th>
                            <th>Status</th>
                            <th>Date & Time</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($recentBookings as $booking)
                            <tr>
                                <td>
                                    <strong>{{ Str::limit($booking->user->name ?? 'N/A', 20) }}</strong>
                                </td>
                                <td>
                                    <span class="text-truncate d-inline-block" style="max-width: 150px;" title="{{ $booking->showtime->movie->title ?? 'N/A' }}">
                                        {{ Str::limit($booking->showtime->movie->title ?? 'N/A', 20) }}
                                    </span>
                                </td>
                                <td>
                                    @if($booking->status === 'confirmed')
                                        <span class="badge bg-success">✓ Confirmed</span>
                                    @elseif($booking->status === 'pending')
                                        <span class="badge bg-warning">⏳ Pending</span>
                                    @else
                                        <span class="badge bg-danger">✕ Canceled</span>
                                    @endif
                                </td>
                                <td>
                                    <small class="text-muted">{{ $booking->created_at->format('M j, H:i') }}</small>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="text-center py-4">
                                    <div class="text-muted">
                                        <i class="fas fa-inbox fa-2x mb-2"></i>
                                        <br>No recent bookings
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="col-md-6">
        <div class="table-wrapper">
            <div class="table-title">🎬 Popular Movies</div>
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>Title</th>
                            <th>Status</th>
                            <th>Showtimes</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($popularMovies as $movie)
                            <tr>
                                <td>
                                    <strong>{{ Str::limit($movie->title, 25) }}</strong>
                                </td>
                                <td>
                                    <span class="badge {{ $movie->status === 'showing' ? 'bg-success' : 'bg-info' }}">
                                        {{ $movie->status === 'showing' ? '🎭 Showing' : '🎬 Coming Soon' }}
                                    </span>
                                </td>
                                <td>
                                    <span class="badge bg-primary">{{ $movie->showtimes_count }} shows</span>
                                </td>
                                <td>
                                    <a href="{{ route('admin.movies.edit', $movie->id) }}" class="btn btn-sm btn-primary">
                                        <i class="fas fa-edit"></i> Edit
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="text-center py-4">
                                    <div class="text-muted">
                                        <i class="fas fa-film fa-2x mb-2"></i>
                                        <br>No movies available
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- === RECENT MOVIES === -->
<div class="table-wrapper mt-4">
    <div class="table-title">🆕 Recently Added Movies</div>
    <div class="table-responsive">
        <table class="table table-hover">
            <thead>
                <tr>
                    <th>Title</th>
                    <th>Duration</th>
                    <th>Status</th>
                    <th>Release Date</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($recentMovies as $movie)
                    <tr>
                        <td>
                            <strong>{{ $movie->title }}</strong>
                        </td>
                        <td>
                            <span class="badge bg-secondary">{{ $movie->duration }} min</span>
                        </td>
                        <td>
                            <span class="badge {{ $movie->status === 'showing' ? 'bg-success' : 'bg-info' }}">
                                {{ $movie->status === 'showing' ? '🎭 Showing' : '🎬 Coming Soon' }}
                            </span>
                        </td>
                        <td>
                            {{ $movie->release_date ? \Carbon\Carbon::parse($movie->release_date)->format('M j, Y') : 'N/A' }}
                        </td>
                        <td>
                            <a href="{{ route('admin.movies.edit', $movie->id) }}" class="btn btn-sm btn-warning">
                                <i class="fas fa-edit"></i> Edit
                            </a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="text-center py-4">
                            <div class="text-muted">
                                <i class="fas fa-plus-circle fa-2x mb-2"></i>
                                <br>No movies added yet
                            </div>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
