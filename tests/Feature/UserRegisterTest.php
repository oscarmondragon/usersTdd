<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tymon\JWTAuth\Facades\JWTAuth;

use Tests\TestCase;

class UserRegisterTest extends TestCase
{
    /**
     * A basic feature test example.
     */

    use RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();

        $user = User::factory()->create();

        $this->token = JWTAuth::fromUser($user);
    }

    public function test_guest_user_not_allow_to_create_a_new_user(): void
    {
        //having

        $data = User::factory()->raw();
        //doing
        $response = $this->postJson("{$this->apiBase}/users", $data);

        //expecting
        $response->assertStatus(401);

        $this->assertDatabaseCount('users', 1); // It has to be 1, because we have one authenticated at setUp


    }
    public function test_authenticated_user_can_create_a_new_user(): void
    {
        //having
        $data = User::factory()->raw();

        //doing

        $response = $this->withToken($this->token)->postJson("{$this->apiBase}/users", $data);

        //expecting
        $response->assertStatus(201);

        $this->assertDatabaseCount('users', 2); // It has to be 2, because we have one authenticated  at setUp

    }
}
