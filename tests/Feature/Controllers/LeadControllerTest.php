<?php

namespace Tests\Feature\Controllers;

use App\Models\User;
use App\Models\Lead;

use App\Models\Card;
use App\Models\Stage;
use App\Models\Contract;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class LeadControllerTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    protected function setUp(): void
    {
        parent::setUp();

        $this->actingAs(
            User::factory()->create(['email' => 'admin@admin.com'])
        );

        $this->seed(\Database\Seeders\PermissionsSeeder::class);

        $this->withoutExceptionHandling();
    }

    /**
     * @test
     */
    public function it_displays_index_view_with_leads(): void
    {
        $leads = Lead::factory()
            ->count(5)
            ->create();

        $response = $this->get(route('leads.index'));

        $response
            ->assertOk()
            ->assertViewIs('app.leads.index')
            ->assertViewHas('leads');
    }

    /**
     * @test
     */
    public function it_displays_create_view_for_lead(): void
    {
        $response = $this->get(route('leads.create'));

        $response->assertOk()->assertViewIs('app.leads.create');
    }

    /**
     * @test
     */
    public function it_stores_the_lead(): void
    {
        $data = Lead::factory()
            ->make()
            ->toArray();

        $response = $this->post(route('leads.store'), $data);

        $this->assertDatabaseHas('leads', $data);

        $lead = Lead::latest('id')->first();

        $response->assertRedirect(route('leads.edit', $lead));
    }

    /**
     * @test
     */
    public function it_displays_show_view_for_lead(): void
    {
        $lead = Lead::factory()->create();

        $response = $this->get(route('leads.show', $lead));

        $response
            ->assertOk()
            ->assertViewIs('app.leads.show')
            ->assertViewHas('lead');
    }

    /**
     * @test
     */
    public function it_displays_edit_view_for_lead(): void
    {
        $lead = Lead::factory()->create();

        $response = $this->get(route('leads.edit', $lead));

        $response
            ->assertOk()
            ->assertViewIs('app.leads.edit')
            ->assertViewHas('lead');
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

        $response = $this->put(route('leads.update', $lead), $data);

        $data['id'] = $lead->id;

        $this->assertDatabaseHas('leads', $data);

        $response->assertRedirect(route('leads.edit', $lead));
    }

    /**
     * @test
     */
    public function it_deletes_the_lead(): void
    {
        $lead = Lead::factory()->create();

        $response = $this->delete(route('leads.destroy', $lead));

        $response->assertRedirect(route('leads.index'));

        $this->assertSoftDeleted($lead);
    }
}
