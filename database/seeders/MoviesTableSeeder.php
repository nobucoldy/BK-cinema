<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\Movie;
use App\Models\Actor;
use App\Models\Genre;

class MoviesTableSeeder extends Seeder
{
    public function run()
    {
        // Insert movies WITHOUT genre column
        DB::table('movies')->insert([
            [
                'title' => 'Avatar 3: Fire and Ash',
                'description' => 'A new conflict erupts on the planet Pandora as the Na\'vi face a fierce tribe connected to fire and ash.',
                'duration' => 197,
                'director_id' => 1,
                'release_date' => '2025-12-19',
                'poster_url' => 'posters/avatar.jpg',
                'trailer_url' => 'https://www.youtube.com/watch?v=nb_fFj_0rq8',
                'movie_backdrop' => 'movie_backdrops/avatar3.jpg',               
                'status' => 'showing',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'Zootopia 2: A Shocking Mission',
                'description' => 'Nick and Judy return in a large-scale case that threatens the entire city of Zootopia.',
                'duration' => 128,
                'director_id' => 2,
                'release_date' => '2025-11-28',
                'poster_url' => 'posters/caotho.jpg',
                'trailer_url' => 'https://www.youtube.com/watch?v=BjkIOU5PhyQ',
                'movie_backdrop' => 'movie_backdrops/caovatho2.webp',
                'status' => 'showing',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'Tom & Jerry: The Mysterious Compass',
                'description' => 'A mysterious compass unexpectedly opens a magical gateway, leading to a world full of challenges, laughter, and classic Tom & Jerry chases.',
                'duration' => 104,
                'director_id' => 3,
                'release_date' => '2026-01-01',
                'poster_url' => 'posters/tomjerry.jpg',
                'trailer_url' => 'https://www.youtube.com/watch?v=W4bVSaeIzwI',
                'movie_backdrop' => 'movie_backdrops/tomvajerry2.jpg',
                'status' => 'coming_soon',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'Truy tim Long Dien Huong',
                'description' => 'The treasured artifact of a coastal village is stolen, triggering a thrilling journey to recover it. The film blends spectacular martial arts, humor, and deep human values.',
                'duration' => 111,
                'director_id' => 4,
                'release_date' => '2025-11-14',
                'poster_url' => 'posters/longdienhuong.jpg',
                'trailer_url' => 'https://www.youtube.com/watch?v=-q1FYNMQBeU',
                'movie_backdrop' => 'movie_backdrops/ttldh2.jpg',
                'status' => 'showing',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'Now You See Me: Vanish and Reappear',
                'description' => 'The Four Horsemen officially return, teaming up with a new generation of Gen Z illusionists in the most daring diamond heist of their careers.',
                'duration' => 112,
                'director_id' => 5,
                'release_date' => '2025-11-28',
                'poster_url' => 'posters/phivutheky.jpg',
                'trailer_url' => 'https://www.youtube.com/watch?v=QLKI8NKyeKo',
                'movie_backdrop' => 'movie_backdrops/nysm.jpg',
                'status' => 'showing',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'Thien Duong Mau',
                'description' => 'Thien Duong Mau is the first Vietnamese film depicting human trafficking scams abroad. Lured by promises of easy jobs and high salaries, many victims are imprisoned and forced to scam their own people.',
                'duration' => 120,
                'director_id' => 6,
                'release_date' => '2025-12-31',
                'poster_url' => 'posters/thienduongmau.jpg',
                'trailer_url' => 'https://www.youtube.com/watch?v=46ASchtBIbE',
                'movie_backdrop' => 'movie_backdrops/tdm.jpg',
                'status' => 'coming_soon',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'Hoang Tu Quy',
                'description' => 'The story follows Than Duc, a prince born through dark magic. After escaping the forbidden palace, he seeks to free the Bone Demon from the Eye Gate to restore the Bone Demon Cult.',
                'duration' => 117,
                'director_id' => 7,
                'release_date' => '2025-12-05',
                'poster_url' => 'posters/hoangtuquy.jpg',
                'trailer_url' => 'https://www.youtube.com/watch?v=Rc-0s7oeON8',
                'movie_backdrop' => 'movie_backdrops/hoangtuquy2.webp',
                'status' => 'showing',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'SpongeBob: The Pirate Curse',
                'description' => 'SpongeBob ventures into the deep sea to confront the ghost of the Flying Dutchman, overcoming challenges and uncovering mysterious secrets beneath the ocean.',
                'duration' => 96,
                'director_id' => 8,
                'release_date' => '2025-12-15',
                'poster_url' => 'posters/spongebob.jpg',
                'trailer_url' => 'https://www.youtube.com/watch?v=XdPt8QWTypI',
                'movie_backdrop' => 'movie_backdrops/lauchen.webp',
                'status' => 'showing',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'Demon Slayer: Infinity Castle',
                'description' => 'The Demon Slayer Corps storms Infinity Castle to defeat Muzan. Tanjiro and the remaining Hashira must face the final members of the Twelve Kizuki.',
                'duration' => 155,
                'director_id' => 9,
                'release_date' => '2026-01-29',
                'poster_url' => 'posters/thanhguomdietquy.jpg',
                'trailer_url' => 'https://www.youtube.com/watch?v=rf0hW__Skow',
                'movie_backdrop' => 'movie_backdrops/tgdq2.webp',
                'status' => 'coming_soon',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'The Smurfs',
                'description' => 'When Papa Smurf is mysteriously kidnapped by the evil wizards Razamel and Gargamel, Smurfette leads the Smurfs into the real world to rescue him and save the universe.',
                'duration' => 92,
                'director_id' => 10,
                'release_date' => '2025-12-17',
                'poster_url' => 'posters/xitrum.png',
                'trailer_url' => 'https://www.youtube.com/watch?v=cSYyn_SijOc',
                'movie_backdrop' => 'movie_backdrops/xitrum2.webp',
                'status' => 'showing',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'Dragon Ball Super: Broly',
                'description' => 'Goku and Vegeta face Broly, a powerful Saiyan driven by rage, in an epic battle that shakes the fate of the universe.',
                'duration' => 102,
                'director_id' => 11,
                'release_date' => '2025-12-29',
                'poster_url' => 'posters/dragonball.png',
                'trailer_url' => 'https://www.youtube.com/watch?v=FHgm89hKpXU',
                'movie_backdrop' => 'movie_backdrops/7vnr.jpg',
                'status' => 'coming_soon',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'Con ke ba nghe',
                'description' => '"My Son Tells His Father" follows a tightrope walker and his withdrawn son on a journey to rediscover a lost connection. Amidst the dazzling yet fragile lights of the circus stage, the father and son gradually open up and heal old wounds. The film both celebrates Vietnamese circus art and reminds us of the importance of family in modern life.',
                'duration' => 111,
                'director_id' => 12,
                'release_date' => '2025-01-16',
                'poster_url' => 'posters/conkebanghe.jpg',
                'trailer_url' => 'https://www.youtube.com/watch?v=8QYwOWO4jCQ',
                'movie_backdrop' => 'movie_backdrops/conkebanghe2.jpg',
                'status' => 'coming_soon',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);

        // Attach Actors & Genres to Movies (Many-to-Many)
        $movies = Movie::all();
        $actors = Actor::all();
        $genres = Genre::all();

        // Movie 1: Avatar - Actors: 1,2,3 | Genres: 1,2,3
        if ($movies->count() > 0 && $actors->count() > 0) {
            $movies[0]->actors()->sync([1, 2, 3]);
        }
        if ($movies->count() > 0 && $genres->count() > 0) {
            $movies[0]->genres()->sync([1, 2, 3]);
        }

        // Movie 2: Zootopia - Actors: 4,5,6 | Genres: 4,5,2
        if ($movies->count() > 1 && $actors->count() > 3) {
            $movies[1]->actors()->sync([4, 5, 6]);
        }
        if ($movies->count() > 1 && $genres->count() > 2) {
            $movies[1]->genres()->sync([4, 5, 2]);
        }

        // Movie 3: Tom & Jerry - Actors: 7,8 | Genres: 4,2,6
        if ($movies->count() > 2 && $actors->count() > 6) {
            $movies[2]->actors()->sync([7, 8]);
        }
        if ($movies->count() > 2 && $genres->count() > 3) {
            $movies[2]->genres()->sync([4, 2, 6]);
        }

        // Movie 4: Truy tim Long - Actors: 9,10 | Genres: 5,3
        if ($movies->count() > 3 && $actors->count() > 8) {
            $movies[3]->actors()->sync([9, 10]);
        }
        if ($movies->count() > 3 && $genres->count() > 1) {
            $movies[3]->genres()->sync([5, 3]);
        }

        // Movie 5: Now You See Me - Actors: 11,12,13 | Genres: 3,7,6
        if ($movies->count() > 4 && $actors->count() > 10) {
            $movies[4]->actors()->sync([11, 12, 13]);
        }
        if ($movies->count() > 4 && $genres->count() > 3) {
            $movies[4]->genres()->sync([3, 7, 6]);
        }

        // Movie 6: Thien Duong Mau - Actors: 14,15 | Genres: 3,7
        if ($movies->count() > 5 && $actors->count() > 13) {
            $movies[5]->actors()->sync([14, 15]);
        }
        if ($movies->count() > 5 && $genres->count() > 2) {
            $movies[5]->genres()->sync([3, 7]);
        }

        // Movie 7: Hoang Tu Quy - Actors: 16 | Genres: 8
        if ($movies->count() > 6 && $actors->count() > 15) {
            $movies[6]->actors()->sync([16]);
        }
        if ($movies->count() > 6 && $genres->count() > 7) {
            $movies[6]->genres()->sync([8]);
        }

        // Movie 8: SpongeBob - Actors: 17,18 | Genres: 5,4,2
        if ($movies->count() > 7 && $actors->count() > 16) {
            $movies[7]->actors()->sync([17, 18]);
        }
        if ($movies->count() > 7 && $genres->count() > 2) {
            $movies[7]->genres()->sync([5, 4, 2]);
        }

        // Movie 9: Demon Slayer - Actors: 19,20,21 | Genres: 3
        if ($movies->count() > 8 && $actors->count() > 18) {
            $movies[8]->actors()->sync([19, 20, 21]);
        }
        if ($movies->count() > 8 && $genres->count() > 0) {
            $movies[8]->genres()->sync([3]);
        }

        // Movie 10: The Smurfs - Actors: 22,23 | Genres: 4,5,2
        if ($movies->count() > 9 && $actors->count() > 21) {
            $movies[9]->actors()->sync([22, 23]);
        }
        if ($movies->count() > 9 && $genres->count() > 2) {
            $movies[9]->genres()->sync([4, 5, 2]);
        }

        // Movie 11: Dragon Ball - Actors: 24,25 | Genres: 3,4
        if ($movies->count() > 10 && $actors->count() > 23) {
            $movies[10]->actors()->sync([24, 25]);
        }
        if ($movies->count() > 10 && $genres->count() > 3) {
            $movies[10]->genres()->sync([3, 4]);
        }

        // Movie 12: Con ke ba nghe - Actors: 26,27 | Genres: 5,9,10
        if ($movies->count() > 11 && $actors->count() > 25) {
            $movies[11]->actors()->sync([26, 27]);
        }
        if ($movies->count() > 11 && $genres->count() > 8) {
            $movies[11]->genres()->sync([5, 9, 10]);
        }
    }
}