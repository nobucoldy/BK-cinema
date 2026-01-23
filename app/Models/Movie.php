<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Movie extends Model
{
    use HasFactory;

    protected $fillable = [
        'title', 'description', 'duration', 'director_id',
        'release_date', 'poster_url', 'trailer_url', 'movie_backdrop', 'status', 'base_price'
    ];

    public function showtimes()
    {
        return $this->hasMany(Showtime::class);
    }

    public function director()
    {
        return $this->belongsTo(Director::class);
    }

    public function actors()
    {
        return $this->belongsToMany(Actor::class);
    }

    public function genres()
    {
        return $this->belongsToMany(Genre::class);
    }

}