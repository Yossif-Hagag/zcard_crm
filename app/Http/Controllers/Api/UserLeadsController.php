<?php
namespace App\Http\Controllers\Api;

use App\Models\User;
use App\Models\Lead;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use App\Http\Resources\LeadCollection;

class UserLeadsController extends Controller
{
    public function index(Request $request, User $user): LeadCollection
    {
        $this->authorize('view', $user);

        $search = $request->get('search', '');

        $leads = $user
            ->leads()
            ->search($search)
            ->latest()
            ->paginate();

        return new LeadCollection($leads);
    }

    public function store(Request $request, User $user, Lead $lead): Response
    {
        $this->authorize('update', $user);

        $user->leads()->syncWithoutDetaching([$lead->id]);

        return response()->noContent();
    }

    public function destroy(Request $request, User $user, Lead $lead): Response
    {
        $this->authorize('update', $user);

        $user->leads()->detach($lead);

        return response()->noContent();
    }
}
