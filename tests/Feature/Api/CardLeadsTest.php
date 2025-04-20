<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\Card;
use App\Models\Lead;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CardLeadsTest extends TestCase
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
    public function it_gets_card_leads(): void
    {
        $card = Card::factory()->create();
        $leads = Lead::factory()
            ->count(2)
            ->create([
                'card_id' => $card->id,
            ]);

        $response = $this->getJson(route('api.cards.leads.index', $card));

        $response->assertOk()->assertSee($leads[0]->name);
    }

    /**
     * @test
     */
    public function it_stores_the_card_leads(): void
    {
        $card = Card::factory()->create();
        $data = Lead::factory()
            ->make([
                'card_id' => $card->id,
            ])
            ->toArray();

        $response = $this->postJson(
            route('api.cards.leads.store', $card),
            $data
        );

        $this->assertDatabaseHas('leads', $data);

        $response->assertStatus(201)->assertJsonFragment($data);

        $lead = Lead::latest('id')->first();

        $this->assertEquals($card->id, $lead->card_id);
    }
}
