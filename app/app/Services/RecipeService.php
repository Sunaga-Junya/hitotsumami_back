<?php

declare(strict_types=1);

namespace App\Services;

use App\Models\Ingredient;
use App\Models\Recipe;

class RecipeService
{
    /**
     * @param array<array{name: string, quantity: string}> $seasonings
     * @param array<array{name: string, quantity: int}> $raw_ingredients
     * @param array<array{content: string}> $steps
     * @return array{
     *     user_id: int,
     *     name: string,
     *     description: string,
     *     time_required_min: int,
     *     seasonings: array<array{name: string, quantity: string}>,
     *     steps: array<array{content: string}>,
     *     updated_at: string,
     *     created_at: string,
     *     id: int
     * }[]
     */
    public function postRecipe(
        int $id,
        String $name,
        String $description,
        int $time_required_min,
        array $seasonings,
        array $steps,
        String $image_path,
        array $raw_ingredients
    ): array {

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

