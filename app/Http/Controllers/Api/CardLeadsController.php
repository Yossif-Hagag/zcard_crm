<?php

namespace App\Http\Controllers\Api;

use App\Models\Card;
use Illuminate\Http\Request;
use App\Http\Resources\LeadResource;
use App\Http\Controllers\Controller;
use App\Http\Resources\LeadCollection;

class CardLeadsController extends Controller
{
    public function index(Request $request, Card $card): LeadCollection
    {
        $this->authorize('view', $card);

        $search = $request->get('search', '');

        $leads = $card
            ->leads()
            ->search($search)
            ->latest()
            ->paginate();

        return new LeadCollection($leads);
    }

    public function store(Request $request, Card $card): LeadResource
    {
        $this->authorize('create', Lead::class);

        $validated = $request->validate([
            'name' => ['required', 'max:255', 'string'],
            'phone' => ['required', 'max:255', 'string'],
            'phone2' => ['nullable', 'max:255', 'string'],
            'stage_id' => ['required', 'exists:stages,id'],
            'follow_date' => ['required', 'date'],
            'contract_id' => ['required', 'exists:contracts,id'],
        ]);

        $lead = $card->leads()->create($validated);

        return new LeadResource($lead);
    }
}
