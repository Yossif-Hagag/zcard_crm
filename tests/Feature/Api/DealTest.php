<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\Deal;

use App\Models\Lead;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class DealTest extends TestCase
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
    public function it_gets_deals_list(): void
    {
        $deals = Deal::factory()
            ->count(5)
            ->create();

        $response = $this->getJson(route('api.deals.index'));

        $response->assertOk()->assertSee($deals[0]->customer_name);
    }

    /**
     * @test
     */
    public function it_stores_the_deal(): void
    {
        $data = Deal::factory()
            ->make()
            ->toArray();

        $response = $this->postJson(route('api.deals.store'), $data);

        $this->assertDatabaseHas('deals', $data);

        $response->assertStatus(201)->assertJsonFragment($data);
    }

    /**
     * @test
     */
    public function it_updates_the_deal(): void
    {
        $deal = Deal::factory()->create();

        $lead = Lead::factory()->create();

        $data = [
            'customer_name' => $this->faker->text(255),
            'customer_phone' => $this->faker->text(255),
            'customer_address' => $this->faker->text(255),
            'cost' => $this->faker->randomNumber(0),
            'deal_date' => $this->faker->date(),
            'delivery_date' => $this->faker->date(),
            'card_name' => [],
            'lead_id' => $lead->id,
        ];

        $response = $this->putJson(route('api.deals.update', $deal), $data);

        $data['id'] = $deal->id;

        $this->assertDatabaseHas('deals', $data);

        $response->assertOk()->assertJsonFragment($data);
    }

    /**
     * @test
     */
    public function it_deletes_the_deal(): void
    {
        $deal = Deal::factory()->create();

        $response = $this->deleteJson(route('api.deals.destroy', $deal));

        $this->assertModelMissing($deal);

        $response->assertNoContent();
    }
}
