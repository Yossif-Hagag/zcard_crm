<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\Stage;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class StageTest extends TestCase
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
    public function it_gets_stages_list(): void
    {
        $stages = Stage::factory()
            ->count(5)
            ->create();

        $response = $this->getJson(route('api.stages.index'));

        $response->assertOk()->assertSee($stages[0]->name);
    }

    /**
     * @test
     */
    public function it_stores_the_stage(): void
    {
        $data = Stage::factory()
            ->make()
            ->toArray();

        $response = $this->postJson(route('api.stages.store'), $data);

        $this->assertDatabaseHas('stages', $data);

        $response->assertStatus(201)->assertJsonFragment($data);
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

        $response = $this->putJson(route('api.stages.update', $stage), $data);

        $data['id'] = $stage->id;

        $this->assertDatabaseHas('stages', $data);

        $response->assertOk()->assertJsonFragment($data);
    }

    /**
     * @test
     */
    public function it_deletes_the_stage(): void
    {
        $stage = Stage::factory()->create();

        $response = $this->deleteJson(route('api.stages.destroy', $stage));

        $this->assertModelMissing($stage);

        $response->assertNoContent();
    }
}
