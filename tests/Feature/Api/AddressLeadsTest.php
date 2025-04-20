<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\Lead;
use App\Models\Address;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class AddressLeadsTest extends TestCase
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
    public function it_gets_address_leads(): void
    {
        $address = Address::factory()->create();
        $lead = Lead::factory()->create();

        $address->leads()->attach($lead);

        $response = $this->getJson(
            route('api.addresses.leads.index', $address)
        );

        $response->assertOk()->assertSee($lead->name);
    }

    /**
     * @test
     */
    public function it_can_attach_leads_to_address(): void
    {
        $address = Address::factory()->create();
        $lead = Lead::factory()->create();

        $response = $this->postJson(
            route('api.addresses.leads.store', [$address, $lead])
        );

        $response->assertNoContent();

        $this->assertTrue(
            $address
                ->leads()
                ->where('leads.id', $lead->id)
                ->exists()
        );
    }

    /**
     * @test
     */
    public function it_can_detach_leads_from_address(): void
    {
        $address = Address::factory()->create();
        $lead = Lead::factory()->create();

        $response = $this->deleteJson(
            route('api.addresses.leads.store', [$address, $lead])
        );

        $response->assertNoContent();

        $this->assertFalse(
            $address
                ->leads()
                ->where('leads.id', $lead->id)
                ->exists()
        );
    }
}
