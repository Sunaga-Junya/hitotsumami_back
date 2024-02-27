<?php

namespace Tests\Feature;

use App\Models\Ingredient;
use App\Models\Recipe;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Log;
use Tests\TestCase;
#おまじない　これがないとphpstanがpostJsonに文句を言う。継承をうまく認識できていないみたい。
use Illuminate\Foundation\Testing\Concerns\MakesHttpRequests;
use Illuminate\Foundation\Testing\Concerns\InteractsWithDatabase;

class RecipeTest extends TestCase
{
    use RefreshDatabase;
    use MakesHttpRequests;
    use InteractsWithDatabase;

    private User $user;

    private string $token;

    protected function setUp(): void
    {
        parent::setUp();
        $this->numRecipe = 4;

        $this->user = User::factory()->create();

        $this->recipe = Recipe::factory()->count($this->numRecipe)->hasAttached(Ingredient::factory()->create(), ['quantity' => 20])->create();
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

    public function test_post_recipe_no_name(): void
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

        $response->assertBadRequest();
    }

    public function test_post_recipe_no_ingredients(): void
    {

        $response = $this->withHeaders([
            'Authorization' => 'Bearer '.$this->token,
        ])->postJson('/api/recipes', [
            'name' => 'test',
            'description' => 'test',
            'time_required_min' => 10,
            'ingredients' => [],
            'seasonings' => [['name' => 'syoyu', 'quantity' => '200g']],
            'steps' => [['content' => 'test'], ['content' => 'test2']],
            'image_path' => '',
        ]);

        $response->assertBadRequest();
    }

    /**
     * @test
     *
     * @group now
     */
    public function test_get_recipe(): void
    {
        $response = $this->get('/api/recipes');
        $response->assertOk()
            ->assertJsonCount($this->numRecipe)
            ->assertJsonStructure([
                '*' => [
                    'id',
                    'name',
                    'ingredients' => [
                        '*' => [
                            'id',
                            'name',
                            'quantity',
                        ],
                    ],
                ],
            ]);
    }
}

