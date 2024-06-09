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

    /** @test */
    public function it_returns_an_empty_list_of_candidates_for_manager()
    {

        $user = User::factory()->create(['role' => 'manager']);
        $token = JWTAuth::fromUser($user);

        $response = $this->withHeaders([
            'Authorization' => 'Bearer '.$token,
        ])->json('GET', '/api/lead');

        $response->assertStatus(404)
            ->assertJsonCount(0, 'data');
    }

    /** @test */
    public function it_creates_a_new_candidate_for_manager()
    {
        $user = User::factory()->create(['role' => 'manager']);
        $token = JWTAuth::fromUser($user);

        $candidateData = Candidate::factory()->make()->toArray();

        $response = $this->withHeaders([
            'Authorization' => 'Bearer '.$token,
        ])->json('POST', '/api/lead', $candidateData);

        $response->assertStatus(201)
            ->assertJson([
                'data' => [
                    'name' => $candidateData['name'],
                ],
            ]);

        $this->assertDatabaseHas('candidates', $candidateData);
    }

    /** @test */
    public function it_returns_candidate_details_for_agent_or_manager()
    {
        $user = User::factory()->create(['role' => 'agent']);
        $candidate = Candidate::factory(['owner'=> $user->id])->create();
        $token = JWTAuth::fromUser($user);

        $response = $this->withHeaders([
            'Authorization' => 'Bearer '.$token,
        ])->json('GET', '/api/lead/'.$candidate->id);

        $response->assertStatus(200)
            ->assertJson([
                'data' => [
                    'id' => $candidate->id,
                ],
            ]);
    }

    /** @test */
    public function it_returns_404_if_candidate_not_found_for_agent_or_manager()
    {
        $user = User::factory()->create(['role' => 'agent']);
        $token = JWTAuth::fromUser($user);

        $response = $this->withHeaders([
            'Authorization' => 'Bearer '.$token,
        ])->json('GET', '/api/lead/9999');

        $response->assertStatus(404);
    }
}
