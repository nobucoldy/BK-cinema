<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ScreeningType extends Model
{
    protected $fillable = [
        'format',
        'language',
        'label',
        'extra_price'
    ];
}