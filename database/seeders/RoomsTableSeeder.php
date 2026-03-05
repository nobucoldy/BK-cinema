<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use App\Models\Theater;

class RoomsTableSeeder extends Seeder
{
    public function run()
    {
        // Tắt khóa ngoại để xóa sạch bảng cũ
        Schema::disableForeignKeyConstraints();
        DB::table('rooms')->truncate();
        Schema::enableForeignKeyConstraints();

        $theaters = Theater::all();
        $roomCounter = 1;

        // Tạo phòng cho từng rạp - mỗi rạp có số phòng khác nhau (2-5 phòng)
        foreach ($theaters as $theater) {
            $numRooms = rand(2, 5);

            for ($i = 1; $i <= $numRooms; $i++) {
                DB::table('rooms')->insert([
                    'id' => $roomCounter,
                    'theater_id' => $theater->id,
                    'name' => 'Room ' . $i,
                    'total_seats' => rand(80, 150),
                    'created_at' => now(),
                    'updated_at' => now()
                ]);
                $roomCounter++;
            }
        }

        $this->command->info('✅ Rooms created: Each theater has 2-5 rooms!');
    }
}