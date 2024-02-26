<?php

declare(strict_types=1);

namespace App\Http\Controllers\recipes;

use App\Models\Ingredient;
use App\Models\Recipe;
use App\Services\RecipeService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Http\JsonResponse;

use App\Http\Requests\PostRecipeRequest;

class RecipeController
{
    public function __construct(
        private RecipeService $recipeService
    ) {
    }

    public function post(PostRecipeRequest $request): JsonResponse{
        $id = $request->user()->id;
        $name = $request->name;
        $description = $request->description;
        $time_required_min = $request->time_required_min;
        $seasonings = $request->seasonings;
        $steps = $request->steps;
        $image_path = $request->image_path ?? '';
        $raw_ingredients = $request->ingredients;

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
