<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

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

    public function ingredients(): BelongsToMany
    {
        return $this->belongsToMany(Ingredient::class, 'recipe_ingredient')
            ->withPivot('quantity');
    }

    public function users(): BelongsToMany
    {
        return $this->belongsToMany(Ingredient::class, 'goods')
            ->withPivot('quantity');
    }
}
