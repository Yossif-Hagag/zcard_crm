<?php

namespace App\Http\Controllers\Api;

use App\Models\Lead;
use Illuminate\Http\Request;
use App\Http\Resources\DealResource;
use App\Http\Controllers\Controller;
use App\Http\Resources\DealCollection;

class LeadDealsController extends Controller
{
    public function index(Request $request, Lead $lead): DealCollection
    {
        $this->authorize('view', $lead);

        $search = $request->get('search', '');

        $deals = $lead
            ->deals()
            ->search($search)
            ->latest()
            ->paginate();

        return new DealCollection($deals);
    }

    public function store(Request $request, Lead $lead): DealResource
    {
        $this->authorize('create', Deal::class);

        $validated = $request->validate([
            'customer_name' => ['required', 'max:255', 'string'],
            'customer_phone' => ['required', 'max:255', 'string'],
            'customer_address' => ['required', 'max:255', 'string'],
            'cost' => ['required', 'numeric'],
            'deal_date' => ['required', 'date'],
            'delivery_date' => ['required', 'date'],
            'card_name' => ['required', 'max:255', 'json'],
        ]);

        $deal = $lead->deals()->create($validated);

        return new DealResource($deal);
    }
}
