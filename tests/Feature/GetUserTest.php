<?php

namespace Tests\Feature;

use App\Models\User;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class GetUserTest extends TestCase
{
    use RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();

        $user = User::factory()->create();
        $this->token = JWTAuth::fromUser($user);
    }
    public function test_authenticated_user_can_get_a_user(): void
    {
        //having
        $data = User::factory()->create();

        //doing
        $response = $this->withToken($this->token)->getJson("{$this->apiBase}/user/{$data->id}");

        //expecting
        // Verify JSON response
        $response->assertStatus(200);
        $response->assertJson([
            'data' => [
                'id' => $data->id,
                'name' => $data->name,
                'email' => $data->email
            ]
        ]);
    }

    public function test_guest_user_cannot_get_a_user(): void
    {
        //having
        $data = User::factory()->create();

        //doing
        $response = $this->getJson("{$this->apiBase}/user/{$data->id}");

        //expecting
        $response->assertStatus(401);
    }
}
