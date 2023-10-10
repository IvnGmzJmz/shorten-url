<?php

namespace Tests\Feature;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;

use Illuminate\Http\Request;
use App\Services\AuthService;
use Tests\TestCase;
use App\Models\User;

class AuthServiceTest extends TestCase
{
    use RefreshDatabase;

    public function test_validate_register()
    {
        $authService = new AuthService();
        $request = new Request([
            'name' => 'Ivan Gomez',
            'email' => 'ivan.gomez@gmail.com',
            'password' => 'Q2w3e4r5T',
        ]);

        $validated = $authService->validateRegister($request);

        $this->assertIsArray($validated);
        $this->assertArrayHasKey('name', $validated);
        $this->assertArrayHasKey('email', $validated);
        $this->assertArrayHasKey('password', $validated);
    }

    public function test_validate_login()
    {
        $authService = new AuthService();
        $request = new Request([
            'email' => 'ivan.gomez@gmail.com',
            'password' => 'Q2w3e4r5T',
        ]);

        $validated = $authService->validateLogin($request);

        $this->assertIsArray($validated);
        $this->assertArrayHasKey('email', $validated);
        $this->assertArrayHasKey('password', $validated);
    }

    public function test_create_token()
    {
        $authService = new AuthService();
        $user = User::factory()->create();

        $token = $authService->createToken($user);

        $this->assertNotEmpty($token);
    }

    public function test_deleteToken()
    {
        $authService = new AuthService();
        $user = User::factory()->create();
        $user->createToken('test-token');

        $authService->deleteToken($user);

        $this->assertCount(0, $user->tokens);
    }

    public function test_authentication_failure()
    {
        $authService = new AuthService();
        $credentials = [
            'email' => 'invalid.email@example.com',
            'password' => 'a',
        ];

        $token = $authService->generateToken($credentials);

        $this->assertNull($token);
    }

    public function test_delete_token_when_user_has_no_tokens()
    {
        $authService = new AuthService();
        $user = User::factory()->create();

        $authService->deleteToken($user);

        $this->assertCount(0, $user->tokens);
    }

}
