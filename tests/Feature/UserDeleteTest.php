<?php

namespace Tests\Feature;

use App\Models\User;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class UserDeleteTest extends TestCase
{
    use RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();

        $user = User::factory()->create();
        $this->token = JWTAuth::fromUser($user);
    }

    public function test_guest_user_cannot_delete_a_user(): void
    {
        //having
        $user = User::factory()->create();

        //doing

        $this->deleteJson("{$this->apiBase}/user/{$user->id}")
        ->assertStatus(401);

        //expectng   
       $this->assertDatabaseCount("users",2); //users should be 2 with the autenticated user

       
    }

    public function test_authenticated_user_can_delete_a_user(): void
    {
        //having
        $user = User::factory()->create();

        //doing

        $this->withToken($this->token)->deleteJson("{$this->apiBase}/user/{$user->id}")
        ->assertStatus(200);

        //expectng   
       $this->assertDatabaseCount("users",1); //users should be 1, just autenticated user

       
    }
}
