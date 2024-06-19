<?php

namespace Tests\Feature;

use App\Models\User;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class UpdateUserTest extends TestCase
{
    use RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();

        $user = User::factory()->create();
        $this->token = JWTAuth::fromUser($user);
    }

    public function test_guest_user_cannot_update_a_user(): void
    {
        //having
            $user = User::factory()->create();

        //doing
        $data = User::factory()->raw(); //update data
        $this->putJson("{$this->apiBase}/user/{$user->id}", $data)
        ->assertStatus(401);
        //expecting
        $this->assertDatabaseHas("users", [
            "id"=> $user->id,
            "name" => $user->name
        ]);
        
    }

    public function test_authenticated_user_can_update_a_user(): void
    {
        //having
            $user = User::factory()->create();

        //doing
        $data = User::factory()->raw(); //update data

        $this->withToken($this->token)->putJson("{$this->apiBase}/user/{$user->id}", $data)
        ->assertStatus(200);

        //expecting
        $this->assertDatabaseHas("users", [
            "id"=> $user->id,
            "name" => $data['name'],
        ]);
        
    }
}
