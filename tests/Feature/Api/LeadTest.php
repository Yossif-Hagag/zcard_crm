<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\Lead;

use App\Models\Card;
use App\Models\Stage;
use App\Models\Contract;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class LeadTest extends TestCase
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
    public function it_gets_leads_list(): void
    {
        $leads = Lead::factory()
            ->count(5)
            ->create();

        $response = $this->getJson(route('api.leads.index'));

        $response->assertOk()->assertSee($leads[0]->name);
    }

    /**
     * @test
     */
    public function it_stores_the_lead(): void
    {
        $data = Lead::factory()
            ->make()
            ->toArray();

        $response = $this->postJson(route('api.leads.store'), $data);

        $this->assertDatabaseHas('leads', $data);

        $response->assertStatus(201)->assertJsonFragment($data);
    }

    /**
     * @test
     */
    public function it_updates_the_lead(): void
    {
        $lead = Lead::factory()->create();

        $stage = Stage::factory()->create();
        $contract = Contract::factory()->create();
        $card = Card::factory()->create();

        $data = [
            'name' => $this->faker->name(),
            'phone' => $this->faker->phoneNumber(),
            'phone2' => $this->faker->text(255),
            'follow_date' => $this->faker->date(),
            'stage_id' => $stage->id,
            'contract_id' => $contract->id,
            'card_id' => $card->id,
        ];

        $response = $this->putJson(route('api.leads.update', $lead), $data);

        $data['id'] = $lead->id;

        $this->assertDatabaseHas('leads', $data);

        $response->assertOk()->assertJsonFragment($data);
    }

    /**
     * @test
     */
    public function it_deletes_the_lead(): void
    {
        $lead = Lead::factory()->create();

        $response = $this->deleteJson(route('api.leads.destroy', $lead));

        $this->assertSoftDeleted($lead);

        $response->assertNoContent();
    }
}
