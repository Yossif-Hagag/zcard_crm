<?php
namespace App\Http\Controllers\Api;

use App\Models\Lead;
use App\Models\Comment;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use App\Http\Resources\CommentCollection;

class LeadCommentsController extends Controller
{
    public function index(Request $request, Lead $lead): CommentCollection
    {
        $this->authorize('view', $lead);

        $search = $request->get('search', '');

        $comments = $lead
            ->comments()
            ->search($search)
            ->latest()
            ->paginate();

        return new CommentCollection($comments);
    }

    public function store(
        Request $request,
        Lead $lead,
        Comment $comment
    ): Response {
        $this->authorize('update', $lead);

        $lead->comments()->syncWithoutDetaching([$comment->id]);

        return response()->noContent();
    }

    public function destroy(
        Request $request,
        Lead $lead,
        Comment $comment
    ): Response {
        $this->authorize('update', $lead);

        $lead->comments()->detach($comment);

        return response()->noContent();
    }
}
