<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Director;

class DirectorsTableSeeder extends Seeder
{
    public function run()
    {
        $directors = [
            ['name' => 'James Cameron'],
            ['name' => 'Byron Howard'],
            ['name' => 'Jennifer Lee'],
            ['name' => 'Christopher Nolan'],
            ['name' => 'Taika Waititi'],
            ['name' => 'Bao Nguyen'],
            ['name' => 'Phan Duc Thien'],
            ['name' => 'Stephen Hillenburg'],
            ['name' => 'Haruo Sotozaki'],
            ['name' => 'Tim Johnson'],
            ['name' => 'Akira Toriyama'],
            ['name' => 'Dang Nhat Minh'],
        ];

        foreach ($directors as $director) {
            Director::create($director);
        }
    }
}