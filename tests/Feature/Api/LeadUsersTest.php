<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\Lead;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class LeadUsersTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    protected function setUp(): void
    {
        parent::setUp();

        $user = User::factory()->create(['email' => 'admin@admin.com']);

        Sanctum::actingAs($user, [], 'web');

        $this->seed(\Database\Seeders\PermissionsSeeder::class);

        $this->withoutExceptionHandling();
    }

    /**
     * @test
     */
    public function it_gets_lead_users(): void
    {
        $lead = Lead::factory()->create();
        $user = User::factory()->create();

        $lead->users()->attach($user);

        $response = $this->getJson(route('api.leads.users.index', $lead));

        $response->assertOk()->assertSee($user->name);
    }

    /**
     * @test
     */
    public function it_can_attach_users_to_lead(): void
    {
        $lead = Lead::factory()->create();
        $user = User::factory()->create();

        $response = $this->postJson(
            route('api.leads.users.store', [$lead, $user])
        );

        $response->assertNoContent();

        $this->assertTrue(
            $lead
                ->users()
                ->where('users.id', $user->id)
                ->exists()
        );
    }

    /**
     * @test
     */
    public function it_can_detach_users_from_lead(): void
    {
        $lead = Lead::factory()->create();
        $user = User::factory()->create();

        $response = $this->deleteJson(
            route('api.leads.users.store', [$lead, $user])
        );

        $response->assertNoContent();

        $this->assertFalse(
            $lead
                ->users()
                ->where('users.id', $user->id)
                ->exists()
        );
    }
}
