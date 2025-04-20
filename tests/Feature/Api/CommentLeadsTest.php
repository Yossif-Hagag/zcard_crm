<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\Lead;
use App\Models\Comment;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CommentLeadsTest extends TestCase
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
    public function it_gets_comment_leads(): void
    {
        $comment = Comment::factory()->create();
        $lead = Lead::factory()->create();

        $comment->leads()->attach($lead);

        $response = $this->getJson(route('api.comments.leads.index', $comment));

        $response->assertOk()->assertSee($lead->name);
    }

    /**
     * @test
     */
    public function it_can_attach_leads_to_comment(): void
    {
        $comment = Comment::factory()->create();
        $lead = Lead::factory()->create();

        $response = $this->postJson(
            route('api.comments.leads.store', [$comment, $lead])
        );

        $response->assertNoContent();

        $this->assertTrue(
            $comment
                ->leads()
                ->where('leads.id', $lead->id)
                ->exists()
        );
    }

    /**
     * @test
     */
    public function it_can_detach_leads_from_comment(): void
    {
        $comment = Comment::factory()->create();
        $lead = Lead::factory()->create();

        $response = $this->deleteJson(
            route('api.comments.leads.store', [$comment, $lead])
        );

        $response->assertNoContent();

        $this->assertFalse(
            $comment
                ->leads()
                ->where('leads.id', $lead->id)
                ->exists()
        );
    }
}
