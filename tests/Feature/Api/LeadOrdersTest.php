<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\Lead;
use App\Models\Order;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class LeadOrdersTest extends TestCase
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
    public function it_gets_lead_orders(): void
    {
        $lead = Lead::factory()->create();
        $orders = Order::factory()
            ->count(2)
            ->create([
                'lead_id' => $lead->id,
            ]);

        $response = $this->getJson(route('api.leads.orders.index', $lead));

        $response->assertOk()->assertSee($orders[0]->customer_name);
    }

    /**
     * @test
     */
    public function it_stores_the_lead_orders(): void
    {
        $lead = Lead::factory()->create();
        $data = Order::factory()
            ->make([
                'lead_id' => $lead->id,
            ])
            ->toArray();

        $response = $this->postJson(
            route('api.leads.orders.store', $lead),
            $data
        );

        $this->assertDatabaseHas('orders', $data);

        $response->assertStatus(201)->assertJsonFragment($data);

        $order = Order::latest('id')->first();

        $this->assertEquals($lead->id, $order->lead_id);
    }
}
