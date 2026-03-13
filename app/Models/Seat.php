<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Seat extends Model
{
    use HasFactory;

    protected $fillable = [
        'room_id', 'seat_code', 'seat_type'
    ];

    public function room()
    {
        return $this->belongsTo(Room::class);
    }

    /**
     * Compute ticket price for this seat given a showtime.
     * Takes base prices from config and adds screening type extra.
     */
    public function priceForShowtime($showtime)
    {
        $base = config('prices.regular');
        $extra = $showtime->screeningType->extra_price ?? 0;

        // couple seats defined by code starting with I
        if (strpos($this->seat_code, 'I') === 0) {
            $base = config('prices.couple');
        } elseif (in_array($this->seat_code[0], ['D','E','F','G','H'])) {
            $base = config('prices.vip');
        }

        return $base + $extra;
    }
}