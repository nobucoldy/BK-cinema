<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Theater; // Import Model để code gọn hơn

class TheaterSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
{
    $theaters = [
        // HANOI REGION
        ['name' => 'BKL Cinema Ha Dong', 'location' => '4th Floor, Machinco Building, Tran Phu Str', 'city' => 'Hanoi', 'description' => 'Modern cinema with Dolby Atmos surround sound system.'],
        ['name' => 'BKL Cinema Cau Giay', 'location' => 'No. 1 Xuan Thuy Str, Dich Vong Hau Ward', 'city' => 'Hanoi', 'description' => 'Trendy space perfectly designed for students and young adults.'],
        ['name' => 'BKL Cinema Hoan Kiem', 'location' => '2nd Floor, Trang Tien Plaza, Hoan Kiem Dist', 'city' => 'Hanoi', 'description' => 'Luxury boutique cinema located in the heart of the capital.'],
        ['name' => 'BKL Cinema Tay Ho', 'location' => 'Lotte Mall West Lake, Vo Chi Cong Str', 'city' => 'Hanoi', 'description' => 'Premium viewing experience with breathtaking lake views.'],
        ['name' => 'BKL Cinema Long Bien', 'location' => 'Aeon Mall Long Bien, Co Linh Str', 'city' => 'Hanoi', 'description' => 'Giant screens and spacious seating for family weekends.'],
        ['name' => 'BKL Cinema Dong Da', 'location' => 'Vincom Center, 54A Nguyen Chi Thanh Str', 'city' => 'Hanoi', 'description' => 'High-tech projection systems for the ultimate movie lovers.'],

        // HO CHI MINH CITY REGION
        ['name' => 'BKL Cinema District 1', 'location' => 'Bitexco Financial Tower, Hai Trieu Str', 'city' => 'Ho Chi Minh', 'description' => 'High-end cinema experience at the iconic skyscraper.'],
        ['name' => 'BKL Cinema Landmark 81', 'location' => 'Vincom Landmark 81, Binh Thanh Dist', 'city' => 'Ho Chi Minh', 'description' => 'Vietnam highest cinema featuring IMAX technology.'],
        ['name' => 'BKL Cinema District 7', 'location' => 'Crescent Mall, Phu My Hung, District 7', 'city' => 'Ho Chi Minh', 'description' => 'International standard cinema for the expat community.'],
        ['name' => 'BKL Cinema Thu Duc', 'location' => 'Gigamall, Pham Van Dong Str, Thu Duc City', 'city' => 'Ho Chi Minh', 'description' => 'The entertainment hub of the city within a city.'],
        ['name' => 'BKL Cinema District 10', 'location' => 'Van Hanh Mall, Su Van Hanh Str', 'city' => 'Ho Chi Minh', 'description' => 'Dynamic atmosphere with the latest cinematic trends.'],
        ['name' => 'BKL Cinema Tan Binh', 'location' => 'Menas Mall, 60A Truong Son Str', 'city' => 'Ho Chi Minh', 'description' => 'Conveniently located right next to Tan Son Nhat Airport.'],

        // OTHER MAJOR CITIES
        ['name' => 'BKL Cinema Da Nang', 'location' => 'Indochina Riverside Mall, Hai Chau Dist', 'city' => 'Da Nang', 'description' => 'Premier cinema destination in the most livable city.'],
        ['name' => 'BKL Cinema Hai Phong', 'location' => 'Vincom Imperial, Hong Bang Dist', 'city' => 'Hai Phong', 'description' => 'Elite cinema services for the port city residents.'],
        ['name' => 'BKL Cinema Can Tho', 'location' => 'Sense City, Hoa Binh Blvd, Ninh Kieu Dist', 'city' => 'Can Tho', 'description' => 'Bringing the silver screen to the heart of the Mekong Delta.'],
        ['name' => 'BKL Cinema Nha Trang', 'location' => 'Gold Coast Mall, Tran Phu Str', 'city' => 'Nha Trang', 'description' => 'Enjoy blockbuster movies right by the beautiful beach.'],
        ['name' => 'BKL Cinema Da Lat', 'location' => 'Dalat Center, Phan Boi Chau Str', 'city' => 'Da Lat', 'description' => 'Cozy and romantic cinema space in the city of flowers.'],
        ['name' => 'BKL Cinema Vung Tau', 'location' => 'Lapen Center, 33A Street 30/4', 'city' => 'Vung Tau', 'description' => 'Modern entertainment for the coastal getaway.']
    ];

    foreach ($theaters as $theater) {
        Theater::create($theater);
    }
}
}