<?php

namespace Tests\Feature;

use App\Models\Candidate;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Laravel\Sanctum\Sanctum;
use PHPOpenSourceSaver\JWTAuth\Facades\JWTAuth;
use Tests\TestCase;


class CandidateControllerTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        // Configuración inicial
    }

    /** @test */
    public function it_returns_a_list_of_candidates_for_manager()
    {

        $user = User::factory()->create(['role' => 'manager']);
        $token = JWTAuth::fromUser($user);

        Sanctum::actingAs($user, ['*']);
        Candidate::factory()->count(3)->create();

        $response = $this->withHeaders([
            'Authorization' => 'Bearer '.$token,
        ])->json('GET', '/api/lead');

        $response->assertStatus(200)
        ->assertJsonCount(3, 'data');
    }
}
