<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;

class AuthControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_register_user()
    {
        $userData = [
            'name' => 'Ivan Gomez',
            'email' => 'ivan.gomez@gmail.com',
            'password' => 'Q2w3e4r5T',
        ];

        $response = $this->json('POST', '/api/register', $userData);

        $response->assertStatus(201)
            ->assertJsonStructure(['token']);
    }

    public function test_login_user_with_valid_credentials()
    {
        $user = User::factory()->create([
            'email' => 'ivan.gomez@gmail.com',
            'password' => bcrypt('Q2w3e4r5T'),
        ]);

        $loginData = [
            'email' => 'ivan.gomez@gmail.com',
            'password' => 'Q2w3e4r5T',
        ];

        $response = $this->json('POST', '/api/login', $loginData);

        $response->assertStatus(200)
            ->assertJsonStructure(['token']);
    }

    public function test_login_user_with_invalid_credentials()
    {
        $invalidLoginData = [
            'email' => 'ivan.no.existo@gmail.com',
            'password' => 'no-existo',
        ];

        $response = $this->json('POST', '/api/login', $invalidLoginData);

        $response->assertStatus(401)
            ->assertJson(['message' => 'Invalid credentials']);
    }

    public function test_logout_user()
    {
        $user = User::factory()->create();
        $token = $user->createToken('test-token')->plainTextToken;

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $token,
        ])->json('POST', '/api/logout');

        $response->assertStatus(200)
            ->assertJson(['message' => 'Logged out successfully']);
    }
}

