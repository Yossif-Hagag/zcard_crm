<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\Lead;
use App\Models\Deal;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class LeadDealsTest extends TestCase
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
    public function it_gets_lead_deals(): void
    {
        $lead = Lead::factory()->create();
        $deals = Deal::factory()
            ->count(2)
            ->create([
                'lead_id' => $lead->id,
            ]);

        $response = $this->getJson(route('api.leads.deals.index', $lead));

        $response->assertOk()->assertSee($deals[0]->customer_name);
    }

    /**
     * @test
     */
    public function it_stores_the_lead_deals(): void
    {
        $lead = Lead::factory()->create();
        $data = Deal::factory()
            ->make([
                'lead_id' => $lead->id,
            ])
            ->toArray();

        $response = $this->postJson(
            route('api.leads.deals.store', $lead),
            $data
        );

        $this->assertDatabaseHas('deals', $data);

        $response->assertStatus(201)->assertJsonFragment($data);

        $deal = Deal::latest('id')->first();

        $this->assertEquals($lead->id, $deal->lead_id);
    }
}
