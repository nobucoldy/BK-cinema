@extends('layouts.app')

@section('content')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">

<style>
    .breadcrumb-container {
        height: 50px;
        display: flex;
        align-items: center;
        justify-content: center;
        background: transparent !important;
        border: none !important;
    }
    .breadcrumb {
        margin: 0 !important;
        padding: 0 !important;
        font-size: 13px;
        display: flex !important;
        align-items: center !important;
    }
    .breadcrumb-item + .breadcrumb-item::before {
        content: ">" !important;
        color: #ccc !important;
        padding: 0 10px;
        font-size: 11px;
    }
    .breadcrumb-item a { color: #888 !important; text-decoration: none; transition: 0.3s; }
    .breadcrumb-item a:hover { color: #ff69b4 !important; }
    .breadcrumb-item.active { color: #333; font-weight: 600; }

    .booking-card {
        background: white;
        border: 1px solid #e5e7eb;
        border-radius: 12px;
        padding: 20px;
        margin-bottom: 15px;
        transition: all 0.3s ease;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }
    .booking-card:hover {
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        transform: translateY(-2px);
    }

    .booking-info {
        flex: 1;
    }
    .movie-title {
        font-size: 1.1rem;
        font-weight: 700;
        color: #1f2937;
        margin-bottom: 8px;
    }
    .showtime-info {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 15px;
        margin-bottom: 10px;
    }
    .info-item {
        font-size: 0.85rem;
        color: #666;
    }
    .info-item strong {
        color: #333;
        display: block;
        font-size: 0.9rem;
    }

    .booking-right {
        display: flex;
        gap: 15px;
        align-items: center;
    }

    .amount-box {
        text-align: right;
        min-width: 120px;
    }
    .amount {
        font-size: 1.3rem;
        font-weight: 800;
        color: #ff3131;
    }
    .currency {
        font-size: 0.75rem;
        color: #999;
    }

    .status-badge {
        padding: 6px 12px;
        border-radius: 20px;
        font-size: 0.8rem;
        font-weight: 600;
        text-transform: uppercase;
    }
    .status-confirmed {
        background: #d1fae5;
        color: #065f46;
    }
    .status-pending {
        background: #fef3c7;
        color: #92400e;
    }
    .status-canceled {
        background: #fee2e2;
        color: #991b1b;
    }

    .btn-view {
        padding: 6px 16px;
        border-radius: 8px;
        border: 1px solid #d1d5db;
        background: white;
        color: #333;
        font-weight: 600;
        font-size: 0.85rem;
        cursor: pointer;
        transition: all 0.3s;
        text-decoration: none;
    }
    .btn-view:hover {
        background: #f3f4f6;
        border-color: #9ca3af;
        color: #1f2937;
    }

    .empty-state {
        text-align: center;
        padding: 60px 20px;
        color: #999;
    }
    .empty-state-icon {
        font-size: 3rem;
        margin-bottom: 15px;
        opacity: 0.5;
    }

    .filter-box {
        background: white;
        border-radius: 12px;
        padding: 20px;
        margin-bottom: 25px;
        border: 1px solid #e5e7eb;
    }
    .filter-row {
        display: grid;
        grid-template-columns: 1fr 1fr auto;
        gap: 15px;
        align-items: end;
    }
    @media (max-width: 768px) {
        .filter-row {
            grid-template-columns: 1fr;
        }
        .booking-card {
            flex-direction: column;
            align-items: flex-start;
        }
        .booking-right {
            margin-top: 15px;
            width: 100%;
            justify-content: space-between;
        }
        .amount-box {
            text-align: left;
        }
    }
</style>

<div class="container-fluid" style="padding: 20px 0;">
    {{-- BREADCRUMB --}}
    <nav class="breadcrumb-container">
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="{{ route('home') }}">Trang chủ</a>
            </li>
            <li class="breadcrumb-item active">Lịch sử đặt vé</li>
        </ol>
    </nav>

    <div class="container" style="max-width: 1000px;">
        <h2 style="margin-bottom: 30px; font-weight: 800; color: #1f2937;">
            <i class="bi bi-ticket-perforated"></i> Lịch sử đặt vé của bạn
        </h2>

        {{-- FILTER --}}
        <form method="GET" class="filter-box">
            <div class="filter-row">
                <div>
                    <label for="keyword" style="display: block; font-size: 0.8rem; color: #666; font-weight: 600; margin-bottom: 5px;">
                        Tìm kiếm phim
                    </label>
                    <input type="text"
                           id="keyword"
                           name="keyword"
                           class="form-control"
                           placeholder="Nhập tên phim..."
                           value="{{ request('keyword') }}"
                           style="border-radius: 8px; border: 1px solid #d1d5db;">
                </div>

                <div>
                    <label for="status" style="display: block; font-size: 0.8rem; color: #666; font-weight: 600; margin-bottom: 5px;">
                        Trạng thái
                    </label>
                    <select name="status" id="status" class="form-control" style="border-radius: 8px; border: 1px solid #d1d5db;">
                        <option value="">-- Tất cả trạng thái --</option>
                        <option value="pending" {{ request('status')=='pending'?'selected':'' }}>Chờ xử lý</option>
                        <option value="confirmed" {{ request('status')=='confirmed'?'selected':'' }}>Đã xác nhận</option>
                        <option value="canceled" {{ request('status')=='canceled'?'selected':'' }}>Đã hủy</option>
                    </select>
                </div>

                <div>
                    <button type="submit" class="btn btn-primary" style="border-radius: 8px; padding: 8px 20px;">
                        <i class="bi bi-search"></i> Tìm kiếm
                    </button>
                    <a href="{{ route('booking.history') }}" class="btn btn-secondary" style="border-radius: 8px; padding: 8px 20px;">
                        Đặt lại
                    </a>
                </div>
            </div>
        </form>

        {{-- BOOKINGS LIST --}}
        @if($bookings->count() > 0)
            <div>
                @foreach($bookings as $booking)
                    <div class="booking-card">
                        <div class="booking-info">
                            <div class="movie-title">
                                {{ $booking->showtime->movie->title }}
                            </div>
                            <div class="showtime-info">
                                <div class="info-item">
                                    <strong>Ngày chiếu</strong>
                                    {{ \Carbon\Carbon::parse($booking->showtime->show_date)->format('d/m/Y') }}
                                </div>
                                <div class="info-item">
                                    <strong>Giờ chiếu</strong>
                                    {{ \Carbon\Carbon::parse($booking->showtime->start_time)->format('H:i') }}
                                </div>
                                <div class="info-item">
                                    <strong>Phòng</strong>
                                    {{ $booking->showtime->room->name }}
                                </div>
                            </div>
                            <div style="font-size: 0.8rem; color: #999;">
                                Đặt ngày: {{ \Carbon\Carbon::parse($booking->created_at)->format('d/m/Y H:i') }}
                            </div>
                        </div>

                        <div class="booking-right">
                            <div class="amount-box">
                                <div class="amount">{{ number_format($booking->total_amount) }}</div>
                                <div class="currency">đ</div>
                            </div>

                            <div class="status-badge status-{{ $booking->status }}">
                                @if($booking->status == 'confirmed')
                                    <i class="bi bi-check-circle"></i> Đã xác nhận
                                @elseif($booking->status == 'pending')
                                    <i class="bi bi-clock"></i> Chờ xử lý
                                @else
                                    <i class="bi bi-x-circle"></i> Đã hủy
                                @endif
                            </div>

                            <a href="{{ route('booking.show', $booking->id) }}" class="btn-view">
                                Xem chi tiết <i class="bi bi-arrow-right"></i>
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>

            {{-- PAGINATION --}}
            <div style="margin-top: 30px;">
                {{ $bookings->links('pagination::bootstrap-5') }}
            </div>
        @else
            <div class="empty-state">
                <div class="empty-state-icon">
                    <i class="bi bi-inbox"></i>
                </div>
                <h4 style="color: #666; margin-bottom: 10px;">Chưa có đặt vé nào</h4>
                <p style="color: #999; margin-bottom: 20px;">Bạn chưa đặt vé cho bất kỳ bộ phim nào</p>
                <a href="{{ route('movies.index') }}" class="btn btn-primary">
                    Đặt vé ngay
                </a>
            </div>
        @endif

    </div>
</div>

@endsection
