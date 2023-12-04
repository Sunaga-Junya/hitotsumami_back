<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Recipe extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 'name', 'description', 'time_required_min', 'seasonings', 'steps', 'image_path',
    ];

    protected $casts = [
        'seasonings' => 'json',
        'steps' => 'json',
    ];
}
