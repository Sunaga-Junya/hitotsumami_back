<?php

declare(strict_types=1);

namespace App\Services;

use App\Models\Ingredient;
use App\Models\Recipe;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;

use App\Http\Requests\PostRecipeRequest;

class RecipeService{
    public function postRecipe(
        int $id,
        String $name, 
        String $description, 
        int $time_required_min, 
        array $seasonings, 
        array $steps, 
        String $image_path,
        array $raw_ingredients
    ): array{

        $recipe = Recipe::create([
            'user_id' => $id, 
            'name' => $name,
            'description' => $description,
            'time_required_min' => $time_required_min,
            'seasonings' => $seasonings,
            'steps' => $steps,
            'image_path' => $image_path,
        ]);

        $ingredients = collect($raw_ingredients)->mapWithKeys(function ($ingredient) {
            $ingredient_id = Ingredient::where('name', $ingredient['name'])->value('id');
            return [$ingredient_id => ['quantity' => $ingredient['quantity']]];
        });

        $recipe->ingredients()->attach($ingredients);

        return $recipe->toArray();
    }
}
