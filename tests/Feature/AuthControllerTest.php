<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class AuthControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_register_success()
    {
        $response = $this->postJson('/api/auth/register', [
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => 'password123',
            'password_confirmation' => 'password123',
        ]);

        $response->assertStatus(201)
            ->assertJsonStructure([
                'meta',
                'data' => ['token'],
            ]);

        $this->assertDatabaseHas('users', [
            'email' => 'test@example.com',
        ]);
    }

    public function test_register_validation_error()
    {
        $response = $this->postJson('/api/auth/register', [
            'name' => '',
            'email' => 'invalid-email',
            'password' => 'short',
            'password_confirmation' => 'different',
        ]);

        $response->assertStatus(400)
            ->assertJsonStructure([
                'meta' => [
                    'success',
                    'errors' => [
                        'name',
                        'email',
                        'password',
                    ],
                ],
                'data',
            ])
            ->assertJson([
                'meta' => [
                    'success' => false,
                    'errors' => [
                        'name' => [
                            'The name field is required.',
                        ],
                        'email' => [
                            'The email field must be a valid email address.',
                        ],
                        'password' => [
                            'The password field must be at least 6 characters.',
                            'The password field confirmation does not match.',
                        ],
                    ],
                ],
                'data' => [],
            ]);
    }

    public function test_login_success()
    {
        $user = User::factory()->create([
            'username' => 'testuser',
            'password' => bcrypt('password123'),
        ]);

        $response = $this->postJson('/api/auth/login', [
            'username' => 'testuser',
            'password' => 'password123',
        ]);

        $response->assertStatus(200)
            ->assertJsonStructure([
                'meta' => [
                    'success',
                    'error',
                ],
                'data' => [
                    'token',
                    'minutes_to_expire',
                ],
            ]);
    }

    public function test_login_unauthorized()
    {
        $user = User::factory()->create([
            'username' => 'testuser',
            'password' => bcrypt('password123'),
        ]);

        $response = $this->postJson('/api/auth/login', [
            'username' => 'testuser',
            'password' => 'wrongpassword',
        ]);

        $response->assertStatus(401)
            ->assertJson([
                'error' => 'Unauthorized',
            ]);
    }

    public function test_logout_success()
    {
        $user = User::factory()->create();
        $token = auth()->login($user);

        $response = $this->withHeader('Authorization', "Bearer $token")->postJson('/api/auth/logout');

        $response->assertStatus(200)
            ->assertJson([
                'message' => 'Successfully logged out',
            ]);
    }

    // tests/Feature/AuthControllerTest.php

    public function test_me_success()
    {
        $user = User::factory()->create();
        $token = auth()->login($user);

        $response = $this->withHeader('Authorization', "Bearer $token")->getJson('/api/auth/me');

        $response->assertStatus(200)
            ->assertJson([
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
            ]);
    }



}
