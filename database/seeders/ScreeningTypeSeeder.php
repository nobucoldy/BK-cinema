<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ScreeningTypeSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('screening_types')->insert([
            ['format'=>'2D','language'=>'SUB','label'=>'2D - SUB','extra_price'=>0],
            ['format'=>'2D','language'=>'DUB','label'=>'2D - DUB','extra_price'=>10000],
            ['format'=>'3D','language'=>'SUB','label'=>'3D - SUB','extra_price'=>30000],
            ['format'=>'3D','language'=>'DUB','label'=>'3D - DUB','extra_price'=>40000],
        ]);
    }
}