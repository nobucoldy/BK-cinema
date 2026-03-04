@extends('layouts.app')

@section('content')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">

<style>
    /* --- BREADCRUMB CĂN TÂM & KHÔNG ĐƯỜNG KẺ --- */
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

    .breadcrumb-item a {
        color: #888 !important;
        text-decoration: none;
        transition: 0.3s;
    }

    .breadcrumb-item a:hover {
     color: #ff69b4 !important;
    }

    .breadcrumb-item.active {
        color: #333;
        font-weight: 600;
    }

    /* --- GIỮ NGUYÊN TOÀN BỘ CSS GỐC CỦA CẬU --- */
    .schedule-wrapper { background-color: #f4f4f4; min-height: 100vh; padding-top: 30px; }
    .schedule-card { background: #fff; border-radius: 12px; overflow: hidden; box-shadow: 0 4px 20px rgba(0,0,0,0.08); border: 1px solid #e0e0e0; }
    .schedule-header { padding: 20px; border-bottom: 1px solid #eee; }
    .theater-sidebar { background: #fff; max-height: 700px; overflow-y: auto; }
    .search-container { padding: 15px; background: #fff; position: sticky; top: 0; z-index: 10; }
    .theater-item { padding: 15px; display: flex; align-items: center; gap: 12px; cursor: pointer; border-bottom: 1px solid #f1f1f1; transition: 0.2s; text-decoration: none; color: inherit; }
    .theater-item:hover { background: #f9f9f9; }
    .theater-item.active { background: #DEFE98; }
    .theater-logo { width: 40px; height: 40px; background: #1a1a1a; border-radius: 50%; display: flex; align-items: center; justify-content: center; color: #90ff00; font-weight: bold; font-size: 8px; flex-shrink: 0; text-align: center; line-height: 1; }
    .theater-logo img { width: 100%; height: 100%; object-fit: contain; border-radius: 50%; }

    /* --- CẬU NHÌN NÀY: PHẦN SHOWTIME-MAIN ĐƯỢC THÊM CHIỀU CAO VÀ FLEX ĐỂ CUỘN --- */
    .showtime-main { 
        padding: 25px; 
        background: #fff; 
        height: 700px; /* Khớp với chiều cao sidebar */
        display: flex;
        flex-direction: column;
        position: relative; /* Để Spinner hiện ở giữa */
    }

    .date-scroller { display: flex; gap: 10px; overflow-x: auto; padding-bottom: 15px; margin-bottom: 25px; flex-shrink: 0; }
    .date-btn { min-width: 80px; text-decoration: none; padding: 10px; text-align: center; background: #f8f9fa; border: 1px solid #ddd; border-radius: 8px; cursor: pointer; transition: 0.3s; }
    .date-btn.active { background: #DEFE98; border-color: #DEFE98; font-weight: bold; }
    
    /* VÙNG CUỘN RIÊNG CHO DANH SÁCH PHIM */
    .movie-list { 
        flex-grow: 1; 
        overflow-y: auto; 
        padding-right: 10px; 
        scroll-behavior: smooth;
    }
    .movie-list::-webkit-scrollbar { width: 6px; }
    .movie-list::-webkit-scrollbar-thumb { background: #DEFE98; border-radius: 10px; }
    .movie-list::-webkit-scrollbar-track { background: #f8f9fa; }

    .movie-item { display: flex; gap: 20px; padding: 20px; border: 1px solid #eee; border-radius: 12px; margin-bottom: 20px; }
    .movie-poster { width: 150px; height: 220px; object-fit: cover; border-radius: 8px; }
    .time-slot-container { display: flex; flex-wrap: wrap; gap: 10px; margin-top: 15px; }
    .time-slot { padding: 8px 16px; background: #f1f5f9; border: 1px solid #cbd5e1; border-radius: 6px; color: #334155; text-decoration: none; font-weight: 500; font-size: 14px; transition: 0.2s; }
    .time-slot:hover { background: #90ff00; color: black; border-color: #90ff00; }

    /* LOADER/SPINNER CSS */
    #schedule-loader {
        position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%);
        z-index: 100; display: none;
    }
    .spinner {
        width: 50px; height: 50px; border: 5px solid #f3f3f3;
        border-top: 5px solid #DEFE98; border-radius: 50%;
        animation: spin 1s linear infinite;
    }
    @keyframes spin { 0% { transform: rotate(0deg); } 100% { transform: rotate(360deg); } }
</style>
{{-- THANH BREADCRUMB ĐỘNG --}}
<div class="breadcrumb-container">
    <div class="container">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                
                {{-- Nếu có theater_id thì hiện thêm cấp Theater ở giữa --}}
                @if(request()->has('theater_id') && $selectedTheater)
                    <li class="breadcrumb-item">
                        <a href="{{ route('theaters.index') }}">Theaters</a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">
                        {{ $selectedTheater->name }}
                    </li>
                @else
                    {{-- Nếu không có theater_id thì hiện Schedule trực tiếp --}}
                    <li class="breadcrumb-item active" aria-current="page">Movie Schedule</li>
                @endif
            </ol>
        </nav>
    </div>
</div>

<div class="schedule-wrapper">
    <div class="container">
        <div class="schedule-card">
            <div class="schedule-header d-flex justify-content-between align-items-center">
                <h3 class="mb-0 fw-bold">MOVIE SCHEDULE</h3>
                <form action="{{ url()->current() }}" method="GET" class="d-flex align-items-center gap-2">
                    <span class="text-muted small">Location:</span>
                    <select name="city" class="form-select form-select-sm shadow-none" style="width: 150px;" onchange="this.form.submit()">
                        <option value="">All Cities</option>
                        @foreach($cities as $city)
                            <option value="{{ $city }}" {{ request('city') == $city ? 'selected' : '' }}>{{ $city }}</option>
                        @endforeach
                    </select>
                </form>
            </div>

            <div class="row g-0">
                <div class="col-md-4 theater-sidebar border-end">
                    <div class="search-container border-bottom">
                        <div class="input-group">
                            <span class="input-group-text bg-light border-end-0"><i class="bi bi-search"></i></span>
                            <input type="text" id="theaterSearch" class="form-control bg-light border-start-0 shadow-none" placeholder="Search theater...">
                        </div>
                    </div>
                    
                    <div class="theater-list">
                        @foreach($theaters as $t)
                        <a href="{{ url()->current() }}?theater_id={{ $t->id }}&city={{ request('city') }}" 
                           class="theater-item {{ $selectedTheaterId == $t->id ? 'active' : '' }}">
                            <div class="theater-logo">
                                <img src="{{ asset('storage/logo2.jpg') }}" alt="BKL Cinema">
                            </div>
                            <div class="theater-info overflow-hidden">
                                <h6 class="mb-0 fw-bold text-truncate">{{ $t->name }}</h6>
                                <p class="mb-0 text-muted small text-truncate">{{ $t->location }}</p>
                            </div>
                        </a>
                        @endforeach
                    </div>
                </div>

                <div class="col-md-8 showtime-main" id="schedule-display-area">
                    {{-- SPINNER NẰM Ở ĐÂY --}}
                    <div id="schedule-loader"><div class="spinner"></div></div>

                    @if($selectedTheater)
                        <div class="selected-theater-info mb-4">
                            <h4 class="fw-bold mb-1 text-dark"><i class="bi bi-geo-alt-fill text-success"></i> {{ $selectedTheater->name }}</h4>
                            <p class="text-muted small">{{ $selectedTheater->location }}, {{ $selectedTheater->city }}</p>
                        </div>

                        <div class="date-scroller">
                            @php $dates = collect(range(0, 6))->map(fn($i) => \Carbon\Carbon::today()->addDays($i)); @endphp
                            @foreach($dates as $date)
                                <a href="{{ url()->current() }}?theater_id={{ $selectedTheaterId }}&city={{ request('city') }}&show_date={{ $date->toDateString() }}" 
                                   class="date-btn {{ $selectedDate == $date->toDateString() ? 'active' : '' }}">
                                    <span>{{ $date->format('D') }}</span>
                                    <strong>{{ $date->format('d') }}</strong>
                                </a>
                            @endforeach
                        </div>

                        <div class="movie-list">
                            @forelse($showtimesGroupedByMovie as $movieId => $showtimes)
                                @php $movie = $showtimes->first()->movie; @endphp
                                <div class="movie-item shadow-sm">
                                    <img src="{{ Storage::url($movie->poster_url) }}" class="movie-poster">
                                    <div class="movie-info w-100">
                                        <h4 class="fw-bold mb-1 text-uppercase">{{ $movie->title }}</h4>
                                        <p class="text-muted small mb-3">{{ $movie->genre }} | {{ $movie->duration }} mins</p>
                                        <div class="time-slot-container">
    @foreach($showtimes as $st)
    @php
        $start = \Carbon\Carbon::parse($st->start_time);
        $end   = $start->copy()->addMinutes($movie->duration);
    @endphp
        <a href="{{ route('booking.create', $st->id) }}" class="time-slot">
            {{ $start->format('H:i') }} ~ {{ $end->format('H:i') }}
            <span class="badge bg-dark ms-1">
                {{ $st->screeningType->label }}
            </span>
        </a>
    @endforeach
</div>

                                    </div>
                                </div>
                            @empty
                                <div class="text-center py-5">
                                    <i class="bi bi-calendar-x" style="font-size: 3rem; color: #ccc;"></i>
                                    <p class="text-muted mt-3">No showtimes available for this theater today.</p>
                                </div>
                            @endforelse
                        </div>
                    @else
                        <div class="text-center py-5">Please select a theater to view schedule.</div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    // JS Lọc rạp tại chỗ của cậu (Giữ nguyên)
    document.getElementById('theaterSearch').addEventListener('input', function(e) {
        let term = e.target.value.toLowerCase();
        document.querySelectorAll('.theater-item').forEach(item => {
            let name = item.querySelector('h6').innerText.toLowerCase();
            item.style.display = name.includes(term) ? 'flex' : 'none';
        });
    });

    document.addEventListener('DOMContentLoaded', function() {
        const displayArea = document.getElementById('schedule-display-area');
        const loader = document.getElementById('schedule-loader');

        function loadSchedule(url) {
            // HIỆN SPINNER VÀ LÀM MỜ VÙNG CHỨA
            loader.style.display = 'block';
            displayArea.style.opacity = '0.5';
            displayArea.style.transition = 'opacity 0.3s ease';

            fetch(url, {
                headers: { 'X-Requested-With': 'XMLHttpRequest' }
            })
            .then(response => response.text())
            .then(html => {
                const parser = new DOMParser();
                const doc = parser.parseFromString(html, 'text/html');
                const newContent = doc.getElementById('schedule-display-area').innerHTML;
                
                displayArea.innerHTML = newContent;
                
                // ẨN SPINNER VÀ HIỆN LẠI NỘI DUNG
                loader.style.display = 'none';
                displayArea.style.opacity = '1';

                // TỰ ĐỘNG CUỘN LÊN ĐẦU DANH SÁCH PHIM
                const movieList = displayArea.querySelector('.movie-list');
                if(movieList) movieList.scrollTop = 0;

                window.history.pushState({}, '', url);
            })
            .catch(error => {
                console.error('Error:', error);
                loader.style.display = 'none';
                displayArea.style.opacity = '1';
            });
        }

        document.addEventListener('click', function(e) {
            const target = e.target.closest('.theater-item, .date-btn');
            if (target) {
                e.preventDefault();
                const url = target.getAttribute('href');
                
                if (target.classList.contains('theater-item')) {
                    document.querySelectorAll('.theater-item').forEach(i => i.classList.remove('active'));
                } else {
                    document.querySelectorAll('.date-btn').forEach(i => i.classList.remove('active'));
                }
                target.classList.add('active');

                loadSchedule(url);
            }
        });
    });
</script>
@endsection