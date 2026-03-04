@extends('layouts.app')

@section('content')

{{-- 1. TOAST THÔNG BÁO (GIỮ NGUYÊN) --}}
<div id="home-toast-container" style="position: fixed; top: 20px; right: 20px; z-index: 999999; display: flex; flex-direction: column; gap: 12px; pointer-events: none;">
    @if (session('success'))
    <div class="custom-toast-success" id="successToast" style="pointer-events: auto; background: #1e293b; color: white; padding: 16px 20px; border-radius: 12px; min-width: 320px; box-shadow: 0 10px 30px rgba(0,0,0,0.5); display: flex; align-items: center; justify-content: space-between; border-left: 5px solid #DEFE98; position: relative; overflow: hidden; animation: slideInIn 0.4s ease forwards;">
        <div style="display: flex; align-items: center; gap: 12px;">
            <i class="bi bi-check-circle-fill" style="color: #DEFE98; font-size: 1.2rem;"></i>
            <span style="font-weight: 500;">{{ session('success') }}</span>
        </div>
        <button onclick="closeHomeToast()" style="background: none; border: none; color: #94a3b8; cursor: pointer; font-size: 1.2rem; outline: none;">✕</button>
        <div style="position: absolute; bottom: 0; left: 0; height: 4px; background: #DEFE98; width: 100%; animation: toastProgress 3s linear forwards;"></div>
    </div>
    @endif
</div>

{{-- 2. BANNER HERO --}}
<section class="hero-slider-wrapper">
    <div class="swiper heroSwiper">
        <div class="swiper-wrapper">
            @foreach($featuredMovies as $movie)
                <div class="swiper-slide">
                    <a href="{{ route('movies.show', $movie->id) }}">
                        <header class="hero-section" style="background-image: url('{{ asset('storage/' . $movie->movie_backdrop) }}');">
                            <div class="hero-overlay"></div>
                        </header>
                    </a>
                </div>
            @endforeach
        </div>
        <div class="swiper-pagination"></div>
        <div class="nav-click-area nav-prev"></div>
        <div class="nav-click-area nav-next"></div>
    </div>
</section>


<div class="section-gap bg-light"></div>

{{-- 3. NOW SHOWING --}}
<section class="py-5 bg-black text-white">
    <div class="container text-center">
        <h2 class="section-header mb-4">NOW SHOWING</h2>

        <div class="swiper-container-wrapper position-relative px-5">
            <div class="swiper mySwiper">
                <div class="swiper-wrapper">
                    @foreach($showingMovies as $movie)
                        <div class="swiper-slide">
                            <a href="{{ route('movies.show', $movie->id) }}"
                            class="movie-card-item home-movie-card text-decoration-none text-white">

                               
                                <img src="{{ asset('storage/' . $movie->poster_url) }}"
                                     alt="{{ $movie->title }}"
                                     style="width:100%; border-radius:12px; aspect-ratio:2/3; object-fit:cover;">

                                <p class="movie-name mt-2" style="font-weight:600;">
                                    {{ $movie->title }}
                                </p>
                            </a>
                        </div>
                    @endforeach
                </div>

                <div class="swiper-pagination"></div>
            </div>

            <div class="swiper-button-next main-next"></div>
            <div class="swiper-button-prev main-prev"></div>
        </div>
    </div>
</section>

{{-- 4. COMING SOON --}}
<section class="py-5" style="background-color: #DEFE98;">
    <div class="container text-center">
        <h2 class="section-header text-dark mb-4">COMING SOON</h2>

        <div class="swiper-container-wrapper position-relative px-5">
            <div class="swiper mySwiperUpcoming">
                <div class="swiper-wrapper">
                    @foreach($upcomingMovies as $movie)
                        <div class="swiper-slide">
                            <a href="{{ route('movies.show', $movie->id) }}"
                            class="movie-card-item home-movie-card text-decoration-none">
                                <img src="{{ asset('storage/' . $movie->poster_url) }}"
                                     alt="{{ $movie->title }}"
                                     style="width:100%; border-radius:12px; aspect-ratio:2/3; object-fit:cover;">

                                <p class="movie-name text-dark mt-2" style="font-weight:600;">
                                    {{ $movie->title }}
                                </p>
                            </a>
                        </div>
                    @endforeach
                </div>

                <div class="swiper-pagination"></div>
            </div>

            <div class="swiper-button-next upcoming-next"></div>
            <div class="swiper-button-prev upcoming-prev"></div>
        </div>
    </div>
