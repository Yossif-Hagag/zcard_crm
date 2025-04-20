<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\Order;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class OrderUsersTest extends TestCase
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
    public function it_gets_order_users(): void
    {
        $order = Order::factory()->create();
        $user = User::factory()->create();

        $order->users()->attach($user);

        $response = $this->getJson(route('api.orders.users.index', $order));

        $response->assertOk()->assertSee($user->name);
    }

    /**
     * @test
     */
    public function it_can_attach_users_to_order(): void
    {
        $order = Order::factory()->create();
        $user = User::factory()->create();

        $response = $this->postJson(
            route('api.orders.users.store', [$order, $user])
        );

        $response->assertNoContent();

        $this->assertTrue(
            $order
                ->users()
                ->where('users.id', $user->id)
                ->exists()
        );
    }

    /**
     * @test
     */
    public function it_can_detach_users_from_order(): void
    {
        $order = Order::factory()->create();
        $user = User::factory()->create();

        $response = $this->deleteJson(
            route('api.orders.users.store', [$order, $user])
        );

        $response->assertNoContent();

        $this->assertFalse(
            $order
                ->users()
                ->where('users.id', $user->id)
                ->exists()
        );
    }
}
