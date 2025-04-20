<?php
namespace App\Http\Controllers\Api;

use App\Models\Lead;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use App\Http\Resources\UserCollection;

class LeadUsersController extends Controller
{
    public function index(Request $request, Lead $lead): UserCollection
    {
        $this->authorize('view', $lead);

        $search = $request->get('search', '');

        $users = $lead
            ->users()
            ->search($search)
            ->latest()
            ->paginate();

        return new UserCollection($users);
    }

    public function store(Request $request, Lead $lead, User $user): Response
    {
        $this->authorize('update', $lead);

        $lead->users()->syncWithoutDetaching([$user->id]);

        return response()->noContent();
    }

    public function destroy(Request $request, Lead $lead, User $user): Response
    {
        $this->authorize('update', $lead);

        $lead->users()->detach($user);

        return response()->noContent();
    }
}
