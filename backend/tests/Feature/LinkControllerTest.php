<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use App\Models\Link;

class LinkControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_list_links()
    {
        $user = User::factory()->create();
        $token = $user->createToken('test-token')->plainTextToken;

        Link::factory(5)->create(['user_id' => $user->id]);

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $token,
        ])->json('GET', '/api/links');

        $response->assertStatus(200)
            ->assertJsonStructure([
                'data' => [
                    'data' => [
                        "*" => [
                            'title',
                            'url',
                            'short_url',
                            'created_at',
                            'updated_at',
                        ]
                    ],
                    'pagination' => [
                        'current_page',
                        'last_page',
                        'per_page',
                        'total',
                    ],
                ],
                
            ]);
    }

    public function test_create_link()
    {
        $user = User::factory()->create();
        $token = $user->createToken('test-token')->plainTextToken;

        $linkData = [
            'title' => 'Test Link',
            'url' => 'http://example.com',
            'short_url' => 'test',
        ];

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $token,
        ])->json('POST', '/api/links', $linkData);

        $response->assertStatus(200)
            ->assertJsonStructure([
                'data' => 
                [
                    'title',
                    'url',
                    'short_url',
                    'created_at',
                    'updated_at',
                ]
                
            ]);
    }

    public function test_update_link()
    {
        $user = User::factory()->create();
        $token = $user->createToken('test-token')->plainTextToken;

        $link = Link::factory()->create(['user_id' => $user->id]);

        $updateData = [
            'title' => 'Updated Link',
            'url' => 'http://updated.com',
            'short_url' => 'updated',
        ];

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $token,
        ])->json('PUT', '/api/links/' . $link->id, $updateData);

        $response->assertStatus(200)
            ->assertJsonStructure([
                'data' => [
                    'id',
                    'title',
                    'url',
                    'short_url',
                    'created_at',
                    'updated_at',
                ],
            ]);
    }

    public function test_delete_link()
    {
        $user = User::factory()->create();
        $token = $user->createToken('test-token')->plainTextToken;

        $link = Link::factory()->create(['user_id' => $user->id]);

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $token,
        ])->json('DELETE', '/api/links/' . $link->id);

        $response->assertStatus(200)
            ->assertJson([]);
    }
}

