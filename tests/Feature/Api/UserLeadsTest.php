<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\Lead;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UserLeadsTest extends TestCase
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
    public function it_gets_user_leads(): void
    {
        $user = User::factory()->create();
        $lead = Lead::factory()->create();

        $user->leads()->attach($lead);

        $response = $this->getJson(route('api.users.leads.index', $user));

        $response->assertOk()->assertSee($lead->name);
    }

    /**
     * @test
     */
    public function it_can_attach_leads_to_user(): void
    {
        $user = User::factory()->create();
        $lead = Lead::factory()->create();

        $response = $this->postJson(
            route('api.users.leads.store', [$user, $lead])
        );

        $response->assertNoContent();

        $this->assertTrue(
            $user
                ->leads()
                ->where('leads.id', $lead->id)
                ->exists()
        );
    }

    /**
     * @test
     */
    public function it_can_detach_leads_from_user(): void
    {
        $user = User::factory()->create();
        $lead = Lead::factory()->create();

        $response = $this->deleteJson(
            route('api.users.leads.store', [$user, $lead])
        );

        $response->assertNoContent();

        $this->assertFalse(
            $user
                ->leads()
                ->where('leads.id', $lead->id)
                ->exists()
        );
    }
}
