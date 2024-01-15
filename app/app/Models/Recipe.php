<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Recipe extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 'name', 'description', 'time_required_min', 'seasonings', 'steps',
    ];

    protected $casts = [
        'ingredients' => 'json',
        'seasonings' => 'json',
        'steps' => 'json',
    ];
}
