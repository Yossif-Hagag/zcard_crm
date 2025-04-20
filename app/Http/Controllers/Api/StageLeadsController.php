<?php

namespace App\Http\Controllers\Api;

use App\Models\Stage;
use Illuminate\Http\Request;
use App\Http\Resources\LeadResource;
use App\Http\Controllers\Controller;
use App\Http\Resources\LeadCollection;

class StageLeadsController extends Controller
{
    public function index(Request $request, Stage $stage): LeadCollection
    {
        $this->authorize('view', $stage);

        $search = $request->get('search', '');

        $leads = $stage
            ->leads()
            ->search($search)
            ->latest()
            ->paginate();

        return new LeadCollection($leads);
    }

    public function store(Request $request, Stage $stage): LeadResource
    {
        $this->authorize('create', Lead::class);

        $validated = $request->validate([
            'name' => ['required', 'max:255', 'string'],
            'phone' => ['required', 'max:255', 'string'],
            'phone2' => ['nullable', 'max:255', 'string'],
            'follow_date' => ['required', 'date'],
            'contract_id' => ['required', 'exists:contracts,id'],
            'card_id' => ['nullable', 'exists:cards,id'],
        ]);

        $lead = $stage->leads()->create($validated);

        return new LeadResource($lead);
    }
}
