<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\Address;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UserAddressesTest extends TestCase
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
    public function it_gets_user_addresses(): void
    {
        $user = User::factory()->create();
        $address = Address::factory()->create();

        $user->addresses()->attach($address);

        $response = $this->getJson(route('api.users.addresses.index', $user));

        $response->assertOk()->assertSee($address->address);
    }

    /**
     * @test
     */
    public function it_can_attach_addresses_to_user(): void
    {
        $user = User::factory()->create();
        $address = Address::factory()->create();

        $response = $this->postJson(
            route('api.users.addresses.store', [$user, $address])
        );

        $response->assertNoContent();

        $this->assertTrue(
            $user
                ->addresses()
                ->where('addresses.id', $address->id)
                ->exists()
        );
    }

    /**
     * @test
     */
    public function it_can_detach_addresses_from_user(): void
    {
        $user = User::factory()->create();
        $address = Address::factory()->create();

        $response = $this->deleteJson(
            route('api.users.addresses.store', [$user, $address])
        );

        $response->assertNoContent();

        $this->assertFalse(
            $user
                ->addresses()
                ->where('addresses.id', $address->id)
                ->exists()
        );
    }
}
