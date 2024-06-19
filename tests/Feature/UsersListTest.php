<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tests\TestCase;

class UsersListTest extends TestCase
{
    use RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();

        $user = User::factory()->create();

        $this->token = JWTAuth::fromUser($user);
    }

    public function test_authenticated_user_can_get_list_of_users(): void{
       // Having
       $users = User::factory()->count(10)->create();
      

    // Doing
    $response = $this->withToken($this->token)->get("{$this->apiBase}/users");

    // Expecting
    $response->assertStatus(200)
             ->assertJsonCount(11); //It has to be 11 with the user we create to authenticate

    }

    public function test_guest_user_cannot_get_list_of_users(): void{
        
        //$this->withoutExceptionHandling();
        // Having
        $users = User::factory()->count(10)->create();
       
 
     // Doing
     $response = $this->getJson("{$this->apiBase}/users");
 
     // Expecting
     $response->assertStatus(401);

 
     }
   
}
