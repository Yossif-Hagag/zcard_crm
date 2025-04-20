<?php
namespace App\Http\Controllers\Api;

use App\Models\Lead;
use App\Models\Comment;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use App\Http\Resources\LeadCollection;

class CommentLeadsController extends Controller
{
    public function index(Request $request, Comment $comment): LeadCollection
    {
        $this->authorize('view', $comment);

        $search = $request->get('search', '');

        $leads = $comment
            ->leads()
            ->search($search)
            ->latest()
            ->paginate();

        return new LeadCollection($leads);
    }

    public function store(
        Request $request,
        Comment $comment,
        Lead $lead
    ): Response {
        $this->authorize('update', $comment);

        $comment->leads()->syncWithoutDetaching([$lead->id]);

        return response()->noContent();
    }

    public function destroy(
        Request $request,
        Comment $comment,
        Lead $lead
    ): Response {
        $this->authorize('update', $comment);

        $comment->leads()->detach($lead);

        return response()->noContent();
    }
}
