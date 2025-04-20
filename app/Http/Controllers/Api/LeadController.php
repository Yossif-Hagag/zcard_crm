<?php

namespace App\Http\Controllers\Api;

use App\Models\Lead;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Resources\LeadResource;
use App\Http\Controllers\Controller;
use App\Http\Resources\LeadCollection;
use App\Http\Requests\LeadStoreRequest;
use App\Http\Requests\LeadUpdateRequest;

class LeadController extends Controller
{
    public function index(Request $request): LeadCollection
    {
        $this->authorize('view-any', Lead::class);

        $search = $request->get('search', '');

        $leads = Lead::search($search)
            ->latest()
            ->paginate();

        return new LeadCollection($leads);
    }

    public function store(LeadStoreRequest $request): LeadResource
    {
        $this->authorize('create', Lead::class);

        $validated = $request->validated();

        $lead = Lead::create($validated);

        return new LeadResource($lead);
    }

    public function show(Request $request, Lead $lead): LeadResource
    {
        $this->authorize('view', $lead);

        return new LeadResource($lead);
    }

    public function update(LeadUpdateRequest $request, Lead $lead): LeadResource
    {
        $this->authorize('update', $lead);

        $validated = $request->validated();

        $lead->update($validated);

        return new LeadResource($lead);
    }

    public function destroy(Request $request, Lead $lead): Response
    {
        $this->authorize('delete', $lead);

        $lead->delete();

        return response()->noContent();
    }
}
