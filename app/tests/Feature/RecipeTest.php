<?php

namespace Tests\Feature;

use App\Models\Ingredient;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Log;
use Tests\TestCase;

class RecipeTest extends TestCase
{
    use RefreshDatabase;

    private $user;

    private $ingredient;

    private $token;

    protected function setUp(): void
    {
        parent::setUp();

        $this->user = User::factory()->create();
        $this->ingredient = Ingredient::factory()->create();
        $this->token = $this->user->createToken('token')->plainTextToken;
    }

    public function test_post_recipe_by_valid_user(): void
    {

        Log::debug('Bearer '.$this->token);

        $response = $this->withHeaders([
            'Authorization' => 'Bearer '.$this->token,
        ])->postJson('/api/recipes', [
            'name' => 'test',
            'description' => 'test',
            'time_required_min' => 10,
            'ingredients' => [['name' => 'キャベツ', 'quantity' => 1]],
            'seasonings' => [['name' => 'syoyu', 'quantity' => '200g']],
            'steps' => [['content' => 'test'], ['content' => 'test2']],
            'image_path' => '',
        ]);

        $response->assertCreated();
        $this->assertDatabaseHas('recipes', [
            'name' => 'test',
        ]);
        $this->assertDatabaseHas('recipe_ingredient', [
            'recipe_id' => $response['id'],
        ]);
    }

    public function test_post_recipe_by_invalid_user(): void
    {
        $wrong_token = 'XXXXX';

        $response = $this->withHeaders([
            'Authorization' => 'Bearer '.$wrong_token,
        ])->postJson('/api/recipes', [
            'name' => 'test',
            'description' => 'test',
            'time_required_min' => 10,
            'ingredients' => [['name' => 'キャベツ', 'quantity' => 1]],
            'seasonings' => [['name' => 'syoyu', 'quantity' => '200g']],
            'steps' => [['content' => 'test'], ['content' => 'test2']],
            'image_path' => '',
        ]);

        $response->assertUnauthorized();
    }

    public function test_post_recipe_for_bad_request(): void
    {

        $response = $this->withHeaders([
            'Authorization' => 'Bearer '.$this->token,
        ])->postJson('/api/recipes', [
            // 'name' => 'test',
            'description' => 'test',
            'time_required_min' => 10,
            'ingredients' => [['name' => 'キャベツ', 'quantity' => 1]],
            'seasonings' => [['name' => 'syoyu', 'quantity' => '200g']],
            'steps' => [['content' => 'test'], ['content' => 'test2']],
            'image_path' => '',
        ]);

        $response->assertStatus(400);
    }
}
