<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\CommentResource;
use App\Http\Resources\CommentCollection;

class UserCommentsController extends Controller
{
    public function index(Request $request, User $user): CommentCollection
    {
        $this->authorize('view', $user);

        $search = $request->get('search', '');

        $comments = $user
            ->comments()
            ->search($search)
            ->latest()
            ->paginate();

        return new CommentCollection($comments);
    }

    public function store(Request $request, User $user): CommentResource
    {
        $this->authorize('create', Comment::class);

        $validated = $request->validate([
            'comment' => ['required', 'max:255', 'string'],
        ]);

        $comment = $user->comments()->create($validated);

        return new CommentResource($comment);
    }
}
