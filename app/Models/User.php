<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * Các thuộc tính có thể gán hàng loạt
     *
     * @var array<int,string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role', // admin hoặc customer
        'phone',    // Add this line
        'hobbies',  // Add this line
        'avatar',   // Add this line
    ];

    /**
     * Các thuộc tính bị ẩn khi trả về JSON
     *
     * @var array<int,string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Các thuộc tính cần cast kiểu dữ liệu
     *
     * @var array<string,string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    /**
     * Quan hệ 1-n với Booking
     */
    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }
}