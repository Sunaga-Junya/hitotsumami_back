<?php

declare(strict_types=1);

namespace App\Http\Controllers\recipes;

use App\Models\Ingredient;
use App\Models\Recipe;
use App\Services\RecipeService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Http\Requests\PostRecipeRequest;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Http\JsonResponse;
use App\Services\RecipeService;

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

    public function post(PostRecipeRequest $request): JsonResponse
    {
        $id = $request->user()->id;
        $name = $request->input('name');
        $description = $request->input('description');
        $time_required_min = $request->input('time_required_min');
        $seasonings = $request->input('seasonings');
        $steps = $request->input('steps');
        $image_path = $request->input('image_path') ?? '';
        $raw_ingredients = $request->input('ingredients');

        return response()->json($this->recipeService->postRecipe(
            $id,
            $name,
            $description,
            $time_required_min,
            $seasonings,
            $steps,
            $image_path,
            $raw_ingredients
        ), Response::HTTP_CREATED);
    }
}
