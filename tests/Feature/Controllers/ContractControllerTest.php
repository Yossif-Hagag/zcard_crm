<?php

namespace Tests\Feature\Controllers;

use App\Models\User;
use App\Models\Contract;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ContractControllerTest extends TestCase
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
    public function it_displays_index_view_with_contracts(): void
    {
        $contracts = Contract::factory()
            ->count(5)
            ->create();

        $response = $this->get(route('contracts.index'));

        $response
            ->assertOk()
            ->assertViewIs('app.contracts.index')
            ->assertViewHas('contracts');
    }

    /**
     * @test
     */
    public function it_displays_create_view_for_contract(): void
    {
        $response = $this->get(route('contracts.create'));

        $response->assertOk()->assertViewIs('app.contracts.create');
    }

    /**
     * @test
     */
    public function it_stores_the_contract(): void
    {
        $data = Contract::factory()
            ->make()
            ->toArray();

        $response = $this->post(route('contracts.store'), $data);

        $this->assertDatabaseHas('contracts', $data);

        $contract = Contract::latest('id')->first();

        $response->assertRedirect(route('contracts.edit', $contract));
    }

    /**
     * @test
     */
    public function it_displays_show_view_for_contract(): void
    {
        $contract = Contract::factory()->create();

        $response = $this->get(route('contracts.show', $contract));

        $response
            ->assertOk()
            ->assertViewIs('app.contracts.show')
            ->assertViewHas('contract');
    }

    /**
     * @test
     */
    public function it_displays_edit_view_for_contract(): void
    {
        $contract = Contract::factory()->create();

        $response = $this->get(route('contracts.edit', $contract));

        $response
            ->assertOk()
            ->assertViewIs('app.contracts.edit')
            ->assertViewHas('contract');
    }

    /**
     * @test
     */
    public function it_updates_the_contract(): void
    {
        $contract = Contract::factory()->create();

        $data = [
            'name' => $this->faker->name(),
        ];

        $response = $this->put(route('contracts.update', $contract), $data);

        $data['id'] = $contract->id;

        $this->assertDatabaseHas('contracts', $data);

        $response->assertRedirect(route('contracts.edit', $contract));
    }

    /**
     * @test
     */
    public function it_deletes_the_contract(): void
    {
        $contract = Contract::factory()->create();

        $response = $this->delete(route('contracts.destroy', $contract));

        $response->assertRedirect(route('contracts.index'));

        $this->assertModelMissing($contract);
    }
}