</section>
{{-- 5. MOVIE SCHEDULE --}}
<section class="py-5 bg-light">
    <div class="container">
        <h2 class="section-header text-center mb-4 text-dark">MOVIE SCHEDULE</h2>
        <div class="schedule-card mx-auto d-flex" style="max-width: 900px; height: 500px; background: #fff; border-radius: 12px; box-shadow: 0 4px 20px rgba(0,0,0,0.08); overflow:hidden;">
            {{-- Sidebar --}}
            <div class="col-md-4 p-0 border-end d-flex flex-column" style="height: 500px; background: #fff;">
                <div class="p-3 border-bottom bg-white" style="position: sticky; top: 0; z-index: 10;">
                    <div class="input-group">
                        <span class="input-group-text bg-light border-end-0"><i class="bi bi-search"></i></span>
                        <input type="text" id="theaterSearch" class="form-control bg-light border-start-0 shadow-none" placeholder="Search theater...">
                    </div>
                </div>
                <div class="theater-list p-2" style="overflow-y: auto; flex-grow: 1;">
                    @foreach($theaters as $t)
                        <a href="{{ url()->current() }}?theater_id={{ $t->id }}&show_date={{ $selectedDate }}" 
                           class="theater-item d-flex align-items-center gap-2 mb-1 {{ $selectedTheaterId == $t->id ? 'active-theater' : '' }}"
                           style="text-decoration:none; color:inherit; padding:12px; border-radius:8px;">
                            <i class="bi bi-geo-alt-fill {{ $selectedTheaterId == $t->id ? 'text-dark' : 'text-success' }}"></i>
                            <span class="fw-medium">{{ $t->name }}</span>
                        </a>
                    @endforeach
                </div>
            </div>
            {{-- Content --}}
            <div id="schedule-content" class="col-md-8 p-3 d-flex flex-column" style="overflow-y:auto;">
                @if($selectedTheater)
                    <div class="date-scroller mb-3 d-flex gap-2 overflow-auto flex-shrink-0">
                        @php $dates = collect(range(0,6))->map(fn($i) => \Carbon\Carbon::today()->addDays($i)); @endphp
                        @foreach($dates as $date)
                            <a href="{{ url()->current() }}?theater_id={{ $selectedTheaterId }}&show_date={{ $date->toDateString() }}"
                               class="date-btn px-3 py-2 border rounded {{ $selectedDate == $date->toDateString() ? 'active' : '' }}"
                               style="text-decoration:none; text-align:center;">
                                <span>{{ $date->format('D') }}</span><br>
                                <strong>{{ $date->format('d') }}</strong>
                            </a>
                        @endforeach
                    </div>
                    <div class="movie-list flex-grow-1 overflow-auto">
                        @forelse($showtimesGroupedByMovie as $movieId => $showtimes)
                            @php $movie = $showtimes->first()->movie; @endphp
                            <div class="movie-item d-flex gap-3 mb-3 p-2 border rounded">
                                <img src="{{ asset('storage/' . $movie->poster_url) }}" alt="{{ $movie->title }}" style="width:100px; height:150px; object-fit:cover; border-radius:6px;">
                                <div class="movie-info w-100">
                                    <h5 class="fw-bold mb-1">{{ $movie->title }}</h5>
                                    <p class="text-muted small mb-2">
                                        @forelse($movie->genres as $g)
                                            {{ $g->name }}@if(!$loop->last), @endif
                                        @empty
                                            N/A
                                        @endforelse
                                        | {{ $movie->duration }} mins
                                    </p>
                                    <div class="time-slot-container d-flex flex-wrap gap-2">
                                        @foreach($showtimes as $st)
                                            <a href="{{ route('booking.create', $st->id) }}" class="time-slot px-3 py-1 border rounded bg-light text-dark" title="{{ $st->screeningType->label }}">
                                                {{ \Carbon\Carbon::parse($st->start_time)->format('H:i') }}
                                                <span class="badge bg-dark ms-1" style="font-size: 0.7rem;">{{ $st->screeningType->label }}</span>
                                            </a>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="text-center py-5"><p class="text-muted">No showtimes available.</p></div>
                        @endforelse
                    </div>
                @endif
            </div>
        </div>
    </div>
</section>

@endsection

