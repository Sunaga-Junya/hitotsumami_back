<?php

declare(strict_types=1);

namespace App\Http\Controllers\recipes;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

use App\Models\Recipe;

class RecipeController
{
    public function post(Request $request)
    {
        $data = $request->json()->all();
        $recipe = new Recipe();

        $recipe -> create([
            'user_id' => '1',
            'name' => $data['name'],
            'description' => $data['description'],
            'time_required_min' => $data['time_required_min'],
            'seasonings' => $data['seasonings'],
            'steps' => $data['steps'],
            'image_path' => $data['image_path'],
        ]);
        
        return response()->json($data);
    }
}
