<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Api\MovieController;
use App\Http\Controllers\Api\BookingController;
use App\Http\Controllers\Api\ProfileController;
use App\Http\Controllers\Api\ShowtimeController;

// Auth
Route::post('/login', [AuthController::class, 'login']);
Route::middleware('auth:sanctum')->post('/logout', [AuthController::class, 'logout']);

// Movie
Route::controller(MovieController::class)->group(function () {
    Route::get('/movies', 'index');
    Route::get('/movies/showing', 'showing');
    Route::get('/movies/showing-filter', 'showingFilter');
    Route::get('/movies/coming-soon', 'comingSoon');
    Route::get('/movies/filter', 'filter');
    Route::get('/movies/{id}', 'show');
});

// Showtime
Route::get('/showtimes', [ShowtimeController::class, 'index']);
Route::get('/showtimes/{id}', [ShowtimeController::class, 'show']);
Route::get('/showtimes/{id}/seats', [ShowtimeController::class, 'checkSeats']);

// Booking (auth required)
Route::middleware('auth:sanctum')->group(function () {
    Route::post('/bookings', [BookingController::class, 'create']);
    Route::delete('/bookings/{id}', [BookingController::class, 'cancel']);
    Route::get('/my-bookings', [BookingController::class, 'myBookings']);
});

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/me', [ProfileController::class, 'me']);
    Route::put('/me', [ProfileController::class, 'update']);
    Route::put('/me/password', [ProfileController::class, 'changePassword']);
});

