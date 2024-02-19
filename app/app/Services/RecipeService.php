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
    public function postRecipe(PostRecipeRequest $request): array{

        $user = $request->user();

        $recipe = Recipe::create([
            'user_id' => $user->id, 
            'name' => $request->name,
            'description' => $request->description,
            'time_required_min' => $request->time_required_min,
            'seasonings' => $request->seasonings,
            'steps' => $request->steps,
            'image_path' => $request->image_path,
        ]);

        $ingredients = collect($request->ingredients)->mapWithKeys(function ($ingredient) {
            $ingredient_id = Ingredient::where('name', $ingredient['name'])->value('id');
            return [$ingredient_id => ['quantity' => $ingredient['quantity']]];
        });

        $recipe->ingredients()->attach($ingredients);

        return $recipe->toArray();
    }
}