@push('styles')
<style>
    /* 1. NÚT ĐIỀU HƯỚNG MÀU #DEFE98 */
    .swiper-button-next, .swiper-button-prev, .main-next, .main-prev, .upcoming-next, .upcoming-prev {
        color: #ff69b4 !important;
    }
    .swiper-button-next:after, .swiper-button-prev:after { font-size: 24px !important; font-weight: bold; }

    /* 2. CHẤM HỒNG (PAGINATION) */
    .swiper-pagination-bullet { background: #ffffff !important; opacity: 0.4; }
    .swiper-pagination-bullet-active {
        background: #ff69b4 !important;
        width: 30px !important;
        border-radius: 5px !important;
        opacity: 1 !important;
    }

    /* 3. BANNER HERO - FULL ẢNH */
    .hero-slider-wrapper { width: 100vw; position: relative; left: 50%; right: 50%; margin-left: -50vw; margin-right: -50vw; overflow: hidden; }
    .hero-section { width: 100%; height: 80vh; background-size: cover; background-position: center !important; position: relative; }
    .hero-overlay { display: none !important; }
    .nav-click-area { position: absolute; top: 0; height: 100%; width: 25%; z-index: 900; cursor: pointer; }
    .nav-prev { left: 0; } .nav-next { right: 0; }

    /* 4. CHỈNH KHOẢNG CÁCH CHO SWIPER HIỆN CHẤM */
    .mySwiper, .mySwiperUpcoming { padding-bottom: 50px !important; }

    /* 5. SCHEDULE (XÓA GẠCH CHÂN) */
    .date-btn, .time-slot { text-decoration: none !important; }
    .active-theater { background-color: #ff69b4 !important; color: white !important; }
    .date-btn.active { background:#DEFE98; color: #000; font-weight:bold; }
</style>
@endpush

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // --- 1. Banner Hero ---
        const heroSwiper = new Swiper(".heroSwiper", {
            loop: true, speed: 1000,
            pagination: { el: ".heroSwiper .swiper-pagination", clickable: true },
        });
        document.querySelector('.nav-prev').addEventListener('click', () => heroSwiper.slidePrev());
        document.querySelector('.nav-next').addEventListener('click', () => heroSwiper.slideNext());

        // --- 2. Cấu hình chung cho phim ---
        const commonConfig = {
            slidesPerView: 4, spaceBetween: 20, loop: true,
            pagination: { clickable: true },
            breakpoints: { 1024: { slidesPerView: 4 }, 768: { slidesPerView: 3 }, 0: { slidesPerView: 1.5 } }
        };

        // --- 3. Now Showing ---
        new Swiper(".mySwiper", {
            ...commonConfig,
            pagination: { el: ".mySwiper .swiper-pagination", clickable: true },
            navigation: { nextEl: ".main-next", prevEl: ".main-prev" },
        });

        // --- 4. Coming Soon ---
        new Swiper(".mySwiperUpcoming", {
            ...commonConfig,
            pagination: { el: ".mySwiperUpcoming .swiper-pagination", clickable: true },
            navigation: { nextEl: ".upcoming-next", prevEl: ".upcoming-prev" },
        });

        // --- 5. Search Theater (Dùng ID chuẩn) ---
        const searchInput = document.getElementById('theaterSearch');
        if (searchInput) {
    searchInput.addEventListener('input', function(e) {
        // Lấy từ khóa cậu gõ và chuyển thành chữ thường
        let term = e.target.value.toLowerCase().trim();
        
        // Tìm tất cả các item rạp trong danh sách
        let theaterItems = document.querySelectorAll('.theater-item');

        theaterItems.forEach(item => {
            // Lấy tên rạp bên trong thẻ span (hoặc toàn bộ text của item)
            let theaterName = item.innerText.toLowerCase();

            // Nếu tên rạp có chứa từ khóa thì hiện (flex), không thì ẩn (none)
            if (theaterName.includes(term)) {
                item.style.setProperty('display', 'flex', 'important');
            } else {
                item.style.setProperty('display', 'none', 'important');
            }
        });
    });
}

        // --- 6. AJAX Schedule ---
        const scheduleCard = document.querySelector('.schedule-card');
        if (scheduleCard) {
            scheduleCard.addEventListener('click', function(e) {
                const target = e.target.closest('.theater-item, .date-btn');
                if (target) {
                    e.preventDefault();
                    const url = target.getAttribute('href');
                    const contentArea = document.getElementById('schedule-content');
                    const sidebarArea = document.querySelector('.theater-list');
                    contentArea.style.opacity = '0.5';

                    fetch(url, { headers: { 'X-Requested-With': 'XMLHttpRequest' } })
                        .then(res => res.text())
                        .then(html => {
                            const parser = new DOMParser();
                            const doc = parser.parseFromString(html, 'text/html');
                            contentArea.innerHTML = doc.getElementById('schedule-content').innerHTML;
                            sidebarArea.innerHTML = doc.querySelector('.theater-list').innerHTML;
                            contentArea.style.opacity = '1';
                            window.history.pushState({}, '', url);
                        });
                }
            });
        }
    });

    function closeHomeToast() {
        const toast = document.getElementById('successToast');
        if (toast) {
            toast.style.transform = "translateX(120%)";
            toast.style.opacity = "0";
            setTimeout(() => toast.remove(), 400);
        }
    }
</script>
@endpush