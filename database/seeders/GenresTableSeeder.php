<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Genre;

class GenresTableSeeder extends Seeder
{
    public function run()
    {
        $genres = [
            'Sci-Fi',      // 1
            'Adventure',   // 2
            'Action',      // 3
            'Animation',   // 4
            'Comedy',      // 5
            'Thriller',    // 6
            'Crime',       // 7
            'Horror',      // 8
            'Drama',       // 9
            'Family'       // 10
        ];

        foreach ($genres as $name) {
            Genre::create(['name' => $name]);
        }
    }
}