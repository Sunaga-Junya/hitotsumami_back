<?php

declare(strict_types=1);

namespace App\Http\Controllers\recipes;

use App\Http\Requests\PostRecipeRequest;
use App\Models\Ingredient;
use App\Models\Recipe;
use App\Services\RecipeService;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\Response;

class RecipeController
{
    public function __construct(
        private RecipeService $recipeService
    ) {
    }

    public function get()
    {
        return response()->json($this->recipeService->getRecipes(), Response::HTTP_OK);
    }

    public function post(PostRecipeRequest $request)
    {
        $user = $request->user();

        $recipe = new Recipe();

        $created_recipe = $recipe->create([
            'user_id' => $user['id'],
            'name' => $request['name'],
            'description' => $request['description'],
            'time_required_min' => $request['time_required_min'],
            'seasonings' => $request['seasonings'],
            'steps' => $request['steps'],
            'image_path' => $request['image_path'],
        ]);

        $ingredients = $request['ingredients'];

        foreach ($ingredients as $ingredient) {
            $ingredient_id = Ingredient::where('name', $ingredient['name'])->value('id');
            $recipe_ingredient_data = [
                'recipe_id' => $created_recipe['id'],
                'ingredient_id' => $ingredient_id,
                'quantity' => $ingredient['quantity'],
                'created_at' => now(),
                'updated_at' => now(),
            ];

            DB::table('recipe_ingredient')->insert($recipe_ingredient_data);
        }

        return response()->json($created_recipe, Response::HTTP_CREATED);
    }
}
