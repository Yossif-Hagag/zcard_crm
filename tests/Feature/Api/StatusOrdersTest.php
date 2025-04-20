<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\Order;
use App\Models\Status;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class StatusOrdersTest extends TestCase
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
    public function it_gets_status_orders(): void
    {
        $status = Status::factory()->create();
        $orders = Order::factory()
            ->count(2)
            ->create([
                'status_id' => $status->id,
            ]);

        $response = $this->getJson(route('api.statuses.orders.index', $status));

        $response->assertOk()->assertSee($orders[0]->customer_name);
    }

    /**
     * @test
     */
    public function it_stores_the_status_orders(): void
    {
        $status = Status::factory()->create();
        $data = Order::factory()
            ->make([
                'status_id' => $status->id,
            ])
            ->toArray();

        $response = $this->postJson(
            route('api.statuses.orders.store', $status),
            $data
        );

        $this->assertDatabaseHas('orders', $data);

        $response->assertStatus(201)->assertJsonFragment($data);

        $order = Order::latest('id')->first();

        $this->assertEquals($status->id, $order->status_id);
    }
}
