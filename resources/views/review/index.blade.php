@extends('layouts.app')

@section('title', 'Movie Reviews - BKL Cinema')

@section('content')
<style>
    /* --- BREADCRUMB: Căn giữa và đổi màu trắng để nổi bật --- */
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
        color: #a3a3a3 !important;
        padding: 0 10px;
        font-size: 11px;
    }
    .breadcrumb-item a { color: #a3a3a3 !important; text-decoration: none; transition: 0.3s; }
    .breadcrumb-item a:hover { color: #ff69b4 !important; }
    .breadcrumb-item.active { color: #ffffff !important; font-weight: 600; }

    .review-page { 
        background-color: #3b2d3d; 
        color: white; 
        padding: 40px 0; 
        min-height: 100vh;
    }

    .review-header {
        font-family: 'Inter', sans-serif;
        font-weight: 700;
        text-align: center;
        margin-bottom: 50px;
        font-size: 2rem;
        letter-spacing: 1px;
        text-transform: uppercase;
    }

    /* Card Layout */
    .review-card-small { margin-bottom: 30px; cursor: pointer; transition: 0.3s; }
    .review-card-small:hover { transform: translateY(-8px); }
    
    .img-small-wrapper {
        background-color: #2a1f2b; /* Màu tối hơn nền một chút */
        border-radius: 15px;
        aspect-ratio: 1/1;
        overflow: hidden;
        margin-bottom: 15px;
        box-shadow: 0 10px 20px rgba(0,0,0,0.2);
    }
    .img-small-wrapper img { width: 100%; height: 100%; object-fit: cover; }
    
    .title-small { 
        font-size: 0.95rem; 
        font-weight: 600; 
        line-height: 1.4; 
        color: #fff; 
        height: 2.8rem; /* Giữ tiêu đề tối đa 2 dòng cho đều */
        overflow: hidden;
    }

    .rating-badge {
        background-color: #ff0000;
        color: white;
        padding: 3px 10px;
        border-radius: 6px;
        font-size: 0.75rem;
        font-weight: 800;
        display: inline-flex;
        align-items: center;
        gap: 5px;
        margin-top: 8px;
    }

    /* Phân trang Neon */
    .pagination-wrapper .page-link {
        background-color: #3b2d3d;
        border: 1px solid #ff69b4;
        color: #ff69b4;
        margin: 0 3px;
        border-radius: 5px;
    }
    .pagination-wrapper .page-item.active .page-link {
        background-color: #ff69b4;
        border-color: #ff69b4;
        color: #fff;
    }
</style>

{{-- BREADCRUMB --}}
<div class="breadcrumb-container" style="background-color: #3b2d3d;">
    <div class="container">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                <li class="breadcrumb-item active" aria-current="page" style="color: #000000 !important; font-weight: 600;">Reviews</li>
            </ol>
        </nav>
    </div>
</div>

<div class="review-page">
    <div class="container">
        <h1 class="review-header">Movie Reviews</h1>

        <div class="row">
            {{-- ĐỔ DỮ LIỆU THẬT --}}
            @forelse($reviews as $review)
                <div class="col-lg-3 col-md-4 col-6">
                    <div class="review-card-small">
                        <div class="img-small-wrapper">
                            {{-- LOGIC LẤY ẢNH: Ưu tiên ảnh riêng bài review -> Ảnh poster phim (poster_url) --}}
                            @if($review->image)
                                <img src="{{ asset('storage/' . $review->image) }}" alt="{{ $review->title }}">
                            @elseif($review->movie && $review->movie->poster_url)
                                <img src="{{ asset('storage/' . $review->movie->poster_url) }}" alt="{{ $review->movie->title }}">
                            @else
                                <img src="https://via.placeholder.com/400x400?text=BKL+Cinema" alt="No Image">
                            @endif
                        </div>
                        <div class="title-small">{{ $review->title }}</div>
                        <div class="rating-badge">
                            <i class="bi bi-star-fill"></i> {{ $review->rating }}/10
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12 text-center py-5">
                    <div class="mb-3">
                        <i class="bi bi-chat-left-dots" style="font-size: 3rem; color: #ff69b4;"></i>
                    </div>
                    <p class="text-muted; color: white;">No reviews have been posted yet. Come back later!</p>
                    <a href="{{ route('home') }}" class="btn btn-outline-light btn-sm mt-3">Back to Home</a>
                </div>
            @endforelse
        </div>

        {{-- PHẦN PHÂN TRANG --}}
        @if($reviews->hasPages())
            <div class="pagination-wrapper d-flex justify-content-center mt-5">
                {{ $reviews->links('pagination::bootstrap-4') }}
            </div>
        @endif
    </div>
</div>
@endsection