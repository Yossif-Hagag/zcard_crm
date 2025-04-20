<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\Lead;
use App\Models\Stage;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class StageLeadsTest extends TestCase
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
    public function it_gets_stage_leads(): void
    {
        $stage = Stage::factory()->create();
        $leads = Lead::factory()
            ->count(2)
            ->create([
                'stage_id' => $stage->id,
            ]);

        $response = $this->getJson(route('api.stages.leads.index', $stage));

        $response->assertOk()->assertSee($leads[0]->name);
    }

    /**
     * @test
     */
    public function it_stores_the_stage_leads(): void
    {
        $stage = Stage::factory()->create();
        $data = Lead::factory()
            ->make([
                'stage_id' => $stage->id,
            ])
            ->toArray();

        $response = $this->postJson(
            route('api.stages.leads.store', $stage),
            $data
        );

        $this->assertDatabaseHas('leads', $data);

        $response->assertStatus(201)->assertJsonFragment($data);

        $lead = Lead::latest('id')->first();

        $this->assertEquals($stage->id, $lead->stage_id);
    }
}
