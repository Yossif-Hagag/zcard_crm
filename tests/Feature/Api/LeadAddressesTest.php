<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\Lead;
use App\Models\Address;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class LeadAddressesTest extends TestCase
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
    public function it_gets_lead_addresses(): void
    {
        $lead = Lead::factory()->create();
        $address = Address::factory()->create();

        $lead->addresses()->attach($address);

        $response = $this->getJson(route('api.leads.addresses.index', $lead));

        $response->assertOk()->assertSee($address->address);
    }

    /**
     * @test
     */
    public function it_can_attach_addresses_to_lead(): void
    {
        $lead = Lead::factory()->create();
        $address = Address::factory()->create();

        $response = $this->postJson(
            route('api.leads.addresses.store', [$lead, $address])
        );

        $response->assertNoContent();

        $this->assertTrue(
            $lead
                ->addresses()
                ->where('addresses.id', $address->id)
                ->exists()
        );
    }

    /**
     * @test
     */
    public function it_can_detach_addresses_from_lead(): void
    {
        $lead = Lead::factory()->create();
        $address = Address::factory()->create();

        $response = $this->deleteJson(
            route('api.leads.addresses.store', [$lead, $address])
        );

        $response->assertNoContent();

        $this->assertFalse(
            $lead
                ->addresses()
                ->where('addresses.id', $address->id)
                ->exists()
        );
    }
}
