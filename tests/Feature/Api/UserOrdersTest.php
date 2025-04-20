<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\Order;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UserOrdersTest extends TestCase
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
    public function it_gets_user_orders(): void
    {
        $user = User::factory()->create();
        $order = Order::factory()->create();

        $user->orders()->attach($order);

        $response = $this->getJson(route('api.users.orders.index', $user));

        $response->assertOk()->assertSee($order->customer_name);
    }

    /**
     * @test
     */
    public function it_can_attach_orders_to_user(): void
    {
        $user = User::factory()->create();
        $order = Order::factory()->create();

        $response = $this->postJson(
            route('api.users.orders.store', [$user, $order])
        );

        $response->assertNoContent();

        $this->assertTrue(
            $user
                ->orders()
                ->where('orders.id', $order->id)
                ->exists()
        );
    }

    /**
     * @test
     */
    public function it_can_detach_orders_from_user(): void
    {
        $user = User::factory()->create();
        $order = Order::factory()->create();

        $response = $this->deleteJson(
            route('api.users.orders.store', [$user, $order])
        );

        $response->assertNoContent();

        $this->assertFalse(
            $user
                ->orders()
                ->where('orders.id', $order->id)
                ->exists()
        );
    }
}
