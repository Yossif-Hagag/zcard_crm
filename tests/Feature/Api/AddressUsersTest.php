<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\Address;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class AddressUsersTest extends TestCase
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
    public function it_gets_address_users(): void
    {
        $address = Address::factory()->create();
        $user = User::factory()->create();

        $address->users()->attach($user);

        $response = $this->getJson(
            route('api.addresses.users.index', $address)
        );

        $response->assertOk()->assertSee($user->name);
    }

    /**
     * @test
     */
    public function it_can_attach_users_to_address(): void
    {
        $address = Address::factory()->create();
        $user = User::factory()->create();

        $response = $this->postJson(
            route('api.addresses.users.store', [$address, $user])
        );

        $response->assertNoContent();

        $this->assertTrue(
            $address
                ->users()
                ->where('users.id', $user->id)
                ->exists()
        );
    }

    /**
     * @test
     */
    public function it_can_detach_users_from_address(): void
    {
        $address = Address::factory()->create();
        $user = User::factory()->create();

        $response = $this->deleteJson(
            route('api.addresses.users.store', [$address, $user])
        );

        $response->assertNoContent();

        $this->assertFalse(
            $address
                ->users()
                ->where('users.id', $user->id)
                ->exists()
        );
    }
}
