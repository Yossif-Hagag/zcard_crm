<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\Deal;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class DealUsersTest extends TestCase
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
    public function it_gets_deal_users(): void
    {
        $deal = Deal::factory()->create();
        $user = User::factory()->create();

        $deal->users()->attach($user);

        $response = $this->getJson(route('api.deals.users.index', $deal));

        $response->assertOk()->assertSee($user->name);
    }

    /**
     * @test
     */
    public function it_can_attach_users_to_deal(): void
    {
        $deal = Deal::factory()->create();
        $user = User::factory()->create();

        $response = $this->postJson(
            route('api.deals.users.store', [$deal, $user])
        );

        $response->assertNoContent();

        $this->assertTrue(
            $deal
                ->users()
                ->where('users.id', $user->id)
                ->exists()
        );
    }

    /**
     * @test
     */
    public function it_can_detach_users_from_deal(): void
    {
        $deal = Deal::factory()->create();
        $user = User::factory()->create();

        $response = $this->deleteJson(
            route('api.deals.users.store', [$deal, $user])
        );

        $response->assertNoContent();

        $this->assertFalse(
            $deal
                ->users()
                ->where('users.id', $user->id)
                ->exists()
        );
    }
}
