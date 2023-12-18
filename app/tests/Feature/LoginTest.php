<?php

namespace Tests\Feature;

use Illuminate\Support\Facades\Hash;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;


class LoginTest extends TestCase
{
    use RefreshDatabase;
    
    protected $user;

    public function setUp(): void
    {
        parent::setUp();

        $this->user = User::create([
            'name' => 'test',
            'email' => 'test@example.com',
            'password' => Hash::make('password')
        ]);
    }

    public function test_login_api_success(): void
    {
        $response = $this->postJson('/api/login',[
            'email' => 'test@example.com',
            'password' => 'password'
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
            'email' => 'test@example.com',
            'password' => 'wrong_password'
        ]);

        $response->assertUnauthorized();
    }
}
