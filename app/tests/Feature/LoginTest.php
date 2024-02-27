<?php

declare(strict_types=1);

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Symfony\Component\HttpFoundation\Response;
#おまじない　これがないとphpstanがpostJsonに文句を言う。継承をうまく認識できていないみたい。
use Illuminate\Foundation\Testing\Concerns\MakesHttpRequests;


use Tests\TestCase;
use App\Models\User;

class LoginTest extends TestCase
{
    use RefreshDatabase;
    use MakesHttpRequests;

    private User $user;

    public function setUp(): void
    {
        parent::setUp();
        $this->user = User::factory()->create();
    }

    public function test_login_api_success(): void
    {
        $response = $this->postJson('/api/login', [
            'email' => $this->user->email,
            'password' => 'password',
        ]);

        $response->assertOk();

        $responseData = $response->json();

        $this->assertArrayHasKey('token', $responseData);
        $this->assertEquals(50, strlen($responseData['token']));
    }

    public function test_login_api_wrong_email(): void
    {
        $response = $this->postJson('/api/login', [
            'email' => 'wrong@example.com',
            'password' => 'password'
        ]);

        $response->assertUnauthorized();
    }

    public function test_login_api_wrong_password(): void
    {
        $response = $this->postJson('/api/login', [
            'email' => $this->user->email,
            'password' => 'wrong_password'
        ]);

        $response->assertUnauthorized();
    }

    public function test_login_api_no_password(): void
    {
        $response = $this->postJson('/api/login', [
            'email' => $this->user->email,
            // 'password' => 'wrong_password'
        ]);

        $response->assertStatus(Response::HTTP_BAD_REQUEST);
    }

    public function test_login_api_validation_error_by_wrong_password(): void
    {
        $response = $this->postJson('/api/login', [
            'email' => $this->user->email,
            'password' => 10045
        ]);

        $response->assertStatus(Response::HTTP_BAD_REQUEST);
    }

    public function test_login_api_validation_error_by_wrong_email(): void
    {
        $response = $this->postJson('/api/login', [
            'email' => 1000,
            'password' => 'password'
        ]);

        $response->assertStatus(Response::HTTP_BAD_REQUEST);
    }

}
