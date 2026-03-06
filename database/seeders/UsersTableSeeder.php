<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UsersTableSeeder extends Seeder
{
    public function run(): void
    {
        // ===== ADMIN =====
        User::updateOrCreate(
            ['email' => 'quebac@gmail.com'],
            [
                'name'     => 'Nobu',
                'password' => Hash::make('123456789'),
                'role'     => 'admin',
                'phone'    => '0328230825',
                'hobbies'  => null,
                'avatar'   => null,
            ]
        );

        // ===== CUSTOMER =====
        User::updateOrCreate(
            ['email' => 'kietdz@gmail.com'],
            [
                'name'     => 'User',
                'password' => Hash::make('987654321'),
                'role'     => 'user',
                'phone'    => '0123456789',
                'hobbies'  => null,
                'avatar'   => null,
            ]
        );
    }
}