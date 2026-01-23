<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'showtime_id',
        'total_amount',
        'status',
    ];
     public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function bookingSeats()
    {
        return $this->hasMany(BookingSeat::class);
    }

    public function showtime()
    {
        return $this->belongsTo(Showtime::class);
    }
    public function seats()
    {
        return $this->belongsToMany(Seat::class, 'booking_seats', 'booking_id', 'seat_id')
                    ->withPivot('price', 'status', 'showtime_id')
                    ->withTimestamps();
    }
}