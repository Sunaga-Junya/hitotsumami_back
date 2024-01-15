<?php

namespace Tests\Feature;

use Illuminate\Support\Facades\Hash;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Log;
use Tests\TestCase;
use App\Models\User;


class LoginTest extends TestCase
{
    use RefreshDatabase;
    
    private $user;

    public function setUp(): void
    {
        parent::setUp();
        $this->user = User::factory()->create();
    }

    public function test_login_api_success(): void
    {
        $response = $this->postJson('/api/login',[
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
        $response = $this->postJson('/api/login',[
            'email' => 'wrong@example.com',
            'password' => 'password'
        ]);

        $response->assertUnauthorized();
    }

    public function test_login_api_wrong_password(): void 
    {
        $response = $this->postJson('/api/login',[
            'email' => $this->user->email,
            'password' => 'wrong_password'
        ]);

        $response->assertUnauthorized();
    }

    public function test_login_api_no_password(): void 
    {
        $response = $this->postJson('/api/login',[
            'email' => $this->user->email,
            // 'password' => 'wrong_password'
        ]);

        $response->assertStatus(400);
    }

    public function test_login_api_validation_error(): void 
    {
        $response = $this->postJson('/api/login',[
            'email' => $this->user->email,
            'password' => 10045
        ]);

        $response->assertStatus(400);
    }
    
}
