<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'BKL Cinema')</title>

    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600;700&family=Oswald:wght@700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <!-- Bootstrap CSS -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

    {{-- CSS GIỮ NGUYÊN --}}
    <style>
        :root {
            --bkl-red: #ff0000;
            --bkl-yellow: #ffeb3b;
            --dark-bg: #000000;
            --gray-section: #a3a3a3;
        }

        body {
            font-family: 'Inter', sans-serif;
            background-color: #fff;
            margin: 0;
            color: #333;
        }

        /* --- 1. NAVBAR --- */
        .navbar {
            background-color: var(--dark-bg) !important;
            padding: 10px 0;
            border-bottom: 1px solid #222;
        }

        .logo-group {
            display: flex;
            align-items: center;
            text-decoration: none;
            color: inherit;
        }

        .logo-circle {
            width: 60px;
            height: 60px;
            border-radius: 50%;
            background: #000;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            position: relative;
        }

        .logo-circle img {
            width: 45px;
            height: 45px;
            border-radius: 50%;
            object-fit: cover;
            margin-bottom: 2px;
        }

        .logo-circle-footer {
            width: 80px;   /* tăng từ 60px lên 80px hoặc hơn */
            height: 80px;
            border-radius: 50%;
            overflow: hidden; /* đảm bảo ảnh không tràn */
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .logo-circle-footer img {
            width: 100%;   /* full vòng tròn */
            height: 100%;
            object-fit: cover;
            display: block;
        }

        .pick-ticket {
            color: var(--bkl-yellow);
            font-family: 'Oswald';
            font-size: 14px;
            text-transform: uppercase;
            width: 40px;
            margin-left: 0px;
            line-height: 1.1;
        }

        .nav-link {
            color: #fff !important;
            font-size: 14px;
            font-weight: 300;
            margin: 0 10px;
            transition: 0.3s;
        }

        .nav-link:hover { color: var(--bkl-yellow) !important; }

        /* --- HOVER EFFECT DROPDOWN MOVIES --- */
        @media (min-width: 992px) {
            .nav-item.dropdown:hover .dropdown-menu {
                display: block;
                margin-top: 0;
            }
        }
        
        .dropdown-menu {
            background-color: #1a1a1a;
            border: 1px solid #333;
            border-radius: 8px;
            padding: 10px 0;
        }

        .dropdown-item {
            color: #fff;
            font-size: 13px;
            padding: 8px 20px;
            transition: 0.2s;
        }

        .dropdown-item:hover {
            background-color: var(--bkl-red);
            color: #fff;
        }

        .login-link {
            color: #fff !important;
            text-decoration: none !important;
            font-size: 14px;
            font-weight: 400;
            transition: 0.3s;
            cursor: pointer;
        }

        .login-link:hover { color: var(--bkl-yellow) !important; }

        .user-avatar {
            width: 32px;
            height: 32px;
            border-radius: 50%;
            object-fit: cover;
            border: 1px solid #fff;
            cursor: pointer;
        }

        /* --- 2. HERO BANNER --- */
        .hero-section {
            height: 65vh;
            background: linear-gradient(to bottom, rgba(0,0,0,0) 50%, rgba(0,0,0,0.9) 100%), 
                        url('https://images8.alphacoders.com/124/1248358.jpg');
            background-size: cover;
            background-position: center;
            display: flex;
            align-items: flex-end;
            justify-content: center;
            padding-bottom: 40px;
            border-top: 4px solid #00d2ff;
        }

        .movie-title-logo {
            width: 100%;
            max-width: 400px;
            filter: drop-shadow(0 0 15px rgba(0,210,255,0.8));
        }

        /* --- 3. MOVIE CARDS --- */
        .section-header {
            font-family: 'Oswald';
            text-transform: uppercase;
            letter-spacing: 2px;
            font-size: 1.6rem;
            margin-bottom: 40px;
        }
/* 1. Phải bọc thằng cha để ảnh không tràn */
    /* 1. Khung bao quát (Thẻ a) */
.home-movie-card {
    display: block !important;
    text-decoration: none !important;
    transition: transform 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275) !important; /* Hiệu ứng nảy nhẹ cực xịn */
    border-radius: 12px;
    padding: 5px; /* Tạo khoảng không gian nhỏ để khi to ra không bị "gắt" */
}

/* 2. Ảnh bên trong (Bỏ hiệu ứng scale riêng ở đây để không đè chữ) */
.home-movie-card img {
    width: 100% !important;
    border-radius: 12px !important;
    display: block !important;

}

/* 3. Hiệu ứng HOVER: Phóng to CẢ KHỐI (Ảnh + Chữ) */
.home-movie-card:hover {
    transform: scale(1.08) !important; /* Phóng to cả khối 8% */
    z-index: 10; /* Đảm bảo khi to ra nó nổi lên trên các slide bên cạnh */
}

/* 4. Hiệu ứng cho chữ khi hover */
.home-movie-card:hover .movie-name {
    color: #ff69b4 !important; /* Đổi màu chữ sang hồng cho đồng bộ */
    transform: translateY(3px); /* Nhích chữ xuống một xíu tạo cảm giác sâu */
    transition: all 0.4s ease;
}

        .movie-card {
            transition: transform 0.4s ease;
            cursor: pointer;
            margin-bottom: 30px;
        }

        .movie-card:hover { transform: scale(1.05); }

        .movie-card img {
            width: 100%;
            aspect-ratio: 2/3;
            object-fit: cover;
            border-radius: 6px;
            box-shadow: 0 15px 30px rgba(0,0,0,0.5);
        }

        .movie-name {
            font-size: 13px;
            font-weight: 600;
            margin-top: 15px;
            text-align: center;
        }

        /* --- 4. SCHEDULE SECTION --- */
        .schedule-container {
            background: #fff;
            border-radius: 15px;
            overflow: hidden;
            box-shadow: 0 5px 25px rgba(0,0,0,0.1);
            max-width: 950px;
            margin: 0 auto;
        }

        .schedule-sidebar {
            background: #fafafa;
            border-right: 1px solid #eee;
            padding: 25px;
        }

        .theater-item {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 12px;
            font-size: 14px;
            cursor: pointer;
            border-radius: 8px;
            transition: 0.2s;
        }

        .theater-item:hover { background: #f0f0f0; }

        /* --- 5. FOOTER --- */
        .footer {
            background-color: var(--dark-bg);
            padding: 40px 0;
            border-top: 1px solid #222;
        }

        .social-icons i {
            color: #fff;
            font-size: 22px;
            margin-left: 25px;
            transition: 0.3s;
            cursor: pointer;
        }

        .social-icons i:hover { color: var(--bkl-red); }
    </style>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper/swiper-bundle.min.css" />
    @stack('styles')
</head>

<body class="d-flex flex-column min-vh-100">

    @include('partials.navbar')

    <main class="flex-fill">
        @yield('content')
    </main>

    @include('partials.footer')

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Swiper JS -->
    <script src="https://cdn.jsdelivr.net/npm/swiper/swiper-bundle.min.js"></script>
    @stack('scripts')

</body>
</html>
