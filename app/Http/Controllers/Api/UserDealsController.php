<?php
namespace App\Http\Controllers\Api;

use App\Models\User;
use App\Models\Deal;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use App\Http\Resources\DealCollection;

class UserDealsController extends Controller
{
    public function index(Request $request, User $user): DealCollection
    {
        $this->authorize('view', $user);

        $search = $request->get('search', '');

        $deals = $user
            ->deals()
            ->search($search)
            ->latest()
            ->paginate();

        return new DealCollection($deals);
    }

    public function store(Request $request, User $user, Deal $deal): Response
    {
        $this->authorize('update', $user);

        $user->deals()->syncWithoutDetaching([$deal->id]);

        return response()->noContent();
    }

    public function destroy(Request $request, User $user, Deal $deal): Response
    {
        $this->authorize('update', $user);

        $user->deals()->detach($deal);

        return response()->noContent();
    }
}
