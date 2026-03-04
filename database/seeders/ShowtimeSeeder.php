<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\ScreeningType;
use App\Models\Movie;
use App\Models\Theater;
use Carbon\Carbon;

class ShowtimeSeeder extends Seeder
{
    public function run()
    {
        $movies = Movie::all();
        $theaters = Theater::all();
        $timeSlots = ['10:00', '13:00', '16:00', '19:00', '21:30'];
        $screeningTypes = ScreeningType::pluck('id')->toArray();

        foreach ($theaters as $theater) {
            $rooms = $theater->rooms->toArray();
            if (empty($rooms)) continue;

            // Lặp 7 ngày
            for ($dayIndex = 0; $dayIndex < 7; $dayIndex++) {
                $showDate = Carbon::today()->addDays($dayIndex);

                // Mỗi phòm trong rạp được gán 1 time slot KHÁC NHAU per ngày
                foreach ($rooms as $roomIndex => $room) {
                    // Mỗi phòm lấy random phim
                    $randomMovie = $movies->random();

                    // Mỗi phòm lấy time slot KHÁC NHAU (modulo by room count)
                    $slotIndex = $roomIndex % count($timeSlots);
                    $roomTimeSlot = $timeSlots[$slotIndex];

                    $startTime = Carbon::parse($roomTimeSlot);
                    $endTime = $startTime->copy()->addMinutes(120);

                    DB::table('showtimes')->insert([
                        'movie_id'          => $randomMovie->id,
                        'theater_id'        => $theater->id,
                        'room_id'           => $room['id'],
                        'screening_type_id' => $screeningTypes[array_rand($screeningTypes)],
                        'show_date'         => $showDate->toDateString(),
                        'start_time'        => $startTime->format('H:i:s'),
                        'end_time'          => $endTime->format('H:i:s'),
                        'created_at'        => now(),
                        'updated_at'        => now(),
                    ]);
                }
            }
        }

        $this->command->info('✅ Showtimes seeded without conflicts!');
    }
}