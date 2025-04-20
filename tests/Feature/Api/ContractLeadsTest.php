<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\Lead;
use App\Models\Contract;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ContractLeadsTest extends TestCase
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
    public function it_gets_contract_leads(): void
    {
        $contract = Contract::factory()->create();
        $leads = Lead::factory()
            ->count(2)
            ->create([
                'contract_id' => $contract->id,
            ]);

        $response = $this->getJson(
            route('api.contracts.leads.index', $contract)
        );

        $response->assertOk()->assertSee($leads[0]->name);
    }

    /**
     * @test
     */
    public function it_stores_the_contract_leads(): void
    {
        $contract = Contract::factory()->create();
        $data = Lead::factory()
            ->make([
                'contract_id' => $contract->id,
            ])
            ->toArray();

        $response = $this->postJson(
            route('api.contracts.leads.store', $contract),
            $data
        );

        $this->assertDatabaseHas('leads', $data);

        $response->assertStatus(201)->assertJsonFragment($data);

        $lead = Lead::latest('id')->first();

        $this->assertEquals($contract->id, $lead->contract_id);
    }
}
