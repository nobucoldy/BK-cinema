<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('booking_seats', function (Blueprint $table) {
    $table->id();
    $table->foreignId('booking_id')->constrained('bookings')->onDelete('cascade');
    $table->foreignId('seat_id')->constrained('seats')->onDelete('cascade');
    $table->foreignId('showtime_id')->constrained('showtimes')->onDelete('cascade');
    $table->integer('price')->default(0);
    $table->string('status', 20)->default('pending');
    $table->timestamps();

    $table->unique(['showtime_id', 'seat_id']); // tránh trùng ghế cho cùng 1 showtime
});

    }

    public function down(): void
    {
        Schema::dropIfExists('booking_seats');
    }
};