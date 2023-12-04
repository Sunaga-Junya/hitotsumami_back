<?php

declare(strict_types=1);

namespace App\Http\Controllers\recipes;

use App\Models\Ingredient;
use App\Models\Recipe;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class RecipeController
{
    public function post(Request $request)
    {
        $data = $request->json()->all();
        $is_badrequest = $this->check_invalid_request($data);
        if ($is_badrequest) {
            return response(null, 400);
        }
        $user = $request->user();

        $recipe = new Recipe();

        $created_recipe = $recipe->create([
            'user_id' => $user['id'],
            'name' => $data['name'],
            'description' => $data['description'],
            'time_required_min' => $data['time_required_min'],
            'seasonings' => $data['seasonings'],
            'steps' => $data['steps'],
            'image_path' => $data['image_path'],
        ]);

        $ingredients = $data['ingredients'];

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

        return response()->json($created_recipe, 201);
    }

    private function check_invalid_request($request_data)
    {
        Log::debug($request_data);
        $required_keys = ['name', 'description', 'ingredients', 'time_required_min', 'seasonings', 'steps', 'image_path'];
        Log::debug($required_keys);
        //nullableのカラムを除いて、keyの中身がnullの時
        foreach ($required_keys as $key) {
            if (! array_key_exists($key, $request_data)) {
                Log::debug('exist'.$key);

                return true;
            }
            if ($key == 'seasonings' || $key == 'image_path') {
                continue;
            }
            if (! isset($request_data[$key])) {
                Log::debug('null'.$request_data[$key]);

                return true;
            }
        }

        return false;
    }
}
