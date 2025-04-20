<?php

namespace Tests\Feature\Controllers;

use App\Models\User;
use App\Models\Deal;

use App\Models\Lead;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class DealControllerTest extends TestCase
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

    protected function castToJson($json)
    {
        if (is_array($json)) {
            $json = addslashes(json_encode($json));
        } elseif (is_null($json) || is_null(json_decode($json))) {
            throw new \Exception(
                'A valid JSON string was not provided for casting.'
            );
        }

        return \DB::raw("CAST('{$json}' AS JSON)");
    }

    /**
     * @test
     */
    public function it_displays_index_view_with_deals(): void
    {
        $deals = Deal::factory()
            ->count(5)
            ->create();

        $response = $this->get(route('deals.index'));

        $response
            ->assertOk()
            ->assertViewIs('app.deals.index')
            ->assertViewHas('deals');
    }

    /**
     * @test
     */
    public function it_displays_create_view_for_deal(): void
    {
        $response = $this->get(route('deals.create'));

        $response->assertOk()->assertViewIs('app.deals.create');
    }

    /**
     * @test
     */
    public function it_stores_the_deal(): void
    {
        $data = Deal::factory()
            ->make()
            ->toArray();

        $data['card_name'] = json_encode($data['card_name']);

        $response = $this->post(route('deals.store'), $data);

        $data['card_name'] = $this->castToJson($data['card_name']);

        $this->assertDatabaseHas('deals', $data);

        $deal = Deal::latest('id')->first();

        $response->assertRedirect(route('deals.edit', $deal));
    }

    /**
     * @test
     */
    public function it_displays_show_view_for_deal(): void
    {
        $deal = Deal::factory()->create();

        $response = $this->get(route('deals.show', $deal));

        $response
            ->assertOk()
            ->assertViewIs('app.deals.show')
            ->assertViewHas('deal');
    }

    /**
     * @test
     */
    public function it_displays_edit_view_for_deal(): void
    {
        $deal = Deal::factory()->create();

        $response = $this->get(route('deals.edit', $deal));

        $response
            ->assertOk()
            ->assertViewIs('app.deals.edit')
            ->assertViewHas('deal');
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

        $data['card_name'] = json_encode($data['card_name']);

        $response = $this->put(route('deals.update', $deal), $data);

        $data['id'] = $deal->id;

        $data['card_name'] = $this->castToJson($data['card_name']);

        $this->assertDatabaseHas('deals', $data);

        $response->assertRedirect(route('deals.edit', $deal));
    }

    /**
     * @test
     */
    public function it_deletes_the_deal(): void
    {
        $deal = Deal::factory()->create();

        $response = $this->delete(route('deals.destroy', $deal));

        $response->assertRedirect(route('deals.index'));

        $this->assertModelMissing($deal);
    }
}
