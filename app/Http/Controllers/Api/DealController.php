<?php

namespace App\Http\Controllers\Api;

use App\Models\Deal;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Resources\DealResource;
use App\Http\Controllers\Controller;
use App\Http\Resources\DealCollection;
use App\Http\Requests\DealStoreRequest;
use App\Http\Requests\DealUpdateRequest;

class DealController extends Controller
{
    public function index(Request $request): DealCollection
    {
        $this->authorize('view-any', Deal::class);

        $search = $request->get('search', '');

        $deals = Deal::search($search)
            ->latest()
            ->paginate();

        return new DealCollection($deals);
    }

    public function store(DealStoreRequest $request): DealResource
    {
        $this->authorize('create', Deal::class);

        $validated = $request->validated();
        $validated['card_name'] = json_decode($validated['card_name'], true);

        $deal = Deal::create($validated);

        return new DealResource($deal);
    }

    public function show(Request $request, Deal $deal): DealResource
    {
        $this->authorize('view', $deal);

        return new DealResource($deal);
    }

    public function update(DealUpdateRequest $request, Deal $deal): DealResource
    {
        $this->authorize('update', $deal);

        $validated = $request->validated();

        $validated['card_name'] = json_decode($validated['card_name'], true);

        $deal->update($validated);

        return new DealResource($deal);
    }

    public function destroy(Request $request, Deal $deal): Response
    {
        $this->authorize('delete', $deal);

        $deal->delete();

        return response()->noContent();
    }
}
