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

    public function __invoke(PostRecipeRequest $request): JsonResponse{
        return response()->json($this->recipeService->postRecipe($request), Response::HTTP_CREATED);
    }
}
