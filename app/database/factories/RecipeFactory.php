<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Recipe>
 */
class RecipeFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'name' => fake()->userName(),
            'description' => fake()->realText($maxNbChars = 100),
            'time_required_min' => fake()->randomNumber($nbDigits = 2),
            'seasonings' => [['name' => 'syoyu', 'quantity' => '200g']],
            'steps' => [['content' => 'test'], ['content' => 'test2']],
            'image_path' => '',
        ];
    }
}
