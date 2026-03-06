<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BookingCombo extends Model
{
    use HasFactory;

    protected $fillable = [
        'booking_id',
        'name',
        'qty',
        'price'
    ];

    // Quan hệ với Booking
    public function booking()
    {
        return $this->belongsTo(Booking::class);
    }
}