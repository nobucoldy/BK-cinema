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

    .detail-card {
        background: white;
        border-radius: 12px;
        padding: 25px;
        margin-bottom: 20px;
        border: 1px solid #e5e7eb;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
    }

    .section-title {
        font-size: 1.1rem;
        font-weight: 700;
        color: #1f2937;
        margin-bottom: 20px;
        padding-bottom: 12px;
        border-bottom: 2px solid #f3f4f6;
    }

    .info-grid {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 20px;
        margin-bottom: 20px;
    }
    .info-item {
        display: flex;
        flex-direction: column;
    }
    .info-label {
        font-size: 0.8rem;
        color: #666;
        text-transform: uppercase;
        font-weight: 600;
        margin-bottom: 5px;
    }
    .info-value {
        font-size: 0.95rem;
        color: #1f2937;
        font-weight: 500;
    }

    .status-badge {
        display: inline-block;
        padding: 6px 12px;
        border-radius: 20px;
        font-size: 0.8rem;
        font-weight: 600;
        text-transform: uppercase;
        width: fit-content;
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

    .seats-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
        gap: 12px;
        margin-bottom: 20px;
    }
    .seat-item {
        background: #f9fafb;
        border: 1px solid #e5e7eb;
        border-radius: 8px;
        padding: 12px;
        text-align: center;
    }
    .seat-code {
        font-weight: 700;
        color: #1f2937;
        font-size: 1rem;
        margin-bottom: 5px;
    }
    .seat-price {
        font-size: 0.85rem;
        color: #ff3131;
        font-weight: 600;
    }
    .seat-type {
        font-size: 0.7rem;
        color: #999;
        text-transform: uppercase;
    }

    .summary-box {
        background: linear-gradient(135deg, #f9fafb 0%, #f3f4f6 100%);
        border: 2px solid #e5e7eb;
        border-radius: 12px;
        padding: 20px;
        margin: 20px 0;
    }
    .summary-row {
        display: flex;
        justify-content: space-between;
        margin-bottom: 15px;
        font-size: 0.95rem;
    }
    .summary-row:last-child {
        margin-bottom: 0;
        padding-top: 15px;
        border-top: 2px solid #d1d5db;
        font-size: 1.2rem;
        font-weight: 700;
    }
    .summary-label {
        color: #666;
    }
    .summary-value {
        color: #1f2937;
        font-weight: 600;
    }
    .summary-total {
        color: #ff3131;
    }

    .action-buttons {
        display: flex;
        gap: 12px;
        margin-top: 20px;
    }
    .btn-back {
        padding: 10px 20px;
        border-radius: 8px;
        border: 1px solid #d1d5db;
        background: white;
        color: #333;
        font-weight: 600;
        font-size: 0.9rem;
        cursor: pointer;
        transition: all 0.3s;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 8px;
    }
    .btn-back:hover {
        background: #f3f4f6;
        border-color: #9ca3af;
    }

    .btn-cancel {
        padding: 10px 20px;
        border-radius: 8px;
        border: 1px solid #dc2626;
        background: white;
        color: #dc2626;
        font-weight: 600;
        font-size: 0.9rem;
        cursor: pointer;
        transition: all 0.3s;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 8px;
    }
    .btn-cancel:hover {
        background: #dc2626;
        color: white;
    }

    @media (max-width: 768px) {
        .info-grid {
            grid-template-columns: 1fr;
        }
        .seats-grid {
            grid-template-columns: repeat(auto-fit, minmax(120px, 1fr));
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
            <li class="breadcrumb-item">
                <a href="{{ route('booking.history') }}">Lịch sử đặt vé</a>
            </li>
            <li class="">Chi tiết đặt vé #{{ $booking->id }}</li>
        </ol>
    </nav>

    <div class="container" style="max-width: 900px;">
        <h2 style="margin-bottom: 30px; font-weight: 800; color: #1f2937;">
            <i class=""></i> Chi tiết đặt vé #{{ $booking->id }}
        </h2>

        {{-- BOOKING STATUS --}}
        <div class="detail-card">
            <div class="info-grid">
                <div class="info-item">
                    <span class="info-label">Trạng thái đặt vé</span>
                    <span class="status-badge status-{{ $booking->status }}">
                        @if($booking->status == 'confirmed')
                            <i class="bi bi-check-circle"></i> Đã xác nhận
                        @elseif($booking->status == 'pending')
                            <i class="bi bi-clock"></i> Chờ xử lý
                        @else
                            <i class="bi bi-x-circle"></i> Đã hủy
                        @endif
                    </span>
                </div>
                <div class="info-item">
                    <span class="info-label">Ngày đặt</span>
                    <span class="info-value">{{ \Carbon\Carbon::parse($booking->created_at)->format('d/m/Y H:i') }}</span>
                </div>
            </div>
        </div>

        {{-- MOVIE INFO --}}
        <div class="detail-card">
            <h5 class="section-title">Thông tin phim</h5>
            <div class="info-grid">
                <div class="info-item">
                    <span class="info-label">Tên phim</span>
                    <span class="info-value">{{ $booking->showtime->movie->title }}</span>
                </div>
                <div class="info-item">
                    <span class="info-label">Độ tuổi</span>
                    <span class="info-value">
                        @if($booking->showtime->movie->rated)
                            {{ $booking->showtime->movie->rated }}
                        @else
                            P
                        @endif
                    </span>
                </div>
            </div>
        </div>

        {{-- SHOWTIME INFO --}}
        <div class="detail-card">
            <h5 class="section-title">Thông tin suất chiếu</h5>
            <div class="info-grid">
                <div class="info-item">
                    <span class="info-label">Ngày chiếu</span>
                    <span class="info-value">{{ \Carbon\Carbon::parse($booking->showtime->show_date)->format('d/m/Y') }}</span>
                </div>
                <div class="info-item">
                    <span class="info-label">Giờ chiếu</span>
                    <span class="info-value">{{ \Carbon\Carbon::parse($booking->showtime->start_time)->format('H:i') }}</span>
                </div>
                <div class="info-item">
                    <span class="info-label">Rạp chiếu</span>
                    <span class="info-value">{{ $booking->showtime->theater->name ?? 'N/A' }}</span>
                </div>
                <div class="info-item">
                    <span class="info-label">Phòng chiếu</span>
                    <span class="info-value">{{ $booking->showtime->room->name }}</span>
                </div>
                <div class="info-item">
                    <span class="info-label">Loại suất chiếu</span>
                    <span class="info-value">{{ $booking->showtime->screeningType->name ?? 'N/A' }}</span>
                </div>
            </div>
        </div>

        {{-- SEATS INFORMATION --}}
        <div class="detail-card">
            <h5 class="section-title">Ghế đã đặt</h5>
            
            @if($booking->bookingSeats->count() > 0)
                <div class="seats-grid">
                    @foreach($booking->bookingSeats as $bookingSeat)
                        <div class="seat-item">
                            <div class="seat-code">{{ $bookingSeat->seat->seat_code }}</div>
                            <div class="seat-price">{{ number_format($bookingSeat->price) }} đ</div>
                            <div class="seat-type">
                                @php
                                    $seatCode = $bookingSeat->seat->seat_code;
                                    // letter I indicates couple seats now
                                    if (strpos($seatCode, 'I') === 0) {
                                        echo 'Couple Seat';
                                    } elseif (in_array($seatCode[0], ['D', 'E', 'F', 'G', 'H'])) {
                                        echo 'VIP';
                                    } else {
                                        echo 'Regular';
                                    }
                                @endphp
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div style="text-align: center; padding: 20px; color: #999;">
                    Không có thông tin ghế
                </div>
            @endif
        </div>

        {{-- PAYMENT SUMMARY --}}
        <div class="detail-card">
            <h5 class="section-title">Tóm tắt thanh toán</h5>
            
            <div class="summary-box">
                <div class="summary-row">
                    <span class="summary-label">Số ghế</span>
                    <span class="summary-value">{{ $booking->bookingSeats->count() }} ghế</span>
                </div>
                <div class="summary-row">
                    <span class="summary-label">Thành tiền</span>
                    <span class="summary-value summary-total">{{ number_format($booking->total_amount) }} đ</span>
                </div>
            </div>
        </div>

        {{-- ACTION BUTTONS --}}
        <div class="action-buttons">
            <a href="{{ route('booking.history') }}" class="btn-back">
                <i class="bi bi-arrow-left"></i> Quay lại
            </a>

            @if($booking->status == 'confirmed')
                <form method="POST" action="{{ route('booking.cancel', $booking->id) }}"
                      style="display: inline;"
                      onsubmit="return confirm('Bạn có chắc chắn muốn hủy đặt vé này không?');">
                    @csrf
                    <button type="submit" class="btn-cancel">
                        <i class="bi bi-x-circle"></i> Hủy đặt vé
                    </button>
                </form>
            @endif
        </div>

    </div>
</div>

@endsection
