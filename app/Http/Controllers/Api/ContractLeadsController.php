<?php

namespace App\Http\Controllers\Api;

use App\Models\Contract;
use Illuminate\Http\Request;
use App\Http\Resources\LeadResource;
use App\Http\Controllers\Controller;
use App\Http\Resources\LeadCollection;

class ContractLeadsController extends Controller
{
    public function index(Request $request, Contract $contract): LeadCollection
    {
        $this->authorize('view', $contract);

        $search = $request->get('search', '');

        $leads = $contract
            ->leads()
            ->search($search)
            ->latest()
            ->paginate();

        return new LeadCollection($leads);
    }

    public function store(Request $request, Contract $contract): LeadResource
    {
        $this->authorize('create', Lead::class);

        $validated = $request->validate([
            'name' => ['required', 'max:255', 'string'],
            'phone' => ['required', 'max:255', 'string'],
            'phone2' => ['nullable', 'max:255', 'string'],
            'stage_id' => ['required', 'exists:stages,id'],
            'follow_date' => ['required', 'date'],
            'card_id' => ['nullable', 'exists:cards,id'],
        ]);

        $lead = $contract->leads()->create($validated);

        return new LeadResource($lead);
    }
}
