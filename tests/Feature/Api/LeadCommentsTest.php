<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\Lead;
use App\Models\Comment;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class LeadCommentsTest extends TestCase
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
    public function it_gets_lead_comments(): void
    {
        $lead = Lead::factory()->create();
        $comment = Comment::factory()->create();

        $lead->comments()->attach($comment);

        $response = $this->getJson(route('api.leads.comments.index', $lead));

        $response->assertOk()->assertSee($comment->comment);
    }

    /**
     * @test
     */
    public function it_can_attach_comments_to_lead(): void
    {
        $lead = Lead::factory()->create();
        $comment = Comment::factory()->create();

        $response = $this->postJson(
            route('api.leads.comments.store', [$lead, $comment])
        );

        $response->assertNoContent();

        $this->assertTrue(
            $lead
                ->comments()
                ->where('comments.id', $comment->id)
                ->exists()
        );
    }

    /**
     * @test
     */
    public function it_can_detach_comments_from_lead(): void
    {
        $lead = Lead::factory()->create();
        $comment = Comment::factory()->create();

        $response = $this->deleteJson(
            route('api.leads.comments.store', [$lead, $comment])
        );

        $response->assertNoContent();

        $this->assertFalse(
            $lead
                ->comments()
                ->where('comments.id', $comment->id)
                ->exists()
        );
    }
}
