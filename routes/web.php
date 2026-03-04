<?php

use Illuminate\Support\Facades\Route; 
use App\Http\Controllers\Web\AuthController;
use App\Http\Controllers\Web\HomeController;
use App\Http\Controllers\Web\MovieController;
use App\Http\Controllers\Web\BookingController;
use App\Http\Controllers\Web\ProfileController;
use App\Http\Controllers\Web\TheaterController;
use App\Http\Controllers\Admin\ShowtimeController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\BookingController as AdminBookingController;
use App\Http\Controllers\Admin\UserController as AdminUserController;
use App\Http\Controllers\Web\MovieController as AdminMovieController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// Login
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');

// Register
Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register']);

// Home
Route::get('/', [HomeController::class, 'index'])->name('home');

// --- MOVIE ROUTES ---
Route::get('/movies', [MovieController::class, 'index'])->name('movies.index');
Route::get('/movies/upcoming', [MovieController::class, 'upcoming'])->name('movies.upcoming');
Route::get('/movies/status', [MovieController::class, 'showing'])->name('movies.status');

// Phải để cái {id} này ở dưới cùng của nhóm movies
Route::get('/movies/{id}', [MovieController::class, 'show'])->name('movies.show');


// --- BOOKING ---
Route::middleware('auth')->group(function () {
    
    // 1. ĐƯA COMBO LÊN TRÊN ĐẦU (Để không bị lỗi 404)
    Route::get('/booking/combo', [BookingController::class, 'combo'])->name('booking.combo');

    // 2. ĐƯA {showtimeId} XUỐNG DƯỚI
    Route::get('/booking/{showtimeId}', [BookingController::class, 'create'])->name('booking.create');
    
    Route::post('/booking', [BookingController::class, 'store'])->name('booking.store');
});
// --- PROFILE ---
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'index'])->name('profile.index');
    Route::post('/profile/update', [ProfileController::class, 'updateInfo'])->name('profile.update');
    Route::post('/profile/password', [ProfileController::class, 'updatePassword'])->name('profile.password');
});


Route::get('/reviews', [MovieController::class, 'index'])->name('review.index');
// Thay 'TheaterController' bằng tên Controller thật của cậu
Route::get('/schedule', [TheaterController::class, 'showSchedule'])->name('schedule.show');

Route::get('/theaters', [TheaterController::class, 'index'])->name('theaters.index');
// Route xem lịch chiếu của một rạp cụ thể
Route::get('/theaters/{id}/schedule', [TheaterController::class, 'showSchedule'])->name('theaters.schedule');
//ADMIN
Route::prefix('admin')
    ->middleware(['auth', 'admin'])
    ->name('admin.')
    ->group(function () {
    Route::get('/', [
        App\Http\Controllers\Admin\DashboardController::class,
        'index'
    ])->name('dashboard');
    Route::resource('movies',
        App\Http\Controllers\Admin\MovieController::class
    );
    Route::resource('directors',
        App\Http\Controllers\Admin\DirectorController::class
    );
    Route::resource('actors',
        App\Http\Controllers\Admin\ActorController::class
    );
    Route::resource('genres',
        App\Http\Controllers\Admin\GenreController::class
    );
    Route::resource('showtimes',
        App\Http\Controllers\Admin\ShowtimeController::class
    );
    Route::get('bookings', [
        App\Http\Controllers\Admin\BookingController::class,
        'index'
    ])->name('bookings.index');

    Route::get('bookings/{id}', [
        App\Http\Controllers\Admin\BookingController::class,
        'show'
    ])->name('bookings.show');

    Route::put('bookings/{id}/status', [
        App\Http\Controllers\Admin\BookingController::class,
        'updateStatus'
    ])->name('bookings.updateStatus');

    Route::post('bookings/{booking}/cancel', [
    App\Http\Controllers\Admin\BookingController::class,
    'cancel'
])->name('bookings.cancel');

    Route::resource('users', App\Http\Controllers\Admin\UserController::class);
});