<?php

namespace Tests\Feature\Controllers;

use App\Models\User;
use App\Models\Stage;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class StageControllerTest extends TestCase
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
    public function it_displays_index_view_with_stages(): void
    {
        $stages = Stage::factory()
            ->count(5)
            ->create();

        $response = $this->get(route('stages.index'));

        $response
            ->assertOk()
            ->assertViewIs('app.stages.index')
            ->assertViewHas('stages');
    }

    /**
     * @test
     */
    public function it_displays_create_view_for_stage(): void
    {
        $response = $this->get(route('stages.create'));

        $response->assertOk()->assertViewIs('app.stages.create');
    }

    /**
     * @test
     */
    public function it_stores_the_stage(): void
    {
        $data = Stage::factory()
            ->make()
            ->toArray();

        $response = $this->post(route('stages.store'), $data);

        $this->assertDatabaseHas('stages', $data);

        $stage = Stage::latest('id')->first();

        $response->assertRedirect(route('stages.edit', $stage));
    }

    /**
     * @test
     */
    public function it_displays_show_view_for_stage(): void
    {
        $stage = Stage::factory()->create();

        $response = $this->get(route('stages.show', $stage));

        $response
            ->assertOk()
            ->assertViewIs('app.stages.show')
            ->assertViewHas('stage');
    }

    /**
     * @test
     */
    public function it_displays_edit_view_for_stage(): void
    {
        $stage = Stage::factory()->create();

        $response = $this->get(route('stages.edit', $stage));

        $response
            ->assertOk()
            ->assertViewIs('app.stages.edit')
            ->assertViewHas('stage');
    }

    /**
     * @test
     */
    public function it_updates_the_stage(): void
    {
        $stage = Stage::factory()->create();

        $data = [
            'name' => $this->faker->name(),
        ];

        $response = $this->put(route('stages.update', $stage), $data);

        $data['id'] = $stage->id;

        $this->assertDatabaseHas('stages', $data);

        $response->assertRedirect(route('stages.edit', $stage));
    }

    /**
     * @test
     */
    public function it_deletes_the_stage(): void
    {
        $stage = Stage::factory()->create();

        $response = $this->delete(route('stages.destroy', $stage));

        $response->assertRedirect(route('stages.index'));

        $this->assertModelMissing($stage);
    }
}
