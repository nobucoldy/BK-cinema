<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin - Cinema</title>

    {{-- Bootstrap CSS --}}
    <link rel="stylesheet"
          href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
</head>

<body>

{{-- NAVBAR --}}
<nav class="navbar navbar-dark bg-dark px-3">
    <a class="navbar-brand d-flex align-items-center" href="{{ route('admin.dashboard') }}">
        <img src="{{ asset('storage/logo2.jpg') }}"
             alt="Logo"
             width="30"
             height="30"
             class="me-2 rounded-circle">
        BKL Cinema Admin
    </a>

    <div class="d-flex align-items-center">

        <a class="text-white me-3" href="{{ route('admin.movies.index') }}">Movies</a>
        <a class="text-white me-3" href="{{ route('admin.showtimes.index') }}">Showtimes</a>
        <a class="text-white me-3" href="{{ route('admin.bookings.index') }}">Bookings</a>

        {{-- Master Data Dropdown --}}
        <div class="dropdown me-3">
            <button class="btn btn-link text-white dropdown-toggle p-0 text-decoration-underline"
        type="button"
        data-bs-toggle="dropdown"
        aria-expanded="false">
    Master Data
</button>
            <ul class="dropdown-menu dropdown-menu-end">
                <li><a class="dropdown-item" href="{{ route('admin.directors.index') }}">Directors</a></li>
                <li><a class="dropdown-item" href="{{ route('admin.actors.index') }}">Actors</a></li>
                <li><a class="dropdown-item" href="{{ route('admin.genres.index') }}">Genres</a></li>
            </ul>
        </div>

        <a class="text-white me-3" href="{{ route('admin.users.index') }}">Users</a>

        {{-- LOGOUT --}}
        <span class="me-3">
            <form action="{{ route('logout') }}" method="POST" class="d-inline">
                @csrf
                <button type="submit"
                        class="btn btn-link text-white p-0 text-decoration-underline">
                    Logout
                </button>
            </form>
        </span>

    </div>

</nav>

{{-- TOAST CONTAINER --}}
<div class="toast-container position-fixed top-0 end-0 p-3" style="z-index: 9999">

    {{-- Success --}}
    @if(session('success'))
        <div class="toast text-bg-success border-0" role="alert" data-bs-delay="2500">
            <div class="d-flex">
                <div class="toast-body">✅ {{ session('success') }}</div>
                <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"></button>
            </div>
        </div>
    @endif

    {{-- Error --}}
    @if(session('error'))
        <div class="toast text-bg-danger border-0" role="alert" data-bs-delay="2500">
            <div class="d-flex">
                <div class="toast-body">❌ {{ session('error') }}</div>
                <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"></button>
            </div>
        </div>
    @endif

    {{-- Validation Errors --}}
    @if ($errors->any())
        @foreach ($errors->all() as $error)
            <div class="toast text-bg-danger border-0" role="alert" data-bs-delay="3000">
                <div class="d-flex">
                    <div class="toast-body">❌ {{ $error }}</div>
                    <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"></button>
                </div>
            </div>
        @endforeach
    @endif

</div>

{{-- CONTENT --}}
<div class="container mt-4">
    @yield('content')
</div>

{{-- Bootstrap JS --}}
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

{{-- Toast Auto Show --}}
<script>
document.addEventListener('DOMContentLoaded', function () {
    const toastElList = document.querySelectorAll('.toast')
    toastElList.forEach(function (toastEl) {
        const toast = new bootstrap.Toast(toastEl, {
            delay: parseInt(toastEl.dataset.bsDelay) || 2500
        })
        toast.show()
    })
})
</script>

</body>
</html>
