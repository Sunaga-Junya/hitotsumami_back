<?php

declare(strict_types=1);

namespace App\Services;

use App\Models\Recipe;

class RecipeService
{
    public function getRecipes(): array
    {
        $recipes = Recipe::with('ingredients')->get()->map(function ($recipe) {
            //TODO　本来なら$recipe->ingredientsとするのが望ましいが、なぜかうまくいかないので対症療法。後で治す
            $raw_ingredients = $recipe->toArray()['ingredients'];
            $ingredients = [];
            foreach ($raw_ingredients as $ingredient) {
                array_push($ingredients, [
                    'id' => $ingredient['id'],
                    'name' => $ingredient['name'],
                    'quantity' => $ingredient['pivot']['quantity'],
                ]);
            }

            return [
                'id' => $recipe->id,
                'name' => $recipe->name,
                'ingredients' => $ingredients,
            ];
        });

        return $recipes->toArray();
    }
}

