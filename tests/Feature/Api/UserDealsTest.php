<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\Deal;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UserDealsTest extends TestCase
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
    public function it_gets_user_deals(): void
    {
        $user = User::factory()->create();
        $deal = Deal::factory()->create();

        $user->deals()->attach($deal);

        $response = $this->getJson(route('api.users.deals.index', $user));

        $response->assertOk()->assertSee($deal->customer_name);
    }

    /**
     * @test
     */
    public function it_can_attach_deals_to_user(): void
    {
        $user = User::factory()->create();
        $deal = Deal::factory()->create();

        $response = $this->postJson(
            route('api.users.deals.store', [$user, $deal])
        );

        $response->assertNoContent();

        $this->assertTrue(
            $user
                ->deals()
                ->where('deals.id', $deal->id)
                ->exists()
        );
    }

    /**
     * @test
     */
    public function it_can_detach_deals_from_user(): void
    {
        $user = User::factory()->create();
        $deal = Deal::factory()->create();

        $response = $this->deleteJson(
            route('api.users.deals.store', [$user, $deal])
        );

        $response->assertNoContent();

        $this->assertFalse(
            $user
                ->deals()
                ->where('deals.id', $deal->id)
                ->exists()
        );
    }
}
