@extends('layouts.app')

@section('content')
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
    .breadcrumb-item a { color: #888 !important; text-decoration: none; transition: 0.3s; }
    .breadcrumb-item a:hover { color: #ff69b4 !important; }
    .breadcrumb-item.active { color: #333; font-weight: 600; }
    /* --- GIỮ NGUYÊN STYLE CỦA CẬU --- */
    .theaters-page { background-color: #efe6f5; padding: 60px 0; min-height: 100vh; }
    .page-title { font-weight: 800; text-transform: uppercase; margin-bottom: 40px; color: #1a1a1a; }
    
    .theater-card {
        background: white; border-radius: 25px; padding: 30px;
        margin-bottom: 30px; border: 1px solid #eee;
        transition: 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        position: relative; overflow: hidden;
        animation: fadeInUp 0.5s ease backwards; /* Thêm hiệu ứng hiện hình cho mượt */
    }
    .theater-card:hover { transform: translateY(-10px); box-shadow: 0 20px 40px rgba(0,0,0,0.05); }
    .theater-card::before {
        content: ""; position: absolute; top: 0; left: 0; width: 8px; height: 100%;
        background: #90ff00;
    }

    .theater-name { font-weight: 800; color: #1a1a1a; margin-bottom: 10px; }
    .theater-info { color: #666; font-size: 0.95rem; margin-bottom: 5px; }
    .theater-info i { color: #90ff00; margin-right: 8px; }
    
    .btn-action {
        background: #1a1a1a; color: white; border-radius: 12px;
        padding: 10px 20px; font-weight: 700; border: none; transition: 0.2s;
    }
    .btn-action:hover { background: #90ff00; color: black; }

    /* --- STYLE MỚI CHO BỘ LỌC --- */
    .filter-section {
        background: white;
        border-radius: 20px;
        padding: 20px 30px;
        margin-bottom: 40px;
        box-shadow: 0 10px 30px rgba(0,0,0,0.03);
        border-bottom: 4px solid #90ff00;
    }
    .filter-label { font-weight: 700; color: #1a1a1a; margin-right: 15px; }
    .custom-select {
        border-radius: 12px;
        border: 1px solid #eee;
        padding: 10px 20px;
        font-weight: 600;
        cursor: pointer;
        transition: 0.3s;
    }
    .custom-select:focus { border-color: #90ff00; outline: none; box-shadow: 0 0 0 3px rgba(144, 255, 0, 0.2); }

    @keyframes fadeInUp {
        from { opacity: 0; transform: translateY(20px); }
        to { opacity: 1; transform: translateY(0); }
    }
</style>
{{-- BREADCRUMB CĂN GIỮA --}}
<div class="breadcrumb-container">
    <div class="container">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                <li class="breadcrumb-item active" aria-current="page">Theaters</li>
            </ol>
        </nav>
    </div>
</div>
<div class="theaters-page">
    <div class="container">
        <h2 class="page-title text-center">BK Cinema System</h2>
        
        <div class="filter-section d-flex align-items-center justify-content-between flex-wrap shadow-sm">
            <div class="d-flex align-items-center mb-2 mb-md-0">
                <span class="filter-label"><i class="bi bi-funnel-fill me-2"></i> Filter by City:</span>
                <form action="{{ route('theaters.index') }}" method="GET" id="filterForm">
                    <select name="city" class="custom-select form-select-sm" onchange="this.form.submit()">
                        <option value="">All Locations</option>
                        @foreach($cities as $city)
                            <option value="{{ $city }}" {{ request('city') == $city ? 'selected' : '' }}>
                                {{ $city }}
                            </option>
                        @endforeach
                    </select>
                </form>
            </div>
            <div class="text-muted small">
                Showing <strong>{{ $theaters->count() }}</strong> theaters
            </div>
        </div>

        <div class="row">
            @forelse($theaters as $theater)
            <div class="col-md-6">
                <div class="theater-card shadow-sm">
                    <h3 class="theater-name">{{ $theater->name }}</h3>
                    <div class="theater-info">
                        <i class="bi bi-geo-alt-fill"></i> {{ $theater->location }}
                    </div>
                    <div class="theater-info">
                        <i class="bi bi-building"></i> City: <strong>{{ $theater->city }}</strong>
                    </div>
                    <p class="mt-3 text-muted" style="font-size: 0.9rem; line-height: 1.6;">{{ $theater->description }}</p>
                    
                    <div class="mt-4 d-flex justify-content-between align-items-center">
                        <span class="badge" style="background: #efe6f5; color: #9c27b0; padding: 10px 20px; border-radius: 10px;">
                            <i class="bi bi-check-circle-fill me-1"></i> Active
                        </span>
                        {{-- Sửa dòng này --}}
                        <a href="{{ route('schedule.show', ['theater_id' => $theater->id]) }}" class="btn btn-action">
                            View Schedule
                        </a>
                    </div>
                </div>
            </div>
            @empty
            <div class="col-12 text-center py-5">
                <i class="bi bi-search" style="font-size: 3rem; color: #ccc;"></i>
                <p class="text-muted mt-3">No theaters found in this location.</p>
                <a href="{{ route('theaters.index') }}" class="btn btn-outline-dark btn-sm mt-2">Clear Filter</a>
            </div>
            @endforelse
        </div>
    </div>
</div>
@endsection
