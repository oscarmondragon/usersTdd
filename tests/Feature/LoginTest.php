<?php

namespace Tests\Feature;

use Database\Seeders\UserSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class LoginTest extends TestCase
{

    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed(UserSeeder::class);
    }


    public function test_an_existing_user_can_login(): void
    {

        $this->withoutExceptionHandling();
        #having
        $credentials = ['email' => 'oscar@example.com', 'password' => 'password'];

        #doing
        $response = $this->post("{$this->apiBase}/login", $credentials);

        #expecting
        $response->assertStatus(200);
        $response->assertJsonStructure(['access_token']);
    }

    public function test_an_non_existing_user_cannot_login(): void
    {
        #having
        $credentials = ['email' => 'example@nonexample.com', 'password' => '55888787878787'];

        #doing
        $response = $this->post("{$this->apiBase}/login", $credentials);

        #expecting
        $response->assertStatus(401);
        $response->assertJsonFragment(['error' => 'Unauthorized']);
    }


    public function test_email_is_required(): void
    {
        #having
        $credentials = ['password' => '1222238888'];

        #doing
        $response = $this->postJson("{$this->apiBase}/login", $credentials);

        #expecting
        $response->assertUnprocessable();
        $response->assertJsonStructure(['errors' => ['email']]);
    }


    public function test_password_is_required(): void
    {
        #having
        $credentials = ['email' => 'oscar@test.com',];

        #doing
        $response = $this->postJson("{$this->apiBase}/login", $credentials);

        #expecting
        $response->assertUnprocessable();
        $response->assertJsonStructure(['errors' => ['password']]);
    }

    public function test_email_must_be_an_email(): void
    {
        #having
        $credentials = ['email' => 'oscaraaa', 'password' => '222222222'];

        #doing
        $response = $this->postJson("{$this->apiBase}/login", $credentials);


        #expecting
        $response->assertUnprocessable();
        $response->assertJsonFragment([
            'message' => 'The email field must be a valid email address.',
            'errors' => [
                'email' => ['The email field must be a valid email address.']
            ]
        ]);
    }

    public function test_password_must_be_at_least_8(): void
    {
        #having
        $credentials = ['email' => 'oscaraa@gmail.com', 'password' => '243'];

        #doing
        $response = $this->postJson("{$this->apiBase}/login", $credentials);


        #expecting
        $response->assertUnprocessable();
        $response->assertJsonFragment([
            'message' => 'The password field must be at least 8 characters.',
            'errors' => [
                'password' => ['The password field must be at least 8 characters.']
            ]
        ]);
    }

}
