<?php
namespace App\Http\Controllers\Api;

use App\Models\Deal;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use App\Http\Resources\UserCollection;

class DealUsersController extends Controller
{
    public function index(Request $request, Deal $deal): UserCollection
    {
        $this->authorize('view', $deal);

        $search = $request->get('search', '');

        $users = $deal
            ->users()
            ->search($search)
            ->latest()
            ->paginate();

        return new UserCollection($users);
    }

    public function store(Request $request, Deal $deal, User $user): Response
    {
        $this->authorize('update', $deal);

        $deal->users()->syncWithoutDetaching([$user->id]);

        return response()->noContent();
    }

    public function destroy(Request $request, Deal $deal, User $user): Response
    {
        $this->authorize('update', $deal);

        $deal->users()->detach($user);

        return response()->noContent();
    }
}
