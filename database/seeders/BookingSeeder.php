<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Booking;
use App\Models\User;
use App\Models\Showtime;
use Illuminate\Support\Str;

class BookingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Lấy tất cả user và showtime
        $users = User::all();
        $showtimes = Showtime::all();

        // Nếu không có user hoặc showtime thì dừng
        if ($users->isEmpty() || $showtimes->isEmpty()) {
            $this->command->info('No users or showtimes found, skipping bookings seeding.');
            return;
        }

        // Tạo 50 booking ngẫu nhiên
        for ($i = 0; $i < 5; $i++) {
            $user = $users->random();
            $showtime = $showtimes->random();

            Booking::create([
                'user_id' => $user->id,
                'showtime_id' => $showtime->id,
                'booking_time' => now()->subDays(rand(0, 30))->subMinutes(rand(0, 1440)), // ngẫu nhiên 30 ngày gần đây
                'total_amount' => rand(50, 300) * 1000 / 1000, // 50 → 300 ngàn (decimal)
                'status' => ['pending', 'confirmed', 'canceled'][array_rand(['pending', 'confirmed', 'canceled'])]
            ]);
        }

        $this->command->info('Bookings seeding completed!');
    }
}