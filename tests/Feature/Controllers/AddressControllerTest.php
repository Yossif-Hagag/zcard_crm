<?php

namespace Tests\Feature\Controllers;

use App\Models\User;
use App\Models\Address;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class AddressControllerTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    protected function setUp(): void
    {
        parent::setUp();

        $this->actingAs(
            User::factory()->create(['email' => 'admin@admin.com'])
        );

        $this->seed(\Database\Seeders\PermissionsSeeder::class);

        $this->withoutExceptionHandling();
    }

    /**
     * @test
     */
    public function it_displays_index_view_with_addresses(): void
    {
        $addresses = Address::factory()
            ->count(5)
            ->create();

        $response = $this->get(route('addresses.index'));

        $response
            ->assertOk()
            ->assertViewIs('app.addresses.index')
            ->assertViewHas('addresses');
    }

    /**
     * @test
     */
    public function it_displays_create_view_for_address(): void
    {
        $response = $this->get(route('addresses.create'));

        $response->assertOk()->assertViewIs('app.addresses.create');
    }

    /**
     * @test
     */
    public function it_stores_the_address(): void
    {
        $data = Address::factory()
            ->make()
            ->toArray();

        $response = $this->post(route('addresses.store'), $data);

        $this->assertDatabaseHas('addresses', $data);

        $address = Address::latest('id')->first();

        $response->assertRedirect(route('addresses.edit', $address));
    }

    /**
     * @test
     */
    public function it_displays_show_view_for_address(): void
    {
        $address = Address::factory()->create();

        $response = $this->get(route('addresses.show', $address));

        $response
            ->assertOk()
            ->assertViewIs('app.addresses.show')
            ->assertViewHas('address');
    }

    /**
     * @test
     */
    public function it_displays_edit_view_for_address(): void
    {
        $address = Address::factory()->create();

        $response = $this->get(route('addresses.edit', $address));

        $response
            ->assertOk()
            ->assertViewIs('app.addresses.edit')
            ->assertViewHas('address');
    }

    /**
     * @test
     */
    public function it_updates_the_address(): void
    {
        $address = Address::factory()->create();

        $data = [
            'address' => $this->faker->address(),
            'flat_number' => $this->faker->text(255),
            'floor' => $this->faker->text(255),
            'description' => $this->faker->sentence(15),
        ];

        $response = $this->put(route('addresses.update', $address), $data);

        $data['id'] = $address->id;

        $this->assertDatabaseHas('addresses', $data);

        $response->assertRedirect(route('addresses.edit', $address));
    }

    /**
     * @test
     */
    public function it_deletes_the_address(): void
    {
        $address = Address::factory()->create();

        $response = $this->delete(route('addresses.destroy', $address));

        $response->assertRedirect(route('addresses.index'));

        $this->assertModelMissing($address);
    }
}
