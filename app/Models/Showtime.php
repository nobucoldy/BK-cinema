<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Showtime extends Model
{
    use HasFactory;

    protected $fillable = [
        'movie_id',
        'theater_id',
        'room_id',
        'screening_type_id',
        'show_date',
        'start_time',
        'end_time',
    ];

    // ✅ CAST ĐÚNG CHỖ
    protected $casts = [
        'show_date'  => 'date',
    ];

    public function movie()
    {
        return $this->belongsTo(Movie::class);
    }

    public function theater()
    {
        return $this->belongsTo(Theater::class);
    }

    public function room()
    {
        return $this->belongsTo(Room::class);
    }

    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }
    public function screeningType()
    {
        return $this->belongsTo(ScreeningType::class);
    }
}