<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\Order;

use App\Models\Lead;
use App\Models\Status;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class OrderTest extends TestCase
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
    public function it_gets_orders_list(): void
    {
        $orders = Order::factory()
            ->count(5)
            ->create();

        $response = $this->getJson(route('api.orders.index'));

        $response->assertOk()->assertSee($orders[0]->customer_name);
    }

    /**
     * @test
     */
    public function it_stores_the_order(): void
    {
        $data = Order::factory()
            ->make()
            ->toArray();

        $response = $this->postJson(route('api.orders.store'), $data);

        $this->assertDatabaseHas('orders', $data);

        $response->assertStatus(201)->assertJsonFragment($data);
    }

    /**
     * @test
     */
    public function it_updates_the_order(): void
    {
        $order = Order::factory()->create();

        $status = Status::factory()->create();
        $lead = Lead::factory()->create();

        $data = [
            'customer_name' => $this->faker->text(255),
            'customer_phone' => $this->faker->text(255),
            'customer_address' => $this->faker->text(255),
            'cost' => $this->faker->randomNumber(0),
            'order_date' => $this->faker->date(),
            'delivery_date' => $this->faker->date(),
            'card_name' => [],
            'status_id' => $status->id,
            'lead_id' => $lead->id,
        ];

        $response = $this->putJson(route('api.orders.update', $order), $data);

        $data['id'] = $order->id;

        $this->assertDatabaseHas('orders', $data);

        $response->assertOk()->assertJsonFragment($data);
    }

    /**
     * @test
     */
    public function it_deletes_the_order(): void
    {
        $order = Order::factory()->create();

        $response = $this->deleteJson(route('api.orders.destroy', $order));

        $this->assertModelMissing($order);

        $response->assertNoContent();
    }
}
