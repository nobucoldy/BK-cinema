<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Actor;

class ActorsTableSeeder extends Seeder
{
    public function run()
    {
        $actors = [
            ['name' => 'Sam Worthington'],
            ['name' => 'Zoe Saldana'],
            ['name' => 'Idris Elba'],
            ['name' => 'Chris Pratt'],
            ['name' => 'Emma Stone'],
            ['name' => 'Tom Holland'],
            ['name' => 'Johnny Depp'],
            ['name' => 'Anne Hathaway'],
            ['name' => 'Dwayne Johnson'],
            ['name' => 'Will Smith'],
            ['name' => 'Channing Tatum'],
            ['name' => 'Ryan Reynolds'],
            ['name' => 'Ben Affleck'],
            ['name' => 'Michael B. Jordan'],
            ['name' => 'Denzel Washington'],
            ['name' => 'Omar Sy'],
            ['name' => 'Bill Murray'],
            ['name' => 'Jada Pinkett Smith'],
            ['name' => 'Tanjiro Kamado'],
            ['name' => 'Nezuko Kamado'],
            ['name' => 'Giyuu Tomioka'],
            ['name' => 'Neil Patrick Harris'],
            ['name' => 'Gal Gadot'],
            ['name' => 'Son Goku'],
            ['name' => 'Vegeta'],
            ['name' => 'Trieu Tuan'],
            ['name' => 'Kieu Minh Tuan'],
        ];

        foreach ($actors as $actor) {
            Actor::create($actor);
        }
    }
}