<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

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
            'name' => fake()->userName(),
            'description' => fake()->realText($maxNbChars = 100),
            'time_required_min' => randomNumber($nbDigits = 2),
            'seasonings' => [['name' => 'syoyu', 'quantity' => '200g']],
            'steps' => [['content' => 'test'], ['content' => 'test2']],
            'password' => static::$password ??= Hash::make('password'),
            // 'remember_token' => Str::random(10),
        ];
    }
}
