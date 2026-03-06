<!DOCTYPE html>
<html lang="vi">
<head>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Book Tickets - BKL Cinema</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700;800&display=swap" rel="stylesheet">
    
    <style>
        body { margin: 0; padding: 0; font-family: 'Inter', sans-serif; background-color: #f4f4f9; overflow-x: hidden; }
        .booking-page { padding: 30px 0 140px 0; min-height: 100vh; position: relative; }

        /* SIDEBAR */
        .side-menu { position: fixed; top: 50%; transform: translateY(-50%); display: flex; flex-direction: column; gap: 15px; z-index: 1040; transition: 0.3s ease; }
        .side-menu.left { left: 30px; }
        .side-menu.right { right: 30px; }
        .menu-btn { width: 50px; height: 50px; background: white; border: none; border-radius: 15px; box-shadow: 0 4px 15px rgba(0,0,0,0.1); display: flex; align-items: center; justify-content: center; font-size: 1.2rem; transition: 0.3s; cursor: pointer; text-decoration: none; color: #333; }
        .menu-btn:hover { background: #90ff00; color: #000; transform: scale(1.1); }

        /* TOAST */
        .toast-container { position: fixed; top: 20px; right: 20px; z-index: 999999; display: flex; flex-direction: column; gap: 12px; pointer-events: none; }
        .custom-toast { pointer-events: auto; background: #1e293b; color: white; padding: 15px 20px; border-radius: 12px; min-width: 320px; box-shadow: 0 10px 30px rgba(0,0,0,0.5); display: flex; align-items: center; justify-content: space-between; position: relative; overflow: hidden; border-left: 5px solid #ff3131; animation: slideIn 0.4s ease-out forwards; }
        @keyframes slideIn { from { transform: translateX(120%); } to { transform: translateX(0); } }
        @keyframes slideOut { from { transform: translateX(0); opacity: 1; } to { transform: translateX(120%); opacity: 0; } }
        .close-btn { background: transparent !important; border: none !important; color: #94a3b8; font-size: 1.4rem; cursor: pointer; padding: 0 0 0 10px; line-height: 1; outline: none !important; box-shadow: none !important; }
        .toast-progress { position: absolute; bottom: 0; left: 0; height: 3px; background: #ff3131; width: 100%; animation: toastProgress 3s linear forwards; }
        @keyframes toastProgress { from { width: 100%; } to { width: 0%; } }
        
        .movie-poster{
            width: auto; height: 220px; border-radius: 12px; object-fit: cover; margin-right: 20px;
        }

        /* HEADER & INFO */
        .ticket-header { background: white; border-radius: 20px; padding: 25px; display: flex; gap: 30px; box-shadow: 0 4px 12px rgba(0,0,0,0.05); margin-bottom: 30px; border-left: 8px solid #90ff00; }
        .movie-title { font-size: 1.6rem; font-weight: 800; color: #1a1a1a; margin-bottom: 15px; }
        .info-details-grid { display: grid; grid-template-columns: repeat(5, 1fr); gap: 15px; }
        .info-box { background: #f8f9fa; padding: 10px; border-radius: 10px; border: 1px solid #eee; }
        .info-box label { display: block; font-size: 0.65rem; color: #888; text-transform: uppercase; font-weight: 700; }
        .info-box span { display: block; font-size: 0.9rem; font-weight: 700; color: #333; }

        /* LEGEND - ĐÃ SỬA: CÁC Ô CHÚ THÍCH BẰNG NHAU */
        .seat-legend { display: flex; justify-content: center; gap: 40px; margin: 0 auto 40px; padding: 15px 40px; background: #fff; border-radius: 20px; width: fit-content; box-shadow: 0 2px 10px rgba(0,0,0,0.05); }
        .legend-item { display: flex; flex-direction: column; align-items: center; gap: 2px; }
        .legend-label { display: flex; align-items: center; gap: 8px; font-size: 0.8rem; font-weight: 700; color: #444; }
        .legend-price { font-size: 0.7rem; color: #ff3131; font-weight: 600; }
        .seat-demo { width: 20px !important; 
    height: 20px !important; 
    border-radius: 5px; }

        /* SCREEN */
        .screen-container { width: 100%; perspective: 500px; margin-bottom: 60px; text-align: center; }
        .screen { width: 70%; height: 10px; background: #ddd; margin: 0 auto; transform: rotateX(-30deg); box-shadow: 0 15px 25px rgba(0,0,0,0.1); border-radius: 5px; }
        .screen-text { color: #bbb; font-size: 0.75rem; margin-top: 20px; letter-spacing: 10px; font-weight: 800; }

        /* SEAT GRID */
        .zoom-wrapper { width: 100%; display: flex; justify-content: center; }
        #main-booking-area { transition: transform 0.3s ease; transform-origin: top center; width: 100%; }
        .seat-grid { display: flex; flex-direction: column; align-items: center; gap: 15px; }
        .seat-row { display: flex; gap: 8px; align-items: center; }
        .seat-row .seat:nth-child(3), .seat-row .seat:nth-child(8) { margin-right: 35px; }

        /* SEAT STYLES - ĐÃ CẬP NHẬT KÍCH THƯỚC GHẾ ĐÔI */
        .seat { width: 40px; height: 40px; border-radius: 8px; display: flex; align-items: center; justify-content: center; font-size: 0.7rem; font-weight: 700; cursor: pointer; transition: 0.2s; }
        .seat-normal { background: #90ff00; color: #000; } 
        .seat-vip { background: #ff4d4d; color: white; }    
        .seat-double { background: #ff66cc; color: white; width: 90px; height: 40px; } /* Ghế đôi thực tế to hơn */
        .seat-selected { background: #1a1a1a !important; color: #fff !important; transform: scale(1.1); box-shadow: 0 5px 12px rgba(0,0,0,0.2); }
        .seat-sold { background: #e0e0e0 !important; color: #aaa !important; cursor: not-allowed; } 

        /* MODALS & CHECKOUT (GIỮ NGUYÊN) */
        .combo-modal-item { background: #f8f9fa; border-radius: 15px; padding: 15px; margin-bottom: 15px; display: flex; align-items: center; border: 1px solid #eee; }
        .btn-qty-vnpay { width: 32px; height: 32px; border-radius: 8px; border: none; background: #90ff00; color: #000; font-weight: 800; font-size: 1.1rem; }
        .vnpay-blue-btn { background-color: #0056b3 !important; color: white !important; border: none !important; border-radius: 10px !important; padding: 12px 45px !important; font-weight: bold !important; transition: 0.3s; }
        .checkout-card { position: fixed; bottom: 0; left: 0; right: 0; background: white; padding: 12px 10%; box-shadow: 0 -8px 25px rgba(0,0,0,0.08); border-top: 1px solid #eee; z-index: 1000; }
        .total-price { color: #000; font-size: 1.5rem; font-weight: 800; }
        .btn-next-step { border-radius: 10px; background: #0056b3; color: white; border: none; padding: 10px 45px; font-weight: bold; transition: 0.3s; }
        .btn-next-step:hover { background: #2a7fd1 !important; transform: translateY(-2px); }
        .summary-item { display: flex; justify-content: space-between; margin-bottom: 10px; font-size: 0.9rem; }
        .summary-label { color: #666; font-weight: 600; }
        .summary-value { font-weight: 700; color: #1a1a1a; }
        .payment-choice-card { border: 2px solid #eee; border-radius: 16px; padding: 15px; cursor: pointer; transition: all 0.3s ease; text-align: center; background: white; height: 100%; }
        .payment-choice-card.active { border-color: #0056b3; background: #f0f7ff; color: #0056b3; box-shadow: 0 5px 15px rgba(0,86,179,0.1); }
        .payment-choice-card i { font-size: 2rem; display: block; margin-bottom: 10px; }
        .payment-choice-card span { font-size: 0.75rem; font-weight: 800; text-transform: uppercase; }
        .qr-frame-box { background: white; padding: 15px; border-radius: 20px; border: 2px solid #e0e0e0; display: inline-block; box-shadow: 0 4px 15px rgba(0,0,0,0.05); }
        #successModalOverlay { display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.85); z-index: 100000; align-items: center; justify-content: center; backdrop-filter: blur(10px); }
        .success-box-popup { background: #90ff00; padding: 60px 40px; border-radius: 40px; text-align: center; box-shadow: 0 0 60px rgba(144, 255, 0, 0.4); border: 4px solid #000; max-width: 480px; animation: zoomInPopup 0.5s cubic-bezier(0.34, 1.56, 0.64, 1); }
        @keyframes zoomInPopup { from { transform: scale(0.3); opacity: 0; } to { transform: scale(1); opacity: 1; } }
    </style>
</head>
<body>

<div class="booking-page">
    <div class="toast-container" id="toast-wrapper"></div>

    <div class="side-menu left">
        <button class="menu-btn" onclick="window.history.back()"><i class="bi bi-chevron-left"></i></button>
        <button type="button" class="menu-btn" data-bs-toggle="modal" data-bs-target="#cancelModal"><i class="bi bi-x-lg"></i></button>
    </div>

    <div class="side-menu right">
        <button class="menu-btn" onclick="zoomGrid(0.1)"><i class="bi bi-plus-lg"></i></button>
        <button class="menu-btn" onclick="zoomGrid(-0.1)"><i class="bi bi-dash-lg"></i></button>
        <button class="menu-btn" onclick="window.location.reload()"><i class="bi bi-arrow-clockwise"></i></button>
    </div>

    <div class="container">
        <div class="ticket-header">
            <img src="{{ Storage::url($showtime->movie->poster_url) }}" class="movie-poster">
            <div class="flex-grow-1">
                <div style="color: #d63384; font-weight: 600;">BKL CINEMA HÀ ĐÔNG</div>
                <h2 class="movie-title">{{ $showtime->movie->title }}</h2>
                <div style="margin-top: 10px; font-size: 0.9rem; color: #666;">
                    @if($showtime->movie->director)
                        <p class="mb-1"><strong>Director:</strong> {{ $showtime->movie->director->name }}</p>
                    @endif
                    @if($showtime->movie->genres->count() > 0)
                        <p class="mb-1"><strong>Genre:</strong> 
                            @foreach($showtime->movie->genres as $genre)
                                {{ $genre->name }}@if(!$loop->last), @endif
                            @endforeach
                        </p>
                    @endif
                    @if($showtime->movie->actors->count() > 0)
                        <p class="mb-0"><strong>Cast:</strong> 
                            @foreach($showtime->movie->actors as $actor)
                                {{ $actor->name }}@if(!$loop->last), @endif
                            @endforeach
                        </p>
                    @endif
                </div>
                <div class="info-details-grid mt-3">
    <div class="info-box">
    <label>Showtime</label>
    @php
        $start = \Carbon\Carbon::parse($showtime->start_time);
        $end   = $start->copy()->addMinutes($showtime->movie->duration);
    @endphp
    <span>{{ $start->format('H:i') }} ~ {{ $end->format('H:i') }}</span>
</div>

    <div class="info-box">
        <label>Date</label>
        <span>{{ \Carbon\Carbon::parse($showtime->show_date)->format('d/m/Y') }}</span>
    </div>

    <div class="info-box">
        <label>Room</label>
        <span>{{ $showtime->room->name }}</span>
    </div>

    <div class="info-box">
        <label>Theater</label>
        <span>{{ $showtime->room->theater->name }}</span>
    </div>

    <div class="info-box">
    <label>Type</label>
    <span>{{ $showtime->screeningType->label }}</span>
</div>

</div>


            </div>
        </div>
@php
    $extra = $showtime->screeningType->extra_price ?? 0;
@endphp
        <div class="seat-legend">
            <div class="legend-item">
    <div class="legend-label">
        <div class="seat-demo seat-normal"></div>Regular
    </div>
    <div class="legend-price">{{ number_format(36000 + $extra) }}đ</div>
</div>

<div class="legend-item">
    <div class="legend-label">
        <div class="seat-demo seat-vip"></div>VIP
    </div>
    <div class="legend-price">{{ number_format(49000 + $extra) }}đ</div>
</div>

<div class="legend-item">
    <div class="legend-label">
        <div class="seat-demo seat-double"></div>Couple
    </div>
    <div class="legend-price">{{ number_format(90000 + $extra) }}đ</div>
</div>
<div class="legend-item"><div class="legend-label"><div class="seat-demo" style="background:#1a1a1a"></div>Selected</div></div>
            <div class="legend-item"><div class="legend-label"><div class="seat-demo seat-sold"></div>Sold</div></div>
        </div>

        <div class="zoom-wrapper">
            <div id="main-booking-area">
                <div class="screen-container"><div class="screen"></div><div class="screen-text">SCREEN</div></div>
                <div class="seat-grid" id="seat-grid">
                    @php 
                        $rows = ['A', 'B', 'C', 'D', 'E', 'F', 'G', 'H']; 
                        $normalRows = ['A', 'B', 'C']; 
                        $soldSeatCodes = $soldSeatCodes ?? []; 
                        $seatMap = []; 
                        foreach($showtime->room->seats as $seat) {
                            $seatMap[$seat->seat_code] = $seat->id;
                        }
                    @endphp
                    
                    {{-- GHẾ THƯỜNG & VIP --}}
                    @foreach($rows as $row)
                        <div class="seat-row">
                            @for($i=1; $i<=10; $i++)
                                @php 
                                    $code = $row . sprintf("%02d", $i); 
                                    $isNormal = in_array($row, $normalRows); 
                                    $type = $isNormal ? 'seat-normal' : 'seat-vip'; 
                                    $basePrice = $isNormal ? 36000 : 49000;
                                    $price = $basePrice + $showtime->screeningType->extra_price;
                                    $isSold = in_array($code, $soldSeatCodes); 
                                    $seatId = $seatMap[$code] ?? null;
                                @endphp
                                @if($seatId)
                                    <div class="seat {{ $isSold ? 'seat-sold' : $type }}" data-id="{{ $seatId }}" data-name="{{ $code }}" data-price="{{ $price }}">{{ $code }}</div>
                                @else
                                    <div class="seat seat-sold" data-name="{{ $code }}">{{ $code }}</div>
                                @endif
                            @endfor
                        </div>
                    @endforeach

                    {{-- GHẾ ĐÔI - DÒNG CUỐI CÙNG --}}
                    <div class="seat-row mt-4">
                        @for($i=1; $i<=5; $i++)
                            @php 
                                $code = "L" . sprintf("%02d", $i); 
                                $price = 90000 + $showtime->screeningType->extra_price;
                                $isSold = in_array($code, $soldSeatCodes); 
                                $seatId = $seatMap[$code] ?? null;
                            @endphp
                            @if($seatId)
                                <div class="seat {{ $isSold ? 'seat-sold' : 'seat-double' }}" data-id="{{ $seatId }}" data-name="{{ $code }}" data-price="{{ $price }}">{{ $code }}</div>
                            @else
                                <div class="seat seat-sold" style="width: 88px;">{{ $code }}</div>
                            @endif
                        @endfor
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="checkout-card">
        <div class="d-flex justify-content-between align-items-center w-100">
            <div>
                <div class="text-muted small" id="seat-counter">Selected 0 seats:</div>
                <div id="display-seats" class="fw-bold text-dark fs-5">-</div>
            </div>
            <div class="d-flex align-items-center gap-4">
                <div class="text-end">
                    <div class="text-muted small">Total Ticket Price:</div>
                    <div id="display-total-tickets" class="total-price">0đ</div>
                </div>
                <button id="next-button" class="btn btn-next-step shadow-sm">Continue</button>
            </div>
        </div>
    </div>
</div>

{{-- MODALS GIỮ NGUYÊN --}}
<div class="modal fade" id="comboModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content border-0 rounded-4 shadow">
            <div class="modal-header border-0 pb-0">
                <h5 class="modal-title w-100 text-center fw-bold fs-4">Select popcorn and drink combo</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body p-4">
                <div class="combo-modal-item" data-name="Combo Solo" data-price="103000">
                    <img src="https://momo.vn/su-kien/cinema/images/details/combo-1.png" width="90" class="rounded">
                    <div class="ms-3 flex-grow-1">
                        <h6 class="fw-bold mb-1">COMBO SOLO</h6>
                        <small class="text-muted d-block mb-1">1 Large Popcorn + 1 Large Soft Drink</small>
                        <span class="fw-bold text-danger">103.000đ</span>
                    </div>
                    <div class="d-flex align-items-center gap-2">
                        <button class="btn-qty-vnpay minus">-</button>
                        <span class="qty fw-bold mx-2">0</span>
                        <button class="btn-qty-vnpay plus">+</button>
                    </div>
                </div>
                <div class="combo-modal-item" data-name="Combo Couple" data-price="135000">
                    <img src="https://momo.vn/su-kien/cinema/images/details/combo-2.png" width="90" class="rounded">
                    <div class="ms-3 flex-grow-1">
                        <h6 class="fw-bold mb-1">COMBO COUPLE</h6>
                        <small class="text-muted d-block mb-1">1 Large Popcorn + 2 Large Soft Drinks</small>
                        <span class="fw-bold text-danger">135.000đ</span>
                    </div>
                    <div class="d-flex align-items-center gap-2">
                        <button class="btn-qty-vnpay minus">-</button>
                        <span class="qty fw-bold mx-2">0</span>
                        <button class="btn-qty-vnpay plus">+</button>
                    </div>
                </div>

                <div class="d-flex justify-content-between align-items-center mt-4 pt-3 border-top">
                    <div>
                        <div class="text-muted small">Total Food & Drinks Price</div>
                        <div id="modal-combo-total" class="fw-bold fs-4">0đ</div>
                    </div>
                    <button class="btn vnpay-blue-btn" id="btn-to-payment">Continue</button>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="paymentModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered">
        <div class="modal-content border-0 rounded-4 shadow-lg overflow-hidden position-relative">
            <button type="button" class="btn-close position-absolute" data-bs-dismiss="modal" style="top: 20px; right: 20px; z-index: 10;"></button>

            <div class="modal-body p-0 d-flex flex-column flex-md-row">
                <div class="p-4 flex-grow-1 bg-white border-end">
                    <h5 class="fw-bold mb-4">BOOKING CONFIRMATION</h5>
                    <p class="mb-1 small">Movie: <strong>{{ $showtime->movie->title }}</strong></p>
                    <p class="mb-1 small">Theater: <strong>BKL Cinema Ha Dong</strong></p>
                    <p class="mb-4 small">Showtime: <strong>{{ \Carbon\Carbon::parse($showtime->start_time)->format('H:i') }} | {{ \Carbon\Carbon::parse($showtime->show_date)->format('d/m/Y') }}</strong></p>

                    <h6 class="fw-bold border-bottom pb-2 mb-3">Selected Seats</h6>
                    <div id="final-seats-list" class="mb-3"></div>

                    <h6 class="fw-bold border-bottom pb-2 mb-3 mt-4">Food & Drinks</h6>
                    <div id="final-combos-list" class="mb-3"></div>

                    <div class="mt-4 pt-3 border-top">
                        <div class="d-flex justify-content-between align-items-center">
                            <span class="fw-bold fs-5">TOTAL PAYMENT</span>
                            <span class="fw-bold text-danger fs-3" id="final-total-all">0đ</span>
                        </div>
                    </div>
                </div>

                <div class="p-4 bg-light" style="min-width: 480px;">
                    <p class="fw-bold mb-4 text-center fs-5">PAYMENT METHOD</p>
                    <div class="row g-3 mb-4">
                        <div class="col-6">
                            <div class="payment-choice-card active" id="tab-qr-btn" onclick="togglePayTab('qr')">
                                <i class="bi bi-qr-code-scan"></i>
                                <span>Scan QR Code</span>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="payment-choice-card" id="tab-app-btn" onclick="togglePayTab('app')">
                                <i class="bi bi-phone-vibrate"></i>
                                <span>Banking App</span>
                            </div>
                        </div>
                    </div>

                    <div id="view-qr" class="text-center">
                        <div class="qr-frame-box mb-3">
                            <img id="qr-image" src="" style="width: 210px; height: 210px; object-fit: contain;">
                        </div>
                        <p class="text-muted small px-4 mb-4">Open Banking App or E-wallet to scan payment code</p>
                        <button class="btn btn-success w-100 py-3 rounded-3 shadow-sm fw-bold mb-3" onclick="simulateFinalSuccess()">
                            <i class="bi bi-patch-check-fill me-2"></i>CONFIRM SCANNED
                        </button>
                        <button class="btn btn-link text-decoration-none text-muted fw-bold small" onclick="goBackToCombo()">
                            <i class="bi bi-arrow-left me-1"></i> BACK TO COMBO
                        </button>
                    </div>

                    <div id="view-app" class="text-center d-none" style="padding-top: 60px;">
                        <div style="font-size: 5rem; margin-bottom: 20px;">🚧</div>
                        <h4 class="fw-bold">COMING SOON</h4>
                        <p class="text-muted px-4 small">Direct app integration feature is being developed. Please use QR Code Scan.</p>
                        <button class="btn btn-outline-primary btn-sm mt-3 fw-bold" onclick="togglePayTab('qr')">USE QR CODE SCAN</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div id="successModalOverlay">
    <div class="success-box-popup">
        <div style="font-size: 6rem; margin-bottom: 20px;">🎟️</div>
        <h2 style="font-weight: 900; color: #000; margin-bottom: 15px; letter-spacing: -2px; text-transform: uppercase;">Booking Successful!</h2>
        <p style="color: #000; font-weight: 600; font-size: 1.1rem; margin-bottom: 35px; line-height: 1.5;">Thank you for choosing BKL Cinema. We wish you an amazing movie experience!</p>
        <button onclick="location.href='/movies/status'" style="background: #000; border: none; padding: 18px 50px; border-radius: 20px; color: #90ff00; font-weight: 800; font-size: 1rem; cursor: pointer; transition: 0.3s; width: 100%;">OK!</button>
    </div>
</div>

<div class="modal fade" id="cancelModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg" style="border-radius: 15px;">
            <div class="modal-body p-4 text-center">
                <h5 class="fw-bold mb-3">Are you sure you want to cancel this transaction?</h5>
                <p class="text-muted small mb-4">Cancel this ticket purchase and go back to view other movies?</p>
                <div class="d-flex gap-3 justify-content-center">
                    <button type="button" class="btn btn-outline-secondary px-4 fw-bold" data-bs-dismiss="modal">Continue Booking</button>
                    <a href="/movies/status" class="btn btn-primary px-5 fw-bold" style="background-color: #0056b3; border:none;">Agree</a>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
    window.bookingConfig = {
        showtimeId: {{ $showtime->id }},
        movieTitle: @json($showtime->movie->title),
        soldSeatCodes: @json($soldSeatCodes),
        bookingStoreUrl: "{{ route('booking.store') }}"
    };
</script>
<script src="{{ asset('js/booking-create.js') }}"></script>
</body>
</html>