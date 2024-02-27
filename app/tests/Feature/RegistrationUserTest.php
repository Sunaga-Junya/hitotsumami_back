<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Auth;
use Illuminate\Testing\Fluent\AssertableJson;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Foundation\Testing\Concerns\MakesHttpRequests;
use Tests\TestCase;

class RegistrationUserTest extends TestCase
{
    use RefreshDatabase;
    use MakesHttpRequests;

    public function test_registration_api_success(): void
    {
        $response = $this->postJson('/api/users', [
            'name' => 'alice',
            'email' => 'collect@yumemi.co.jp',
            'password' => 'password',
        ]);
        $this->assertTrue(Auth::attempt(['email' => 'collect@yumemi.co.jp', 'password' => 'password']));

        $response->assertJson(
            fn (AssertableJson $json) => $json->hasAll(['name', 'email'])
        );

    }

    public function test_registration_api_validation_error_by_wrong_name(): void
    {
        $response = $this->postJson('/api/users', [
            'name' => 10000,
            'email' => 'collect@yumemi.co.jp',
            'password' => 'password',
        ]);

        $response->assertStatus(Response::HTTP_BAD_REQUEST);
    }

    public function test_registration_api_validation_error_by_wrong_email(): void
    {
        $response = $this->postJson('/api/users', [
            'name' => 'Alice',
            'email' => 1000,
            'password' => 'password',
        ]);

        $response->assertStatus(Response::HTTP_BAD_REQUEST);
    }

    public function test_registration_api_validation_error_by_wrong_password(): void
    {
        $response = $this->postJson('/api/users', [
            'name' => 'Alice',
            'email' => 'collect@yumemi.co.jp',
            'password' => 10000,
        ]);

        $response->assertStatus(Response::HTTP_BAD_REQUEST);
    }
}
